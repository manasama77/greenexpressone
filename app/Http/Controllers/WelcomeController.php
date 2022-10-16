<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\MasterArea;
use App\Models\MasterSubArea;
use Illuminate\Http\Request;

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

    public function search()
    {
        $data = [
            'title'    => env('APP_NAME'),
            'app_name' => env('APP_NAME'),
        ];
        return view('search', $data);
    }
}
