<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Hotel;
use App\Models\Car;
use App\Models\Tour;

class HomeController extends Controller
{
    public function index(){
        $categories = Category::pluck('name');

        $high_rated_hotels=Hotel::where('rating','>=',4.5)->limit(5)->get();
        $high_rated_cars=Car::where('rating','>=',4.5)->limit(5)->get();
        $high_rated_tours=Tour::where('rating','>=',4.5)->limit(5)->get();

        $available_tours=Tour::all();

        return response()->json([
            'message' => 'Welcome to the Travel Booking API',
            'available_categories' => $categories,
            'recommendations' => [
                'hotels' => $high_rated_hotels,
                'cars' => $high_rated_cars,
                'tours' => $high_rated_tours,
            ],
            'available_tours'=>$available_tours
        ]);
    }
}
