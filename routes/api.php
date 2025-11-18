<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Api\ProfileController;

Route::post('register', [LoginController::class, 'register']);
Route::post('otp/verify', [LoginController::class, 'verifyOtp']);
Route::post('otp/resend', [LoginController::class, 'resendOtp']);
Route::post('login', [LoginController::class, 'login']);
Route::post('forgot-password', [LoginController::class, 'forgotPassword']);
Route::post('reset-password', [LoginController::class, 'resetPassword']);
Route::get('auth/google/redirect', [LoginController::class, 'googleRedirect']);
Route::get('auth/google/callback', [LoginController::class, 'googleCallback']);




Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout']);
     Route::get('profile', [ProfileController::class, 'profile']);
    Route::post('update/profile', [ProfileController::class, 'updateProfile']);
});

   

// Route::middleware('auth:sanctum')->group(function () {



    /*Hotels*/

    Route::get('hotels', [HotelController::class, 'index']);/*✅ all  hotels*/

    Route::get('single-hotels/{id}', [HotelController::class, 'show']);    /*✅ show single  hotels*/

    Route::get('hotel-rooms/{id}/rooms', [HotelController::class, 'rooms']);  /*✅ show single  room in the hotel*/

    Route::get('hotels-nearby', [HotelController::class, 'nearby']);    /* ✅ nearby  hotels */

    Route::post('hotels-actions', [HotelController::class, 'store']); // ✅ add new hotel     

    Route::put('hotels-actions/{hotel}', [HotelController::class, 'update']); // ✅ update hotel  

    Route::delete('hotels-actions/{hotel}', [HotelController::class, 'destroy']);// ✅ delete hotel
    /*Rooms*/

    Route::post('hotels/{hotel}/rooms', [RoomController::class, 'store']); // ✅ add new Room   

    Route::put('hotels/{hotel}/rooms/{room}', [RoomController::class, 'update']);// ✅  update Room   

    Route::get('hotels/{hotel}/rooms/{room}', [RoomController::class, 'show']);// ✅  show Room

    Route::delete('hotels/{hotel}/rooms/{room}', [RoomController::class, 'destroy']);// ✅  delete Room

    Route::get('hotels/{hotel}/rooms', [RoomController::class, 'index']);// ✅  All Rooms in the Hotel   


// });
