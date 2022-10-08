<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\BannerController;

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
    Route::post('/banner/edit/{id}', [BannerController::class, 'edit'])->name('admin.banner.edit')->middleware('admin');
    Route::put('/banner/update/{id}', [BannerController::class, 'update'])->name('admin.banner.update')->middleware('admin');
    Route::delete('/banner/delete/{id}', [BannerController::class, 'delete'])->name('admin.banner.delete')->middleware('admin');
});
