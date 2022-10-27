<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\MasterArea;
use Illuminate\Http\Request;
use App\Models\MasterSubArea;
use Illuminate\Support\Carbon;
use App\Models\ScheduleShuttle;

class WelcomeController extends Controller
{
    public function index()
    {
        $banners   = Banner::where('is_active', true)->get();

        $data = [
            'title'    => env('APP_NAME'),
            'app_name' => env('APP_NAME'),
            'banners'  => $banners,
        ];
        return view('home', $data);
    }

    public function search(Request $request)
    {
        // $from_type               = $request->from_type;
        // $from_master_area_id     = $request->from_master_area_id;
        // $from_master_sub_area_id = $request->from_master_sub_area_id;
        // $to_master_area_id       = $request->to_master_area_id;
        // $to_master_sub_area_id   = $request->to_master_sub_area_id;
        // $booking_type            = $request->booking_type;
        // $date_departure          = $request->date_departure;
        // $passanger_adult         = $request->passanger_adult;
        // $passanger_baby          = $request->passanger_baby;

        // if (
        //     $from_type &&
        //     $from_master_area_id &&
        //     $to_master_area_id &&
        //     $booking_type &&
        //     $date_departure &&
        //     $passanger_adult
        // ) {
        //     if($booking_type == "shuttle"){

        //     }
        // }

        $data = [
            'title'    => env('APP_NAME'),
            'app_name' => env('APP_NAME'),
            'request'  => $request,
        ];
        return view('search', $data);
    }
}
