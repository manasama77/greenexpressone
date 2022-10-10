<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\MasterAreaController;
use App\Http\Controllers\MasterSpecialAreaController;
use App\Http\Controllers\MasterSubAreaController;
use App\Http\Controllers\PagesController;

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
});
