<?php

namespace App\Http\Controllers\Admin;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $from_shuttle = Carbon::now()->startOfMonth()->format('Y-m-d');
        $to_shuttle   = Carbon::now()->endOfMonth()->format('Y-m-d');

        if ($request->dr_shuttle) {
            $arr_explode  = explode(' - ', $request->dr_shuttle);
            $from_shuttle = $arr_explode[0];
            $to_shuttle   = $arr_explode[1];
        }

        $from_charter = Carbon::now()->startOfMonth()->format('Y-m-d');
        $to_charter   = Carbon::now()->endOfMonth()->format('Y-m-d');

        if ($request->dr_charter) {
            $arr_explode  = explode(' - ', $request->dr_charter);
            $from_charter = $arr_explode[0];
            $to_charter   = $arr_explode[1];
        }

        $shuttles = Booking::select([
            DB::raw("DATE (bookings.datetime_departure) date_departure"),
            DB::raw("SUM( bookings.qty_adult + bookings.qty_baby ) AS total_person"),
        ])
            ->where('bookings.schedule_type', '=', 'shuttle')
            ->where('bookings.payment_status', '=', 'paid')
            ->where(DB::raw('DATE(bookings.datetime_departure)'), '>=', $from_shuttle)
            ->where(DB::raw('DATE(bookings.datetime_departure)'), '<=', $to_shuttle)
            ->groupBy(
                DB::raw('DATE (bookings.datetime_departure)')
            )
            ->get();

        $charters = Booking::select([
            DB::raw("DATE (bookings.datetime_departure) date_departure"),
            DB::raw("SUM( bookings.qty_adult + bookings.qty_baby ) AS total_person"),
        ])
            ->where('bookings.schedule_type', '=', 'charter')
            ->where('bookings.payment_status', '=', 'paid')
            ->where(DB::raw('DATE(bookings.datetime_departure)'), '>=', $from_charter)
            ->where(DB::raw('DATE(bookings.datetime_departure)'), '<=', $to_charter)
            ->groupBy(
                DB::raw('DATE ( bookings.datetime_departure)')
            )
            ->get();

        $arr_date_shuttle   = [];
        $arr_person_shuttle = [];
        $arr_date_charter   = [];
        $arr_person_charter = [];

        foreach ($shuttles as $shuttle) {
            $date_departure_shuttle = $shuttle->date_departure;
            $total_person_shuttle = $shuttle->total_person;

            array_push($arr_date_shuttle, $date_departure_shuttle);
            array_push($arr_person_shuttle, $total_person_shuttle);
        }

        foreach ($charters as $charter) {
            $date_departure_charter = $charter->date_departure;
            $total_person_charter = $charter->total_person;

            array_push($arr_date_charter, $date_departure_charter);
            array_push($arr_person_charter, $total_person_charter);
        }

        $data = [
            'page_title'         => 'Admin Dashboard',
            'base_url'           => env('APP_URL'),
            'app_name'           => env('APP_NAME'),
            'app_name_short'     => env('APP_NAME_ABBR'),
            'from_shuttle'       => $from_shuttle,
            'to_shuttle'         => $to_shuttle,
            'from_charter'       => $from_charter,
            'to_charter'         => $to_charter,
            'arr_date_shuttle'   => $arr_date_shuttle,
            'arr_person_shuttle' => $arr_person_shuttle,
            'arr_date_charter'   => $arr_date_charter,
            'arr_person_charter' => $arr_person_charter,
        ];
        return view('admin.dashboard.main')->with($data);
    }
}
