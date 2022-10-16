<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CharterController;
use App\Http\Controllers\MasterAreaController;
use App\Http\Controllers\MasterSpecialAreaController;
use App\Http\Controllers\MasterSubAreaController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ShuttleController;
use App\Http\Controllers\VoucherController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [WelcomeController::class, 'index']);

Route::prefix('admin')->middleware('prevent-back-history')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'index'])->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'check']);
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard')->middleware('admin');

    Route::get('/banner', [BannerController::class, 'index'])->name('admin.banner')->middleware('admin');
    Route::post('/banner', [BannerController::class, 'store'])->name('admin.banner.store')->middleware('admin');
    Route::get('/banner/edit/{id}', [BannerController::class, 'edit'])->name('admin.banner.edit')->middleware('admin');
    Route::put('/banner/update/{id}', [BannerController::class, 'update'])->name('admin.banner.update')->middleware('admin');
    Route::delete('/banner/delete/{id}', [BannerController::class, 'delete'])->name('admin.banner.delete')->middleware('admin');

    Route::get('/master_area', [MasterAreaController::class, 'index'])->name('admin.master_area')->middleware('admin');
    Route::post('/master_area', [MasterAreaController::class, 'store'])->name('admin.master_area.store')->middleware('admin');
    Route::get('/master_area/edit/{id}', [MasterAreaController::class, 'edit'])->name('admin.master_area.edit')->middleware('admin');
    Route::put('/master_area/update/{id}', [MasterAreaController::class, 'update'])->name('admin.master_area.update')->middleware('admin');
    Route::delete('/master_area/delete/{id}', [MasterAreaController::class, 'delete'])->name('admin.master_area.delete')->middleware('admin');

    Route::get('/master_sub_area', [MasterSubAreaController::class, 'index'])->name('admin.master_sub_area')->middleware('admin');
    Route::post('/master_sub_area', [MasterSubAreaController::class, 'store'])->name('admin.master_sub_area.store')->middleware('admin');
    Route::get('/master_sub_area/edit/{id}', [MasterSubAreaController::class, 'edit'])->name('admin.master_sub_area.edit')->middleware('admin');
    Route::put('/master_sub_area/update/{id}', [MasterSubAreaController::class, 'update'])->name('admin.master_sub_area.update')->middleware('admin');
    Route::delete('/master_sub_area/delete/{id}', [MasterSubAreaController::class, 'delete'])->name('admin.master_sub_area.delete')->middleware('admin');

    Route::get('/master_special_area', [MasterSpecialAreaController::class, 'index'])->name('admin.master_special_area')->middleware('admin');
    Route::post('/master_special_area', [MasterSpecialAreaController::class, 'store'])->name('admin.master_special_area.store')->middleware('admin');
    Route::get('/master_special_area/edit/{id}', [MasterSpecialAreaController::class, 'edit'])->name('admin.master_special_area.edit')->middleware('admin');
    Route::put('/master_special_area/update/{id}', [MasterSpecialAreaController::class, 'update'])->name('admin.master_special_area.update')->middleware('admin');
    Route::delete('/master_special_area/delete/{id}', [MasterSpecialAreaController::class, 'delete'])->name('admin.master_special_area.delete')->middleware('admin');

    Route::get('/pages', [PagesController::class, 'index'])->name('admin.pages')->middleware('admin');
    Route::put('/pages/update/{id}', [PagesController::class, 'update'])->name('admin.pages.update')->middleware('admin');

    Route::get('/voucher', [VoucherController::class, 'index'])->name('admin.voucher')->middleware('admin');
    Route::post('/voucher', [VoucherController::class, 'store'])->name('admin.voucher.store')->middleware('admin');
    Route::get('/voucher/edit/{id}', [VoucherController::class, 'edit'])->name('admin.voucher.edit')->middleware('admin');
    Route::put('/voucher/update/{id}', [VoucherController::class, 'update'])->name('admin.voucher.update')->middleware('admin');
    Route::delete('/voucher/delete/{id}', [VoucherController::class, 'delete'])->name('admin.voucher.delete')->middleware('admin');

    Route::get('/charter', [CharterController::class, 'index'])->name('admin.charter')->middleware('admin');
    Route::get('/charter/add', [CharterController::class, 'add'])->name('admin.charter.add')->middleware('admin');
    Route::post('/charter', [CharterController::class, 'store'])->name('admin.charter.store')->middleware('admin');
    Route::get('/charter/edit/{id}', [CharterController::class, 'edit'])->name('admin.charter.edit')->middleware('admin');
    Route::put('/charter/update/{id}', [CharterController::class, 'update'])->name('admin.charter.update')->middleware('admin');
    Route::delete('/charter/delete/{id}', [CharterController::class, 'delete'])->name('admin.charter.delete')->middleware('admin');

    Route::get('/shuttle', [ShuttleController::class, 'index'])->name('admin.shuttle')->middleware('admin');
    Route::get('/shuttle/add', [ShuttleController::class, 'add'])->name('admin.shuttle.add')->middleware('admin');
    Route::post('/shuttle', [ShuttleController::class, 'store'])->name('admin.shuttle.store')->middleware('admin');
    Route::get('/shuttle/edit/{id}', [ShuttleController::class, 'edit'])->name('admin.shuttle.edit')->middleware('admin');
    Route::put('/shuttle/update/{id}', [ShuttleController::class, 'update'])->name('admin.shuttle.update')->middleware('admin');
    Route::delete('/shuttle/delete/{id}', [ShuttleController::class, 'delete'])->name('admin.shuttle.delete')->middleware('admin');

    Route::get('/booking', [BookingController::class, 'index'])->name('admin.booking')->middleware('admin');
    // Route::get('/booking/add', [BookingController::class, 'add'])->name('admin.booking.add')->middleware('admin');
    // Route::post('/booking', [BookingController::class, 'store'])->name('admin.booking.store')->middleware('admin');
    // Route::get('/booking/edit/{id}', [BookingController::class, 'edit'])->name('admin.booking.edit')->middleware('admin');
    // Route::put('/booking/update/{id}', [BookingController::class, 'update'])->name('admin.booking.update')->middleware('admin');
    Route::delete('/booking/delete/{id}', [BookingController::class, 'delete'])->name('admin.booking.delete')->middleware('admin');

    Route::get('/admin', [AdminController::class, 'index'])->name('admin.admin')->middleware('admin');
    Route::post('/admin', [AdminController::class, 'store'])->name('admin.admin.store')->middleware('admin');
    Route::get('/admin/edit/{id}', [AdminController::class, 'edit'])->name('admin.admin.edit')->middleware('admin');
    Route::put('/admin/update/{id}', [AdminController::class, 'update'])->name('admin.admin.update')->middleware('admin');
    Route::post('/admin/reset_password/{id}', [AdminController::class, 'reset_password'])->name('admin.admin.reset_password')->middleware('admin');
    Route::delete('/admin/delete/{id}', [AdminController::class, 'delete'])->name('admin.admin.delete')->middleware('admin');
});
