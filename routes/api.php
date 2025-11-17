<?php

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
