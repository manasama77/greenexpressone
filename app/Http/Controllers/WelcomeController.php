<?php

namespace App\Http\Controllers;

use App\Http\Resources\ShuttleScheduleResource;
use App\Models\Banner;
use App\Models\Booking;
use App\Models\Charter;
use App\Models\MasterArea;
use App\Models\MasterSpecialArea;
use App\Services\ScheduleQueryService;
use App\Services\StripeTransaction;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use App\Models\MasterSubArea;
use App\Models\Page;
use Illuminate\Support\Carbon;
use App\Models\ScheduleShuttle;
use App\Models\Voucher;
use Stripe;

class WelcomeController extends Controller
{
    public function index()
    {
        $banners = Banner::where('is_active', true)->get();
        $pages = Page::get();
        $master_area = MasterArea::query()
            ->with(['master_sub_area' => function ($q) {
                $q->where('is_active', '1');
            }])->where('is_active', '1')->get();

        $data = [
            'title' => env('APP_NAME'),
            'master_area' => $master_area,
            'app_name' => env('APP_NAME'),
            'banners' => $banners,
            'pages' => $pages,
        ];
        return view('home', $data);
    }

    public function page($slug)
    {
        $banners = Banner::where('is_active', true)->get();
        $pages = Page::get();
        $isis = Page::where('slug', $slug)->first();

        $data = [
            'title' => env('APP_NAME'),
            'app_name' => env('APP_NAME'),
            'banners' => $banners,
            'pages' => $pages,
            'isis' => $isis,
        ];

        if (!$isis) {
            return view('page_not_found', $data);
        }

        return view('page', $data);
    }

    public function search(Request $request)
    {

        $master_area = MasterArea::query()
            ->with(['master_sub_area' => function ($q) {
                $q->where('is_active', '1');
            }])->where('is_active', '1')->get();

        $sub_area = MasterSubArea::where('id', $request->to_master_sub_area_id)->first();
        $arrival_area = MasterArea::query()
            ->where('id', !empty($sub_area) ? $sub_area->master_area_id : 0)
            ->with(['master_sub_area' => function ($q) {
                $q->where('is_active', '1');
            }])->where('is_active', '1')->get();

        $schedule = ScheduleQueryService::generate_data($request);

//        dd($schedule);
        $pages = Page::get();
        $data = [
            'title' => env('APP_NAME'),
            'app_name' => env('APP_NAME'),
            'master_area' => $master_area,
            'arrival_area' => $arrival_area,
            'request' => $request,
            'schedule' => $schedule,
            'pages' => $pages,
        ];

        return view('search', $data);
    }

    public function booking(Request $request)
    {
        $pages = Page::get();

        $from_type = $request->from_type;
        $from_master_area_id = $request->from_master_area_id;
        $from_master_sub_area_id = $request->from_master_sub_area_id;
        $to_master_area_id = $request->to_master_area_id;
        $to_master_sub_area_id = $request->to_master_sub_area_id;
        $booking_type = $request->booking_type;
        $date_departure = $request->date_departure;
        $passanger_adult = $request->passanger_adult;
        $passanger_baby = $request->passanger_baby;
        $schedule_id = $request->schedule_id;

        session([
            'from_type' => $from_type,
            'from_master_area_id' => $from_master_area_id,
            'from_master_sub_area_id' => $from_master_sub_area_id,
            'to_master_area_id' => $to_master_area_id,
            'to_master_sub_area_id' => $to_master_sub_area_id,
            'booking_type' => $booking_type,
            'date_departure' => $date_departure,
            'passanger_adult' => $passanger_adult,
            'passanger_baby' => $passanger_baby,
            'schedule_id' => $schedule_id,
        ]);

        if ($booking_type == "shuttle") {
            $schedule = ScheduleShuttle::where('is_active', true)->where('id', $schedule_id)->first();
            $base_price = $schedule->price;
            $luggage_price = $schedule->luggage_price;
        } else {
            $schedule = Charter::where('is_available', true)->where('id', $schedule_id)->first();
            $base_price = $schedule->price;
            $luggage_price = 0;
        }

        if (!$schedule) {
            $data = [
                'title' => 'Booking Check',
                'app_name' => env('APP_NAME'),
                'pages' => $pages,
            ];
            return view('schedule_not_found', $data);
        }

        if ($from_type == "airport") {
            $from_main_name = MasterArea::where('id', $from_master_area_id)->first()->name;

            $arr_master_sub_area = MasterSubArea::where('id', $from_master_sub_area_id)->first();
            $from_sub_name = ($arr_master_sub_area) ? $arr_master_sub_area->name : "";

            $to_main_name = MasterArea::where('id', $to_master_area_id)->first()->name;
            $to_sub_name = MasterSubArea::where('id', $to_master_sub_area_id)->first()->name;

            $date_time_departure = Carbon::parse($date_departure . " " . $schedule->time_departure)->format('Y M d H:i');

            $special_areas = MasterSpecialArea::where('is_active', true)->where('master_sub_area_id', $schedule->to_master_sub_area_id)->orderBy('regional_name', 'asc')->get();
        } elseif ($from_type == "city") {
            $from_main_name = MasterArea::where('id', $from_master_area_id)->first()->name;

            $arr_master_sub_area = MasterSubArea::where('id', $from_master_sub_area_id)->first();
            $from_sub_name = ($arr_master_sub_area) ? $arr_master_sub_area->name : "";

            $to_main_name = MasterArea::where('id', $to_master_area_id)->first()->name;

            $arr_master_sub_area = MasterSubArea::where('id', $to_master_sub_area_id)->first();
            $to_sub_name = ($arr_master_sub_area) ? $arr_master_sub_area->name : "";

            $date_time_departure = Carbon::parse($date_departure . " " . $schedule->time_departure)->format('Y M d H:i');

            $special_areas = MasterSpecialArea::where('is_active', true)->where('master_sub_area_id', $schedule->from_master_sub_area_id)->orderBy('regional_name', 'asc')->get();
        } else {
            $special_areas = collect([]);
        }

        $passanger_total = $passanger_adult + $passanger_baby;
        $base_price_total = number_format($base_price * $passanger_total, 2);

        $data = [
            'title' => env('APP_NAME'),
            'app_name' => env('APP_NAME'),
            'request' => $request,
            'pages' => $pages,
            'schedule' => $schedule,
            'special_areas' => $special_areas,
            'from_main_name' => $from_main_name,
            'from_sub_name' => $from_sub_name,
            'to_main_name' => $to_main_name,
            'to_sub_name' => $to_sub_name,
            'date_time_departure' => $date_time_departure,
            'passanger_adult' => $passanger_adult,
            'passanger_baby' => $passanger_baby,
            'passanger_total' => $passanger_total,
            'base_price_total' => $base_price_total,
            'luggage_price' => $luggage_price,
        ];
        return view('booking', $data);
    }

