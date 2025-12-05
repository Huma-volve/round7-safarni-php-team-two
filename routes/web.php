<?php

use App\Http\Controllers\HotelAdminController;
use App\Http\Controllers\RoomAdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\AuthController;
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\RoleController;




Route::get('/doctors', fn() => 'Payment successful!')->name('doctors.index');
Route::get('/doctors/create', fn() => 'Payment successful!')->name('doctors.create');
Route::get('/specialties', fn() => 'Payment successful!')->name('specialties.index');
Route::get('/bookings', fn() => 'Payment successful!')->name('bookings.index');
Route::get('/success', fn() => 'Payment successful!')->name('stripe.success');
Route::get('/cancel', fn() => 'Payment canceled.')->name('stripe.cancel');


//  Route::group(['as' => 'auth.'], function () {
        Route::get('login', [AuthController::class, 'getlogin'])->name('getlogin');
        Route::post('login', [AuthController::class, 'login'])->name('login');
    // });

    Route::group(['middleware' => 'auth:admins'], function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/', [HomeController::class, 'index'])->name('/');
        Route::resource('admins',AdminController::class);
        Route::resource('roles',RoleController::class);
        Route::get('getpermissions/{id}',[RoleController::class, 'getpermissions'])->name('getpermissions');
        Route::post('updategetpermissions/{id}', [RoleController::class, 'updategetpermissions'])->name('updategetpermissions');
        //roles
        Route::resource('hotels',HotelAdminController::class);
   Route::resource('hotels.rooms', RoomAdminController::class);

});

Route::get('/success', fn() => 'Payment successful!')->name('stripe.success');
Route::get('/cancel', fn() => 'Payment canceled.')->name('stripe.cancel');








