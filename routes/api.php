<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BannerController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\VoucherController;

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
        Route::post('/logout', 'logout');
    });
});

Route::get('/banner', [BannerController::class, 'index']);
Route::get('/banner/{id}', [BannerController::class, 'show']);

Route::controller(BookingController::class)->group(function () {
    Route::get('/check_booking_number', 'check_booking_number');
    Route::get('/get_list_from_departure', 'get_list_from_departure');
    Route::get('/get_list_to_destination', 'get_list_to_destination');
    Route::post('/get_schedule_shuttles', 'get_schedule_shuttles');
    Route::post('/get_avail_charter', 'get_avail_charter');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/booking', 'index');
        Route::post('/booking_history', 'show');
    });
});

Route::controller(VoucherController::class)->group(function () {
    Route::get('/check_voucher', 'show');
});

Route::controller(ProfileController::class)->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/profile', 'index');
        Route::post('/profile', 'update');
        Route::post('/update_password', 'update_password');
    });
});
