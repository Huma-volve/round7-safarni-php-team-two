<?php

use App\Http\Controllers\Flight\AirportController;
use App\Http\Controllers\Flight\CarrierController;
use App\Http\Controllers\Flight\FlightController;
use App\Http\Controllers\HotelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RouteMessage;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::prefix('hotels')->group(function () {
    Route::get('/', [HotelController::class, 'index']);
    Route::get('/{id}', [HotelController::class, 'show']);
    Route::get('/{id}/nearby', [HotelController::class, 'nearby']);
});
$error=fn($message)=>response()->json($message,422);
Route::apiResource('airports', AirportController::class)->missing(function (){
    return response()->json('airports not found');
});
Route::apiResource('carrier', CarrierController::class)->missing(function ()use ($error){
    return $error("carrier not found");
});
Route::apiResource('flights', FlightController::class)->missing(function ()use ($error){
    return $error("flight not found");
});
