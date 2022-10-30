<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Booking;
use App\Models\Charter;
use App\Models\MasterArea;
use App\Models\MasterSpecialArea;
use Illuminate\Http\Request;
use App\Models\MasterSubArea;
use App\Models\Page;
use Illuminate\Support\Carbon;
use App\Models\ScheduleShuttle;
use App\Models\Voucher;

class WelcomeController extends Controller
{
    public function index()
    {
        $banners = Banner::where('is_active', true)->get();
        $pages   = Page::get();

        $data = [
            'title'    => env('APP_NAME'),
            'app_name' => env('APP_NAME'),
            'banners'  => $banners,
            'pages'    => $pages,
        ];
        return view('home', $data);
    }

    public function page($slug)
    {
        $banners = Banner::where('is_active', true)->get();
        $pages   = Page::get();
        $isis    = Page::where('slug', $slug)->first();

        $data = [
            'title'    => env('APP_NAME'),
            'app_name' => env('APP_NAME'),
            'banners'  => $banners,
            'pages'    => $pages,
            'isis'     => $isis,
        ];

        if (!$isis) {
            return view('page_not_found', $data);
        }

        return view('page', $data);
    }

    public function search(Request $request)
    {
        $pages   = Page::get();
        $data = [
            'title'    => env('APP_NAME'),
            'app_name' => env('APP_NAME'),
            'request'  => $request,
            'pages'    => $pages,
        ];
        return view('search', $data);
    }

    public function booking(Request $request)
    {
        $from_type               = $request->from_type;
        $from_master_area_id     = $request->from_master_area_id;
        $from_master_sub_area_id = $request->from_master_sub_area_id;
        $to_master_area_id       = $request->to_master_area_id;
        $to_master_sub_area_id   = $request->to_master_sub_area_id;
        $booking_type            = $request->booking_type;
        $date_departure          = $request->date_departure;
        $passanger_adult         = $request->passanger_adult;
        $passanger_baby          = $request->passanger_baby;
        $schedule_id             = $request->schedule_id;

        session([
            'from_type'               => $from_type,
            'from_master_area_id'     => $from_master_area_id,
            'from_master_sub_area_id' => $from_master_sub_area_id,
            'to_master_area_id'       => $to_master_area_id,
            'to_master_sub_area_id'   => $to_master_sub_area_id,
            'booking_type'            => $booking_type,
            'date_departure'          => $date_departure,
            'passanger_adult'         => $passanger_adult,
            'passanger_baby'          => $passanger_baby,
            'schedule_id'             => $schedule_id,
        ]);

        if ($booking_type == "shuttle") {
            $schedule = ScheduleShuttle::where('is_active', true)->where('id', $schedule_id)->first();
            $base_price = $schedule->price;
            $luggage_price = $schedule->luggage_price;
        } else {
            $schedule = Charter::where('is_active', true)->where('id', $schedule_id)->first();
        }

        if (!$schedule) {
            return view('schedule_not_found');
        }

        if ($from_type == "airport") {
            $from_main_name = MasterArea::where('id', $from_master_area_id)->first()->name;
            $from_sub_name = MasterSubArea::where('id', $from_master_sub_area_id)->first()->name;
            $to_main_name = MasterArea::where('id', $to_master_area_id)->first()->name;
            $to_sub_name = MasterSubArea::where('id', $to_master_sub_area_id)->first()->name;
            $date_time_departure = Carbon::parse($date_departure . " " . $schedule->time_departure)->format('Y M d H:i');
            $special_areas = MasterSpecialArea::where('is_active', true)->where('master_sub_area_id', $schedule->to_master_sub_area_id)->orderBy('regional_name', 'asc')->get();
        } elseif ($from_type == "city") {
            $special_areas = MasterSpecialArea::where('is_active', true)->where('master_sub_area_id', $schedule->from_master_sub_area_id)->orderBy('regional_name', 'asc')->get();
        } else {
            $special_areas = collect([]);
        }

        $passanger_total = $passanger_adult + $passanger_baby;
        $base_price_total = number_format($base_price * $passanger_total, 2);


        $pages   = Page::get();

        $data = [
            'title'               => env('APP_NAME'),
            'app_name'            => env('APP_NAME'),
            'request'             => $request,
            'pages'               => $pages,
            'schedule'            => $schedule,
            'special_areas'       => $special_areas,
            'from_main_name'      => $from_main_name,
            'from_sub_name'       => $from_sub_name,
            'to_main_name'        => $to_main_name,
            'to_sub_name'         => $to_sub_name,
            'date_time_departure' => $date_time_departure,
            'passanger_adult'     => $passanger_adult,
            'passanger_baby'      => $passanger_baby,
            'passanger_total'     => $passanger_total,
            'base_price_total'    => $base_price_total,
            'luggage_price'       => $luggage_price,
        ];
        return view('booking', $data);
    }

    public function booking_check($encode)
    {
        $decode = urldecode($encode);
        $pages  = Page::get();

        $bookings = Booking::where('booking_number', $decode)->first();

        if (!$bookings) {
            $data = [
                'title'    => 'Booking Check',
                'app_name' => env('APP_NAME'),
                'pages'    => $pages,
                'bookings' => $bookings,
            ];
            return view('booking_not_found', $data);
        }

        $vouchers = Voucher::where('id', $bookings->voucher_id)->first();

        $data = [
            'title'    => 'Booking Check',
            'app_name' => env('APP_NAME'),
            'pages'    => $pages,
            'bookings' => $bookings,
            'vouchers' => $vouchers,
        ];

        return view('check', $data);
    }
}
