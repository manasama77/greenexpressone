<?php

namespace App\Services;

use App\Models\Charter;
use App\Models\MasterSubArea;
use App\Models\ScheduleShuttle;
use Carbon\Carbon;

class ScheduleQueryService
{
    public static function generate_data($request)
    {
        $from_sub_area = MasterSubArea::where('id', $request->from_master_sub_area_id)->with('master_area')->first();
        $to_sub_area = MasterSubArea::where('id', $request->to_master_sub_area_id)->with('master_area')->first();
        $query = self::generate_query($request);

        if ($from_sub_area->master_area->area_type == "airport") {
            $query->where([
                'from_master_area_id' => $from_sub_area->master_area_id,
                'to_master_area_id' => $to_sub_area->master_area_id,
                'to_master_sub_area_id' => $request->to_master_sub_area_id,
            ]);
        } else {
            $query->where([
                'from_master_area_id' => $from_sub_area->master_area_id,
                'from_master_sub_area_id' => $request->from_master_sub_area_id,
                'to_master_area_id' => $to_sub_area->master_area_id,
            ]);
        }

        if ($request->date_departure == Carbon::now()->format('Y-m-d') && $request->booking_type !== 'charter') {
            $now = Carbon::now()->format('H:i:s');
            $query->whereRaw("time_departure >= '{$now}'");
        }

        $data = $query->paginate(10);

        if ($request->booking_type !== 'charter') {
            $data->map(function ($item) use ($request) {
                $item->is_available = true;
                if ($item->total_seat - $item->seat_booked <= 0) {
                    $item->is_available = false;
                } elseif (($item->seat_booked + $request->qty_adult + $request->qty_baby) > $item->total_seat) {
                    $item->is_available = false;
                }
                return $item;
            });
        }


        return $data;
    }

    private static function generate_query($request)
    {
        $query = ScheduleShuttle::selectRaw("*,
                ifnull(
                (select (sum(bookings.qty_adult) + sum(bookings.qty_baby)) from bookings where schedule_id = schedule_shuttles.id and DATE(datetime_departure) = '{$request->date_departure}' group by schedule_id),
                0) as seat_booked
            ")
            ->with([
                'from_master_area',
                'from_master_sub_area',
                'to_master_area',
                'to_master_sub_area',
            ])
            ->where('is_active', 1);

        if ($request->booking_type == 'charter') {
            $query = Charter::query()
                ->with([
                    'from_master_area',
                    'from_master_sub_area',
                    'to_master_area',
                    'to_master_sub_area',
                ])
                ->where('is_available', 1);
        }

        return $query;
    }
}
