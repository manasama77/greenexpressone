<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\BookingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');

    Route::middleware('auth:sanctum')->group(function () {
        // Route::prefix('/profile')->group(function () {
        //     Route::get('/', 'profile');
        //     Route::post('/', 'update');
        // });
        Route::post('/logout', 'logout');
    });
});

Route::get('/banner', [BannerController::class, 'index']);

Route::controller(BookingController::class)->group(function () {
    Route::get('/get_list_from_departure', 'get_list_from_departure');
    Route::get('/get_list_to_destination', 'get_list_to_destination');
    Route::post('/get_schedule_shuttles', 'get_schedule_shuttles');
    Route::post('/get_avail_charter', 'get_avail_charter');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/booking', 'index');
    });
});
