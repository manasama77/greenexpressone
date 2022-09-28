<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $data = [
            'title'    => env('APP_NAME'),
            'app_name' => env('APP_NAME'),
        ];
        return view('welcome', $data);
    }
}