    // stripe logic starts here
    public function booking_check(Request $request)
    {
        $encode = $request->code;
        $decode = urldecode($encode);
        $pages = Page::get();

        $bookings = Booking::where('booking_number', $decode)->first();

        if (!$bookings) {
            $data = [
                'title' => 'Booking Check',
                'app_name' => env('APP_NAME'),
                'pages' => $pages,
                'bookings' => $bookings,
            ];
            return view('booking_not_found', $data);
        }

        $vouchers = Voucher::where('id', $bookings->voucher_id)->first();

        $data = [
            'title' => 'Booking Check',
            'app_name' => env('APP_NAME'),
            'pages' => $pages,
            'bookings' => $bookings,
            'vouchers' => $vouchers,
            'hashed_code' => \Crypt::encrypt($bookings->booking_number),
        ];

        return view('check', $data);
    }

    public function booking_payment(Request $request)
    {
        $pages = Page::get();

        try {
            $decryptNumberBooking = \Crypt::decrypt($request->hcode);
        } catch (DecryptException $e) {
            $data = [
                'title' => 'Booking process',
                'app_name' => env('APP_NAME'),
                'pages' => $pages,
                'bookings' => null,
            ];
            return view('booking_not_found', $data);
        }


        $bookings = Booking::where('booking_number', (string)$decryptNumberBooking)->first();

        if (!$bookings) {
            $data = [
                'title' => 'Booking Payment',
                'app_name' => env('APP_NAME'),
                'pages' => $pages,
                'bookings' => $bookings,
            ];

            return view('booking_not_found', $data);
        }


        if ($bookings->payment_status == 'paid' || $bookings->payment_status !== 'waiting') {
            $data = [
                'title' => 'Booking Payment',
                'app_name' => env('APP_NAME'),
                'pages' => $pages,
                'bookings' => $bookings,
            ];

            return view('booking_not_found', $data);
        }

        $vouchers = Voucher::where('id', $bookings->voucher_id)->first();

            $stripe = new StripeTransaction();

            $response = $stripe->create_intent($bookings);

        if ($response->status !== 'requires_payment_method') {
            try {
                $decryptNumberBooking = \Crypt::decrypt($request->hcode);
            } catch (DecryptException $e) {
                abort(401);
            }

             return redirect()->route("booking_check", ["code" => $decryptNumberBooking])->with("message", "<div class='alert alert-warning' role='alert'><span class='font-weight-bold'><i class='fas fa-exclamation-triangle'></i> Something wrong happened, please contact the admin !</span> </div>");
        }

        $data = [
            'title' => 'Booking Payment',
            'app_name' => env('APP_NAME'),
            'pages' => $pages,
            'bookings' => $bookings,
            'vouchers' => $vouchers,
            'hcode' => \Crypt::encrypt($decryptNumberBooking),
            'client_secret' => $response->client_secret,
            'intent_id' => $response->id
        ];

        return view('payment', $data);
    }

    public function booking_process(Request $request)
    {
        try {
            $decryptNumberBooking = \Crypt::decrypt($request->hcode);
        } catch (DecryptException $e) {
            abort(401);
        }

        $bookings = Booking::where('booking_number', (string)$decryptNumberBooking)->first();

        $stripe = new StripeTransaction();
        $response = $stripe->retrive_payment_intent($request->intent_id);

        if ($response->status !== 'succeeded') {
            return redirect()->route("booking_check", ["code" => $decryptNumberBooking])->with("message", "<div class='alert alert-warning' role='alert'><span class='font-weight-bold'><i class='fas fa-exclamation-triangle'></i> Payment has been processed !</span> </div>");
        }

        if (!$bookings) {
            abort(404);
        }

        if ($bookings->payment_status == 'paid' || $bookings->payment_status !== 'waiting') {
            abort(404);
        }

        Booking::where('id', $bookings->id)->update([
            'payment_status' => 'paid',
            'booking_status' => 'active',
            'payment_method' => $response->payment_method,
            'payment_token' => $response->id,
        ]);

        return redirect()->route("booking_check", ["code" => $decryptNumberBooking])->with("message", "<div class='alert alert-success' role='alert'><span class='font-weight-bold'><i class='fas fa-check-circle'></i> Payment Succeeded !</span> </div>");
    }
}
