<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCarRentalRequest;
use App\Models\CarRental;
use Illuminate\Support\Facades\Auth;

class CarRentalController extends Controller
{
    public function rentCar(StoreCarRentalRequest $request, $id)
    {
        $validated = $request->validated();
        $carRental = CarRental::create(array_merge($validated, [
            'user_id' => Auth::id(),
            'car_id'  => $id,
        ])
    );
        return response()->json([
            'message' => 'Car rental request received',
            'data' => $carRental
        ], 201);
    }
}
