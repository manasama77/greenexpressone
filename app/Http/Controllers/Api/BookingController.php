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
                'schedule_type'             => 'required|in:shuttle,charter',
                'from_type'                 => 'required|in:airport,district',
                'schedule_id'               => 'required|integer',
                'date_departure'            => 'required|date',
                'from_master_area_name'     => 'required',
                'from_master_sub_area_name' => 'nullable',
                'to_master_area_name'       => 'required',
                'to_master_sub_area_name'   => 'nullable',
                'user_id'                   => 'required|exists:users,id',
                'qty_adult'                 => 'required|integer|min_digits:0',
                'qty_baby'                  => 'required|integer|min_digits:0',
                'special_request'           => 'required|boolean',
                'luggage_qty'               => 'required|integer|min_digits:0',
                'flight_number'             => 'nullable',
                'notes'                     => 'nullable',
                'voucher_code'              => 'nullable',
            ],
            [
                'exists' => ':attribute not found',
                'in'     => ':attribute only accept value :values'
            ]
        );

        if ($validator->stopOnFirstFailure()->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 400);
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
                return $this->sendError('Validation Error.', ["voucher_code" => ["Voucher not found"]], 400);
            }

            $voucher_id     = $vouchers->id;
            $discount_type  = $vouchers->discount_type;
            $discount_value = (float) $vouchers->discount_value;
        }

        if ($request->schedule_type == "shuttle") {
            // jika jenis pemberangkatan adalah shuttle
            $schedules = ScheduleShuttle::where([
                'is_active' => true,
                'from_type' => $request->from_type,
                'id'        => $request->schedule_id,
            ])->first();
            if (!$schedules) {
                return $this->sendError('Schedule not found, please try again', [], 404);
            }

            if ($request->from_type == "airport") {
                $froms = MasterArea::where([
                    'is_active' => true,
                    'area_type' => 'departure',
                    'id'        => $schedules->from_id,
                ])->first();
                if (!$froms) {
                    return $this->sendError('From area not found, please try again', [], 404);
                }

                $tos = MasterSubArea::where([
                    'is_active' => true,
                    'id'        => $schedules->to_id,
                ])->first();
                if (!$tos) {
                    return $this->sendError('To area not found, please try again', [], 404);
                }
            } else {
                $froms = MasterSubArea::where([
                    'is_active' => true,
                    'id'        => $schedules->from_id,
                ])->first();
                if (!$froms) {
                    return $this->sendError('From area not found, please try again', [], 404);
                }

                $tos = MasterSubArea::where([
                    'is_active' => true,
                    'id'        => $schedules->to_id,
                ])->first();
                if (!$tos) {
                    return $this->sendError('To area not found, please try again', [], 404);
                }
            }

            $luggage_base_price = (float) $schedules->luggage_price;
            $luggage_price      = $luggage_base_price * $request->luggage_qty;

            $extra_price = 0;
            if ($request->special_request) {
                $extra_prices = MasterSpecialArea::select([
                    'first_person_price',
                    'extra_person_price'
                ])->where([
                    'is_active'          => true,
                    'master_sub_area_id' => $tos->id,
                ])->get();

                foreach ($extra_prices as $key) {
                    $first_person_price = (float) $key->first_person_price;
                    $extra_person_price = (float) $key->extra_person_price;

                    if ($request->qty_adult == 1) {
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

            $booking                            = new Booking();
            $booking->schedule_id               = $request->schedule_id;
            $booking->from_master_area_name     = $froms->name;
            $booking->from_master_sub_area_name = ($request->from_master_sub_area_name) ?? null;
            $booking->to_master_area_name       = $request->to_master_area_name;
            $booking->to_master_sub_area_name   = ($request->to_master_sub_area_name) ?? null;
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
                return $this->sendError('Charter data not found, please try again', [], 404);
            }
        }
    }

    public function get_list_from_destination(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'from_type' => 'required|in:airport,district',
                'keyword'  => 'nullable',
            ],
            [
                'in' => ':attribute only accept value :values'
            ]
        );

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 400);
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
            return $this->sendError('Data Empty', [], 404);
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
                return $this->sendError('Data Empty', [], 404);
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
        $keyword = $request->keyword;

        $master_areas = MasterArea::where([
            'is_active' => true,
            'area_type' => 'arrival',
        ])->orderBy('name', 'asc');

        if ($keyword) {
            $master_areas->where('is_active', true);
            $master_areas->where('area_type', 'arrival');
            $master_areas->whereExists(function ($query) use ($keyword) {
                $query->select(DB::raw(1))->from('master_sub_areas')->whereColumn('master_sub_areas.master_area_id', 'master_areas.id')->where('master_sub_areas.is_active', 'yes')->where('master_sub_areas.name', 'like', '%' . $keyword . '%');
            });
        }

        if ($master_areas->count() == 0) {
            return $this->sendError('Data Empty', [], 404);
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
                'from_type' => 'required|in:airport,district',
                'from_id'   => 'required',
                'to_id'     => 'required',
            ],
            [
                'in' => ':attribute only accept value :values'
            ]
        );

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        $schedules = ScheduleShuttle::where([
            'is_active' => true,
            'from_id'   => $request->from_id,
            'to_id'     => $request->to_id,
            'from_type' => $request->from_type,
        ])->where('time_departure', '>=', Carbon::now()->format('H:i:s'))->get();

        if ($schedules->count() == 0) {
            return $this->sendError('Data Empty', [], 404);
        }

        return $this->sendResponse($schedules, 'success');
    }

    public function get_avail_charter(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'from_type' => 'required|in:airport,district',
                'from_id'  => 'required',
                'to_id'  => 'required',
            ],
            [
                'in' => ':attribute only accept value :values'
            ]
        );

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        $schedules = Charter::where([
            'is_available' => true,
            'from_id'      => $request->from_id,
            'to_id'        => $request->to_id,
            'from_type'    => $request->from_type,
        ])->get();

        if ($schedules->count() == 0) {
            return $this->sendError('Data Empty', [], 404);
        }

        return $this->sendResponse($schedules, 'success');
    }
}
