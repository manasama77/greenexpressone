<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Booking;
use App\Models\Voucher;
use App\Models\Schedule;
use App\Models\MasterArea;
use App\Models\LuggagePrice;
use Illuminate\Http\Request;
use App\Models\MasterSubArea;
use App\Models\MasterSpecialArea;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController;

class BookingController extends BaseController
{
    public function index(Request $request)
    {
        $validator = Validator::make(
            $request->except([
                'flight_number',
                'notes',
                'voucher_code',
                'luggage_qty',
            ]),
            [
                'schedule_id' => 'required|exists:schedules,id',
                'user_id'     => 'required|exists:users,id',
                'qty_adult'   => 'required|integer|min_digits:1',
                'qty_baby'    => 'required|integer|min_digits:0',
                'is_extra'    => 'required|in:yes,no',
            ],
            [
                'exists' => ':attribute not found',
                'in' => ':attribute only accept value :values'
            ]
        );

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 400);
        }

        $total_person = $request->qty_adult + $request->qty_baby;

        $schedules = Schedule::with('vehicles')->where([
            'is_active' => 'yes',
            'id'        => $request->schedule_id,
        ])->first();

        $users = User::where('id', $request->id)->first();

        $promo_price    = 0;
        $voucher_id     = null;
        $discount_type  = null;
        $discount_value = null;

        if ($request->voucher_code) {
            $vouchers = Voucher::select([
                'discount_type',
                'discount_value',
            ])->where([
                'is_active' => 'yes',
                'code'      => $request->voucher_code,
            ])->first();

            if (!$vouchers) {
                return $this->sendError('Validation Error.', ["voucher_code" => ["Voucher not found"]], 400);
            }

            $voucher_id     = $vouchers->id;
            $discount_type  = $vouchers->discount_type;
            $discount_value = $vouchers->discount_value;
        }

        $froms = DB::table($schedules->from_table)->select(['id', 'name'])->where('id', $schedules->from_id)->first();
        $tos   = DB::table($schedules->to_table)->select(['id', 'name'])->where('id', $schedules->to_id)->first();

        $lugagges           = LuggagePrice::select(['price'])->first();
        $luggage_base_price = (float) $lugagges->price;
        $luggage_price      = ($request->luggage_qty > 0) ? $luggage_base_price * $request->luggage_qty : 0;
        $extra_price        = 0;

        if ($request->is_extra === "yes") {
            $extra_prices = MasterSpecialArea::select([
                'first_person_price',
                'extra_person_price'
            ])->where([
                'is_active'          => 'yes',
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

        $total_price = $total_person * $schedules->normal_price;

        if ($voucher_id) {
            if ($discount_type == "percentage") {
                $promo_price = ($total_price * $discount_value) / 100;
            } else {
                $promo_price = $total_price - $discount_value;
            }

            $total_price = $total_price - $promo_price;
        }


        $data = [
            'schedule_id'        => $schedules->id,
            'from_id'            => $schedules->from_id,
            'from_table'         => $schedules->from_table,
            'from_name'          => $froms->name,
            'to_id'              => $schedules->to_id,
            'to_table'           => $schedules->to_table,
            'to_name'            => $tos->name,
            'vehicle_id'         => $schedules->vehicle_id,
            'vehicle_name'       => $schedules->vehicles->name,
            'vehicle_number'     => $schedules->vehicles->number,
            'datetime_departure' => $schedules->datetime_departure,
            'datetime_arrival'   => $schedules->datetime_arrival,
            'schedule_type'      => $schedules->schedule_type,
            'user_id'            => $request->user_id,
            'qty_adult'          => $request->qty_adult,
            'qty_baby'           => $request->qty_baby,
            'is_extra'           => $request->is_extra,
            'flight_number'      => ($request->flight_number) ?? null,
            'notes'              => ($request->notes) ?? null,
            'luggage_qty'        => (int)($request->luggage_qty) ?? 0,
            'luggage_price'      => $luggage_price,
            'extra_price'        => $extra_price,
            'voucher_id'         => $voucher_id,
            'promo_price'        => $promo_price,
            'total_price'        => $total_price,
            'booking_status'     => 'waiting payment',
            'payment_method'     => null,
            'payment_token'      => null,
            'payment_status'     => null,
            'total_payment'      => 0,
        ];

        $bookings = Booking::create($data);

        return $this->sendResponse($bookings, 'success');
    }

    public function get_list_from_destination(Request $request)
    {
        $keyword = $request->keyword;

        $master_areas = MasterArea::where([
            'is_active' => 'yes',
            'area_type' => 'departure',
        ]);

        if ($keyword) {
            $master_areas->where('is_active', 'yes');
            $master_areas->where('area_type', 'departure');
            $master_areas->orWhere('name', 'like', '%' . $keyword . '%');
        }

        if ($master_areas->count() == 0) {
            return $this->sendError('Data Empty', [], 404);
        }

        $data = [];

        foreach ($master_areas->get() as $key_area) {
            $id_area   = $key_area->id;
            $name_area = $key_area->name;

            $nested = [
                'id'       => $id_area . "|master_area",
                'name'     => $name_area,
                'sub_area' => [],
            ];


            $master_sub_areas = MasterSubArea::where([
                'is_active'      => 'yes',
                'master_area_id' => $id_area,
            ]);

            if ($keyword) {
                $master_sub_areas->where('name', 'like', '%' . $keyword . '%');
            }

            foreach ($master_sub_areas->get() as $key_sub) {
                $id_sub   = $key_sub->id;
                $name_sub = $key_sub->name;

                $nested_sub = [
                    'id'        => $id_sub . "|master_sub_area",
                    'name'      => $name_sub,
                    'parent'    => false,
                    'parent_id' => $id_area . "|master_area",
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
            'is_active' => 'yes',
            'area_type' => 'arrival',
        ]);

        if ($keyword) {
            $master_areas->where('is_active', 'yes');
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
                'id'       => $id_area . "|master_area",
                'name'     => $name_area,
                'sub_area' => [],
            ];


            $master_sub_areas = MasterSubArea::where([
                'is_active'      => 'yes',
                'master_area_id' => $id_area,
            ]);

            if ($keyword) {
                $master_sub_areas->where('name', 'like', '%' . $keyword . '%');
            }

            foreach ($master_sub_areas->get() as $key_sub) {
                $id_sub   = $key_sub->id;
                $name_sub = $key_sub->name;

                $nested_sub = [
                    'id'        => $id_sub . "|master_sub_area",
                    'name'      => $name_sub,
                    'parent'    => false,
                    'parent_id' => $id_area . "|master_area",
                ];
                array_push($nested['sub_area'], $nested_sub);
            }

            array_push($data, $nested);
        }

        return $this->sendResponse($data, 'success');
    }
}
