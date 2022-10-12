<?php

namespace App\Http\Controllers\API;

use App\Models\Booking;
use App\Models\Voucher;
use App\Models\MasterArea;
use Illuminate\Http\Request;
use App\Models\MasterSubArea;
use App\Models\MasterSpecialArea;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController;
use App\Models\BookingSequence;
use App\Models\Charter;
use App\Models\ScheduleShuttle;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class BookingController extends BaseController
{
    public function index(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'schedule_type'           => 'required|in:shuttle,charter',
                'from_type'               => 'required|in:airport,district',
                'schedule_id'             => 'required|integer',
                'date_departure'          => 'required|date|after_or_equal:today|date_format:Y-m-d',
                'from_master_area_id'     => 'required',
                'from_master_sub_area_id' => 'nullable',
                'to_master_area_id'       => 'required',
                'to_master_sub_area_id'   => 'nullable',
                'qty_adult'               => 'required|integer|min_digits:0',
                'qty_baby'                => 'required|integer|min_digits:0',
                'special_request'         => 'required|boolean',
                'luggage_qty'             => 'required|integer|min_digits:0',
                'flight_number'           => 'nullable',
                'notes'                   => 'nullable',
                'voucher_code'            => 'nullable',
                'customer_phone'          => 'required|min:3|max:50',
                'customer_name'           => 'required|min:3|max:255',
                'passanger_phone'         => 'required|min:3|max:50',
                'passanger_name'          => 'required|min:3|max:255',
            ],
            [
                'exists' => ':attribute not found',
                'in'     => ':attribute only accept value :values'
            ]
        );

        if ($validator->fails()) {
            $errors        = $validator->errors();
            $error_message = "";
            foreach ($validator->failed() as $key => $val) {
                if ($errors->first($key)) {
                    $error_message = $errors->first($key);
                }
            }
            return $this->sendError($error_message, null);
        }

        if ($request->schedule_type == "shuttle") {
            if ($request->qty_adult == 0) {
                return $this->sendError("qty adult minimum 1", null);
            }

            if ($request->from_type == "airport") {
                if (!$request->to_master_sub_area_id) {
                    return $this->sendError("to_master_sub_area_id is required", null);
                }
            } else {
                if (!$request->from_master_sub_area_id) {
                    return $this->sendError("from_master_sub_area_id is required", null);
                }
            }
        }

        $customer_phone  = $request->customer_phone;
        $customer_name   = $request->customer_name;
        $passanger_phone = $request->passanger_phone;
        $passanger_name  = $request->passanger_name;
        $total_person    = $request->qty_adult + $request->qty_baby;
        $promo_price     = 0;
        $voucher_id      = null;
        $discount_type   = null;
        $discount_value  = 0;

        // voucher & promo price
        if ($request->voucher_code) {
            $vouchers = Voucher::select([
                'id',
                'discount_type',
                'discount_value',
            ])->where([
                'is_active' => true,
                'code'      => $request->voucher_code,
            ])->first();

            if (!$vouchers) {
                return $this->sendError('Voucher not found', null);
            }

            $voucher_id     = $vouchers->id;
            $discount_type  = $vouchers->discount_type;
            $discount_value = (float) $vouchers->discount_value;
        }

        if ($request->schedule_type == "shuttle") {
            // jika jenis pemberangkatan adalah shuttle
            $schedules = ScheduleShuttle::select([
                'from_master_area.name as from_master_area_name',
                'to_master_area.name as to_master_area_name',
                'schedule_shuttles.*',
            ])
                ->where([
                    'schedule_shuttles.is_active' => true,
                    'schedule_shuttles.id'        => $request->schedule_id,
                ])
                ->leftJoin('master_areas as from_master_area', 'from_master_area.id', '=', 'schedule_shuttles.from_master_area_id')
                ->leftJoin('master_areas as to_master_area', 'to_master_area.id', '=', 'schedule_shuttles.to_master_area_id')
                ->first();

            if (!$schedules) {
                return $this->sendError('Schedule not found, please try again', null);
            }

            $can_book = $this->count_seat_avail($schedules->id, $schedules->total_seat, $total_person);
            if ($can_book == false) {
                return $this->sendError('No seat left', null);
            }

            $luggage_base_price = (float) $schedules->luggage_price;
            $luggage_price      = $luggage_base_price * $request->luggage_qty;

            $extra_price = 0;
            if ($request->special_request) {
                $extra_prices = MasterSpecialArea::select([
                    'first_person_price',
                    'extra_person_price'
                ])->where('is_active', true);

                if ($request->from_type == "airport") {
                    $extra_prices->where('master_sub_area_id', $request->to_master_sub_area_id);
                } else {
                    $extra_prices->where('master_sub_area_id', $request->from_master_sub_area_id);
                }

                foreach ($extra_prices->get() as $key) {
                    $first_person_price = (float) $key->first_person_price;
                    $extra_person_price = (float) $key->extra_person_price;

                    if ($total_person == 1) {
                        $extra_price = $first_person_price;
                    } else {
                        $extra_price = (($total_person - 1) * $extra_person_price) + $first_person_price;
                    }
                }
            }

            $base_price  = $total_person * $schedules->price;
            $total_price = $base_price + $luggage_price + $extra_price;

            if ($voucher_id) {
                if ($discount_type == "percentage") {
                    $promo_price = ($total_price * $discount_value) / 100;
                } else {
                    $promo_price = $total_price - $discount_value;
                }

                $total_price = $total_price - $promo_price;
            }

            $qty_adult = $request->qty_adult;
            $qty_baby  = $request->qty_baby;
        } else {
            // jika jenis pemberangkatan adalah charter
            $total_person = 1;

            $schedules = Charter::select([
                'from_master_area.name as from_master_area_name',
                'to_master_area.name as to_master_area_name',
                'charters.*',
            ])
                ->where([
                    'charters.is_available' => true,
                    'charters.id'           => $request->schedule_id,
                ])
                ->leftJoin('master_areas as from_master_area', 'from_master_area.id', '=', 'charters.from_master_area_id')
                ->leftJoin('master_areas as to_master_area', 'to_master_area.id', '=', 'charters.to_master_area_id')
                ->first();
            if (!$schedules) {
                return $this->sendError('Charter data not found, please try again', null);
            }

            $luggage_price = 0;
            $extra_price   = 0;
            $base_price    = $schedules->price;
            $total_price   = $base_price;

            if ($voucher_id) {
                if ($discount_type == "percentage") {
                    $promo_price = ($total_price * $discount_value) / 100;
                } else {
                    $promo_price = $total_price - $discount_value;
                }

                $total_price = $total_price - $promo_price;
            }

            $qty_adult = 0;
            $qty_baby  = 0;
        }

        $from_master_sub_area_name = null;
        $to_master_sub_area_name   = null;

        if ($schedules->from_master_area_id != $request->from_master_area_id) {
            return $this->sendError('from_master_area_id schedule did not match', null);
        }

        if ($schedules->to_master_area_id != $request->to_master_area_id) {
            return $this->sendError('to_master_area_id schedule did not match', null);
        }

        if ($request->from_type == "airport") {
            if ($request->from_master_sub_area_id) {
                $from_sub = MasterSubArea::where('id', $request->from_master_sub_area_id)->where('master_area_id', $schedules->from_master_area_id)->first();
                if (!$from_sub) {
                    return $this->sendError('from sub area not found', null);
                }
                $from_master_sub_area_name = $from_sub->name;
            }

            if ($request->to_master_sub_area_id != $schedules->to_master_sub_area_id) {
                return $this->sendError('to sub area schedule did not match', null);
            }

            $to_sub = MasterSubArea::where('id', $request->to_master_sub_area_id)->where('master_area_id', $schedules->to_master_area_id)->first();
            if (!$to_sub) {
                return $this->sendError('to sub area not found', null);
            }
            $to_master_sub_area_name = $to_sub->name;
        } else {
            if ($request->to_master_sub_area_id) {
                $to_sub = MasterSubArea::where('id', $request->to_master_sub_area_id)->where('master_area_id', $schedules->to_master_area_id)->first();
                if (!$to_sub) {
                    return $this->sendError('to sub area not found', null);
                }
                $to_master_sub_area_name = $to_sub->name;
            }

            if ($request->from_master_sub_area_id != $schedules->from_master_sub_area_id) {
                return $this->sendError('from sub area schedule did not match', null);
            }

            $from_sub = MasterSubArea::where('id', $request->from_master_sub_area_id)->where('master_area_id', $schedules->from_master_area_id)->first();
            if (!$from_sub) {
                return $this->sendError('from sub area not found', null);
            }
            $from_master_sub_area_name = $from_sub->name;
        }

        $booking_number = $this->generate_booking_number();

        $booking                            = new Booking();
        $booking->booking_number            = $booking_number;
        $booking->schedule_id               = $request->schedule_id;
        $booking->from_master_area_id       = $schedules->from_master_area_id;
        $booking->from_master_area_name     = $schedules->from_master_area_name;
        $booking->from_master_sub_area_id   = $request->from_master_sub_area_id;
        $booking->from_master_sub_area_name = $from_master_sub_area_name;
        $booking->to_master_area_id         = $schedules->to_master_area_id;
        $booking->to_master_area_name       = $schedules->to_master_area_name;
        $booking->to_master_sub_area_id     = $request->to_master_sub_area_id;
        $booking->to_master_sub_area_name   = $to_master_sub_area_name;
        $booking->vehicle_name              = $schedules->vehicle_name;
        $booking->vehicle_number            = $schedules->vehicle_number;
        $booking->datetime_departure        = $request->date_departure . " " . $schedules->time_departure;
        $booking->schedule_type             = $request->schedule_type;
        $booking->customer_phone            = $customer_phone;
        $booking->customer_name             = $customer_name;
        $booking->passanger_phone           = $passanger_phone;
        $booking->passanger_name            = $passanger_name;
        $booking->qty_adult                 = $qty_adult;
        $booking->qty_baby                  = $qty_baby;
        $booking->special_request           = $request->special_request;
        $booking->flight_number             = ($request->flight_number) ?? null;
        $booking->notes                     = ($request->notes) ?? null;
        $booking->luggage_qty               = ($request->luggage_qty) ?? 0;
        $booking->luggage_price             = $luggage_price;
        $booking->extra_price               = $extra_price;
        $booking->voucher_id                = $voucher_id;
        $booking->promo_price               = $promo_price;
        $booking->base_price                = $base_price;
        $booking->total_price               = $total_price;
        $booking->booking_status            = 'pending';
        $booking->payment_status            = 'waiting';
        $booking->payment_method            = null;
        $booking->payment_token             = null;
        $booking->total_payment             = $total_price;
        $booking->save();

        $booking_id = $booking->id;
        $res        = Booking::where('id', $booking_id)->first();

        $datetime_departure = Carbon::createFromFormat('Y-m-d H:i:s', $res->datetime_departure)->format('Y-m-d H:i:s');
        if ($request->schedule_type == "charter") {
            $datetime_departure = Carbon::createFromFormat('Y-m-d H:i:s', $res->datetime_departure)->format('Y-m-d');

            $charters               = Charter::find($request->schedule_id);
            $charters->is_available = false;
            $charters->save();
        }

        $result = [
            'id'                        => $res->id,
            'booking_number'            => $res->booking_number,
            'schedule_id'               => $res->schedule_id,
            'from_master_area_id'       => $res->from_master_area_id,
            'from_master_area_name'     => $res->from_master_area_name,
            'from_master_sub_area_id'   => $res->from_master_sub_area_id,
            'from_master_sub_area_name' => $res->from_master_sub_area_name,
            'to_master_area_id'         => $res->to_master_area_id,
            'to_master_area_name'       => $res->to_master_area_name,
            'to_master_sub_area_id'     => $res->to_master_sub_area_id,
            'to_master_sub_area_name'   => $res->to_master_sub_area_name,
            'vehicle_name'              => $res->vehicle_name,
            'vehicle_number'            => $res->vehicle_number,
            'datetime_departure'        => $datetime_departure,
            'schedule_type'             => $res->schedule_type,
            'customer_phone'            => $res->customer_phone,
            'customer_name'             => $res->customer_name,
            'passanger_phone'           => $res->passanger_phone,
            'passanger_name'            => $res->passanger_name,
            'qty_adult'                 => (int) $res->qty_adult,
            'qty_baby'                  => (int) $res->qty_baby,
            'special_request'           => $res->special_request,
            'flight_number'             => $res->flight_number,
            'notes'                     => $res->notes,
            'luggage_qty'               => (int) $res->luggage_qty,
            'luggage_price'             => (float) $res->luggage_price,
            'extra_price'               => (float) $res->extra_price,
            'voucher_id'                => $res->voucher_id,
            'promo_price'               => (float) $res->promo_price,
            'base_price'                => (float) $res->base_price,
            'total_price'               => (float) $res->total_price,
            'booking_status'            => $res->booking_status,
            'payment_status'            => $res->payment_status,
            'payment_method'            => $res->payment_method,
            'payment_token'             => $res->payment_token,
            'total_payment'             => (float) $res->total_payment,
            'created_at'                => Carbon::createFromFormat('Y-m-d H:i:s', $res->created_at)->format('Y-m-d H:i:s'),
        ];

        return $this->sendResponse($result, 'success');
    }

    public function show(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'from_date' => 'required|date',
                'to_date'   => 'required|date',
                'phone'     => 'required',
            ],
            [
                'in' => ':attribute only accept value :values'
            ]
        );

        if ($validator->fails()) {
            $errors        = $validator->errors();
            $error_message = "";
            foreach ($validator->failed() as $key => $val) {
                if ($errors->first($key)) {
                    $error_message = $errors->first($key);
                }
            }
            return $this->sendError($error_message, null);
        }

        $phone     = $request->phone;
        $from_date = $request->from_date;
        $to_date   = $request->to_date;

        $bookings = Booking::whereDate('datetime_departure', '>=', $from_date)->whereDate('datetime_departure', '<=', $to_date)->where(function ($query) use ($phone) {
            $query->where('customer_phone', '=', $phone)->orWhere('passanger_phone', '=', $phone);
        })->get();

        if ($bookings->count() == 0) {
            return $this->sendError("Data not found", null);
        }

        return $this->sendResponse($bookings, 'success');
    }

    public function check_booking_number(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'booking_number' => 'required|exists:bookings,booking_number',
            ],
            [
                'exists' => ':attribute ' . $request->booking_number . ' not found'
            ]
        );

        if ($validator->fails()) {
            $errors        = $validator->errors();
            $error_message = "";
            foreach ($validator->failed() as $key => $val) {
                if ($errors->first($key)) {
                    $error_message = $errors->first($key);
                }
            }
            return $this->sendError($error_message, null);
        }

        $booking_number = $request->booking_number;

        $bookings = Booking::where('booking_number', $booking_number)->get();
        return $this->sendResponse($bookings, 'success');
    }

    public function get_list_from_departure(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'from_type' => 'required|in:airport,district',
                'keyword'   => 'nullable',
            ],
            [
                'in' => ':attribute only accept value :values'
            ]
        );

        if ($validator->fails()) {
            $errors        = $validator->errors();
            $error_message = "";
            foreach ($validator->failed() as $key => $val) {
                if ($errors->first($key)) {
                    $error_message = $errors->first($key);
                }
            }
            return $this->sendError($error_message, null);
        }

        $from_type = $request->from_type;
        $keyword   = ($request->keyword) ?? null;

        if ($from_type == "airport") {
            $area_type = "departure";
        } else {
            $area_type = "arrival";
        }

        $master_areas = MasterArea::with('master_sub_area')->where([
            'is_active' => true,
            'area_type' => $area_type,
        ])->orderBy('name', 'asc');

        if ($keyword) {
            $master_areas->whereHas('master_sub_area', function (Builder $query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
                $query->where('is_active', true);
            });
        }

        if ($master_areas->count() == 0) {
            return $this->sendError('Data Empty', null);
        }

        $data = [];
        foreach ($master_areas->get() as $key_area) {
            $id_area   = $key_area->id;
            $name_area = $key_area->name;

            $nested = [
                'id'       => $id_area,
                'name'     => $name_area,
                'sub_area' => [],
            ];

            $master_sub_areas = MasterSubArea::where([
                'is_active'      => true,
                'master_area_id' => $id_area,
            ])->orderBy('name', 'asc');

            if ($keyword) {
                $master_sub_areas->where('name', 'like', '%' . $keyword . '%');
            }

            if ($master_sub_areas->count() == 0) {
                return $this->sendError('Data Empty', null);
            }

            foreach ($master_sub_areas->get() as $key_sub) {
                $id_sub   = $key_sub->id;
                $name_sub = $key_sub->name;

                $nested_sub = [
                    'id'        => $id_sub,
                    'name'      => $name_sub,
                    'parent_id' => $id_area,
                ];
                array_push($nested['sub_area'], $nested_sub);
            }

            array_push($data, $nested);
        }

        return $this->sendResponse($data, 'success');
    }

    public function get_list_to_destination(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'from_type' => 'required|in:airport,district',
                'keyword'   => 'nullable',
            ],
            [
                'in' => ':attribute only accept value :values'
            ]
        );

        if ($validator->fails()) {
            $errors        = $validator->errors();
            $error_message = "";
            foreach ($validator->failed() as $key => $val) {
                if ($errors->first($key)) {
                    $error_message = $errors->first($key);
                }
            }
            return $this->sendError($error_message, null);
        }

        $from_type = $request->from_type;
        $keyword   = ($request->keyword) ?? null;

        if ($from_type == "airport") {
            $area_type = "arrival";
        } else {
            $area_type = "departure";
        }

        $master_areas = MasterArea::with('master_sub_area')->where([
            'is_active' => true,
            'area_type' => $area_type,
        ])->orderBy('name', 'asc');

        if ($keyword) {
            $master_areas->whereHas('master_sub_area', function (Builder $query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%');
                $query->where('is_active', true);
            });
        }

        if ($master_areas->count() == 0) {
            return $this->sendError('Data Empty', null);
        }

        $data = [];
        foreach ($master_areas->get() as $key_area) {
            $id_area   = $key_area->id;
            $name_area = $key_area->name;

            $nested = [
                'id'       => $id_area,
                'name'     => $name_area,
                'sub_area' => [],
            ];

            $master_sub_areas = MasterSubArea::where([
                'is_active'      => true,
                'master_area_id' => $id_area,
            ])->orderBy('name', 'asc');

            if ($keyword) {
                $master_sub_areas->where('name', 'like', '%' . $keyword . '%');
            }

            if ($master_sub_areas->count() == 0) {
                return $this->sendError('Data Empty', null);
            }

            foreach ($master_sub_areas->get() as $key_sub) {
                $id_sub   = $key_sub->id;
                $name_sub = $key_sub->name;

                $nested_sub = [
                    'id'        => $id_sub,
                    'name'      => $name_sub,
                    'parent_id' => $id_area,
                ];
                array_push($nested['sub_area'], $nested_sub);
            }

            array_push($data, $nested);
        }

        return $this->sendResponse($data, 'success');
    }

    public function get_schedule_shuttles(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'date_booking'            => 'required|date',
                'qty_adult'               => 'required|integer|min_digits:0',
                'qty_baby'                => 'required|integer|min_digits:0',
                'from_master_area_id'     => 'required',
                'from_master_sub_area_id' => 'nullable',
                'to_master_area_id'       => 'required',
                'to_master_sub_area_id'   => 'nullable',
            ]
        );

        if ($validator->fails()) {
            $errors        = $validator->errors();
            $error_message = "";
            foreach ($validator->failed() as $key => $val) {
                if ($errors->first($key)) {
                    $error_message = $errors->first($key);
                }
            }
            return $this->sendError($error_message, null);
        }

        $schedules = ScheduleShuttle::select([
            'schedule_shuttles.id',
            'from_master_area.name as from_master_area_name',
            'from_master_sub_area.name as from_master_sub_area_name',
            'to_master_area.name as to_master_area_name',
            'to_master_sub_area.name as to_master_sub_area_name',
            'schedule_shuttles.vehicle_name',
            'schedule_shuttles.vehicle_number',
            'schedule_shuttles.time_departure',
            'schedule_shuttles.photo',
            'schedule_shuttles.price',
            'schedule_shuttles.driver_contact',
            'schedule_shuttles.notes',
            'schedule_shuttles.total_seat',
            'schedule_shuttles.luggage_price',
            DB::raw("
                ifnull(
                (select (sum(bookings.qty_adult) + sum(bookings.qty_baby)) from bookings where bookings.schedule_id = schedule_shuttles.id and DATE(bookings.datetime_departure) = '" . $request->date_booking . "' group by bookings.schedule_id)
                , 0) as seat_booked
            ")
        ])
            ->leftJoin('master_areas as from_master_area', 'from_master_area.id', '=', 'schedule_shuttles.from_master_area_id')
            ->leftJoin('master_sub_areas as from_master_sub_area', 'from_master_sub_area.id', '=', 'schedule_shuttles.from_master_sub_area_id')
            ->leftJoin('master_areas as to_master_area', 'to_master_area.id', '=', 'schedule_shuttles.to_master_area_id')
            ->leftJoin('master_sub_areas as to_master_sub_area', 'to_master_sub_area.id', '=', 'schedule_shuttles.to_master_sub_area_id')
            ->where([
                'schedule_shuttles.is_active'               => true,
                'schedule_shuttles.from_master_area_id'     => $request->from_master_area_id,
                'schedule_shuttles.from_master_sub_area_id' => $request->from_master_sub_area_id,
                'schedule_shuttles.to_master_area_id'       => $request->to_master_area_id,
                'schedule_shuttles.to_master_sub_area_id'   => $request->to_master_sub_area_id,
            ])->where('time_departure', '>=', Carbon::now()->format('H:i:s'))->get();

        if ($schedules->count() == 0) {
            return $this->sendError('Data Empty', null, 200);
        }

        $data = [];
        foreach ($schedules as $key) {

            $is_available = true;
            if ($key->total_seat - $key->seat_booked <= 0) {
                $is_available = false;
            } elseif (($key->seat_booked + $request->qty_adult + $request->qty_baby) > $key->total_seat) {
                $is_available = false;
            }

            $nested['id']                        = $key->id;
            $nested['from_master_area_name']     = $key->from_master_area_name;
            $nested['from_master_sub_area_name'] = $key->from_master_sub_area_name;
            $nested['to_master_area_name']       = $key->to_master_area_name;
            $nested['to_master_sub_area_name']   = $key->to_master_sub_area_name;
            $nested['vehicle_name']              = $key->vehicle_name;
            $nested['vehicle_number']            = $key->vehicle_number;
            $nested['time_departure']            = $key->time_departure;
            $nested['photo']                     = $key->photo;
            $nested['price']                     = (float) $key->price;
            $nested['driver_contact']            = $key->driver_contact;
            $nested['notes']                     = $key->notes;
            $nested['total_seat']                = $key->total_seat;
            $nested['luggage_price']             = (float) $key->luggage_price;
            $nested['total_seat_used']           = (int) $key->seat_booked;
            $nested['is_available']              = $is_available;
            array_push($data, $nested);
        }

        return $this->sendResponse($data, 'success');
    }

    public function get_avail_charter(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'from_master_area_id'     => 'required',
                'from_master_sub_area_id' => 'nullable',
                'to_master_area_id'       => 'required',
                'to_master_sub_area_id'   => 'nullable',
            ]
        );

        if ($validator->fails()) {
            $errors        = $validator->errors();
            $error_message = "";
            foreach ($validator->failed() as $key => $val) {
                if ($errors->first($key)) {
                    $error_message = $errors->first($key);
                }
            }
            return $this->sendError($error_message, null);
        }

        $schedules = Charter::where([
            'is_available'            => true,
            'from_master_area_id'     => $request->from_master_area_id,
            'from_master_sub_area_id' => $request->from_master_sub_area_id,
            'to_master_area_id'       => $request->to_master_area_id,
            'to_master_sub_area_id'   => $request->to_master_sub_area_id,
        ])->get();

        if ($schedules->count() == 0) {
            return $this->sendError('Data Empty', null);
        }

        return $this->sendResponse($schedules, 'success');
    }

    private function generate_booking_number()
    {
        $seq = BookingSequence::where([
            'date_sequence' => Carbon::now()->format('Y-m-d'),
        ])->first();

        if ($seq) {
            $current_sequence = $seq->current_sequence + 1;

            //update sequences
            $up                   = BookingSequence::find($seq->id);
            $up->current_sequence = $current_sequence;
            $up->save();
        } else {
            $current_sequence = 1;

            // store new sequences
            $booking_sequences                   = new BookingSequence();
            $booking_sequences->date_sequence    = Carbon::now()->format('Y-m-d');
            $booking_sequences->current_sequence = $current_sequence;
            $booking_sequences->save();
        }

        $now = Carbon::now();
        $prefix = "GEO";
        $year = $now->format('y');
        $unique = 0;

        switch ($current_sequence) {
            case ($current_sequence < 10):
                $unique = "000" . $current_sequence;
                break;
            case ($current_sequence < 100):
                $unique = "00" . $current_sequence;
                break;
            case ($current_sequence < 1000):
                $unique = "0" . $current_sequence;
                break;
            default:
                $unique = $current_sequence;
                break;
        }

        return $prefix . $year . $unique;
    }

    private function count_seat_avail($schedule_id, $total_seat, $total_person)
    {
        $sum_seat_used = Booking::where([
            'schedule_id' => $schedule_id,
            'schedule_type' => 'shuttle',
        ])
            ->whereIn('booking_status', ['pending', 'active'])
            ->whereIn('payment_status', ['waiting', 'paid'])
            ->get();

        $sum_qty_adult = $sum_seat_used->sum('qty_adult');
        $sum_qty_baby  = $sum_seat_used->sum('qty_baby');

        $remaining_seat = $total_seat - $sum_qty_adult - $sum_qty_baby;

        $result = ($remaining_seat >= $total_person) ? true : false;

        return $result;
    }

    public function get_special_area(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'master_sub_area_id' => 'required',
            ],
        );

        if ($validator->fails()) {
            $errors        = $validator->errors();
            $error_message = "";
            foreach ($validator->failed() as $key => $val) {
                if ($errors->first($key)) {
                    $error_message = $errors->first($key);
                }
            }
            return $this->sendError($error_message, null);
        }

        $master_sub_areas = MasterSubArea::where('id', $request->master_sub_area_id)->where('is_active', true)->first();
        if (!$master_sub_areas) {
            return $this->sendError('Master Sub Area Not Found', null);
        }

        $master_special_areas = MasterSpecialArea::where('master_sub_area_id', $request->master_sub_area_id)->where('is_active', true)->first();
        if (!$master_special_areas) {
            return $this->sendError('Master Special Area Not Found', null);
        }

        $data = [
            'id'                 => $master_special_areas->id,
            'first_person_price' => $master_special_areas->first_person_price,
            'extra_person_price' => $master_special_areas->extra_person_price,
        ];

        return $this->sendResponse($data, 'success');
    }
}
