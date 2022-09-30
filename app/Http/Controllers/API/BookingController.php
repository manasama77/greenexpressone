<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Booking;
use App\Models\Voucher;
use App\Models\MasterArea;
use App\Models\LuggagePrice;
use Illuminate\Http\Request;
use App\Models\MasterSubArea;
use App\Models\MasterSpecialArea;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController;
use App\Models\BookingSequence;
use App\Models\Charter;
use App\Models\ScheduleShuttle;
use Carbon\Carbon;
use Exception;
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
                'date_departure'          => 'required|date',
                'from_master_area_id'     => 'required',
                'from_master_sub_area_id' => 'nullable',
                'to_master_area_id'       => 'required',
                'to_master_sub_area_id'   => 'nullable',
                'user_id'                 => 'required|exists:users,id',
                'qty_adult'               => 'required|integer|min_digits:0',
                'qty_baby'                => 'required|integer|min_digits:0',
                'special_request'         => 'required|boolean',
                'luggage_qty'             => 'required|integer|min_digits:0',
                'flight_number'           => 'nullable',
                'notes'                   => 'nullable',
                'voucher_code'            => 'nullable',
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

        $user_id        = Auth::user()->id;
        $total_person   = $request->qty_adult + $request->qty_baby;
        $promo_price    = 0;
        $voucher_id     = null;
        $discount_type  = null;
        $discount_value = 0;

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
                'schedule_shuttles.id',
                'from_master_area.name as from_master_area_name',
                'from_master_sub_area.name as from_master_sub_area_name',
                'to_master_area.name as to_master_area_name',
                'to_master_sub_area.name as to_master_sub_area_name',
                'schedule_shuttles.*',
            ])
                ->where([
                    'schedule_shuttles.is_active' => true,
                    'schedule_shuttles.id'        => $request->schedule_id,
                ])
                ->leftJoin('master_areas as from_master_area', 'from_master_area.id', '=', 'schedule_shuttles.from_master_area_id')
                ->leftJoin('master_sub_areas as from_master_sub_area', 'from_master_sub_area.id', '=', 'schedule_shuttles.from_master_sub_area_id')
                ->leftJoin('master_areas as to_master_area', 'to_master_area.id', '=', 'schedule_shuttles.to_master_area_id')
                ->leftJoin('master_sub_areas as to_master_sub_area', 'to_master_sub_area.id', '=', 'schedule_shuttles.to_master_sub_area_id')
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
                    (float) $promo_price = ($total_price * $discount_value) / 100;
                } else {
                    (float) $promo_price = $total_price - $discount_value;
                }

                (float) $total_price = $total_price - $promo_price;
            }

            $booking_number = $this->generate_booking_number();

            $booking                            = new Booking();
            $booking->booking_number            = $booking_number;
            $booking->schedule_id               = $request->schedule_id;
            $booking->from_master_area_id       = $schedules->from_master_area_id;
            $booking->from_master_area_name     = $schedules->from_master_area_name;
            $booking->from_master_sub_area_id   = $schedules->from_master_sub_area_id;
            $booking->from_master_sub_area_name = ($schedules->from_master_sub_area_name) ?? null;
            $booking->to_master_area_id         = $schedules->to_master_area_id;
            $booking->to_master_area_name       = $schedules->to_master_area_name;
            $booking->to_master_sub_area_id     = $schedules->to_master_sub_area_id;
            $booking->to_master_sub_area_name   = ($schedules->to_master_sub_area_name) ?? null;
            $booking->vehicle_name              = $schedules->vehicle_name;
            $booking->vehicle_number            = $schedules->vehicle_number;
            $booking->datetime_departure        = $request->date_departure . " " . $schedules->time_departure;
            $booking->schedule_type             = $request->schedule_type;
            $booking->user_id                   = $user_id;
            $booking->qty_adult                 = $request->qty_adult;
            $booking->qty_baby                  = $request->qty_baby;
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

            return $this->sendResponse($booking, 'success');
        } else {
            // jika jenis pemberangkatan adalah charter
            return response()->json("charter");

            $schedules = Charter::where([
                'is_available' => true,
                'from_type'    => $request->from_type,
                'id'           => $request->schedule_id,
            ])->first();
            if (!$schedules) {
                return $this->sendError('Charter data not found, please try again', []);
            }
        }
    }

    public function show(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'from_date'      => 'required|date',
                'to_date'        => 'required|date',
                'booking_status' => 'required|in:pending,active,expired',
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

        $user_id        = Auth::user()->id;
        $from_date      = $request->from_date;
        $to_date        = $request->to_date;
        $booking_status = $request->booking_status;

        $bookings = Booking::whereRaw(
            "user_id = ? AND booking_status = ? AND DATE(datetime_departure) >= ? AND DATE(datetime_departure) <= ?",
            [$user_id, $booking_status, $from_date, $to_date]
        )->get();

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
}
