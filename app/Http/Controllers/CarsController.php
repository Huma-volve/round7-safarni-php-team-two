<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;


class CarsController extends Controller
{
    public function brands()
    {
        $cars = Car::pluck('brand');
        return response()->json($cars);
    }

    public function carsOfBrand($brand)
    {
        $cars = Car::where('brand', $brand)->get();
        return response()->json($cars);
    }

    public function popularCars()
    {
        $popular_cars = Car::orderBy('rating', 'desc')->get();
        return response()->json($popular_cars);
    }

    public function show(Car $car)
    {
        $car->reviews;
        return response()->json($car);
    }
}
