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

    public function suggestions(Request $request){
        $query = $request->input('query');

        $hotel_suggestions = Hotel::where('city', 'LIKE', "%$query%")->limit(5)->pluck('city');
        $car_suggestions = Car::where('city', 'LIKE', "%$query%")->limit(5)->pluck('city');
        $tour_suggestions = Tour::where('city', 'LIKE', "%$query%")->limit(5)->pluck('city');

        return response()->json([
            'message' => 'Search suggestions for: ' . $query,
            'suggestions'=>[
                'hotels' => $hotel_suggestions,
                'cars' => $car_suggestions,
                'tours' => $tour_suggestions,
            ]
        ]);
    }

    public function search(Request $request){

        $city=$request->input('city');

        $hotel_results = Hotel::where('city', 'LIKE', "%$city%");
        $car_results = Car::where('city', 'LIKE', "%$city%");
        $tour_results = Tour::where('city', 'LIKE', "%$city%");

        //search filters
        if($request->has('price')){
            //calculte the average price per night for each hotel rooms
            $hotel_avg_prices = [];
            foreach($hotel_results->get() as $hotel){
                $avg = $hotel->rooms->avg('price_per_night');
                $hotel_avg_prices[$hotel->id] = $avg;
            }
            if($request->input('price')=='low_to_high'){
                // Implement price low to high sorting if needed
                $sorted = collect($hotel_avg_prices)->sort();
                $ordered_ids = $sorted->keys()->toArray();
                $car_results->orderBy('price','asc');
                $tour_results->orderBy('price','asc');
            }
            if($request->input('price')=='high_to_low'){
                // Implement price high to low sorting if needed
                $sortedDesc = collect($hotel_avg_prices)->sort()->reverse();
                $ordered_ids = $sortedDesc ->keys()->toArray();
                $car_results->orderBy('price','desc');
                $tour_results->orderBy('price','desc');
            }
            $hotel_results = $hotel_results->whereIn('id', $ordered_ids)->orderByRaw("FIELD(id, " . implode(',', $ordered_ids) . ")");
        }
        if($request->has('rating')){
            $rating_filter=$request->input('rating');
            $hotel_results->where('rating','>=',$rating_filter);
            $car_results->where('rating','>=',$rating_filter);
            $tour_results->where('rating','>=',$rating_filter);
        }

        $hotel_results=$hotel_results->limit(10)->get();
        $car_results=$car_results->limit(10)->get();
        $tour_results=$tour_results->limit(10)->get();

        return response()->json([
            'message' => 'Search Results For :' . $city,
            'search_results'=>[
                'hotels' => $hotel_results,
                'cars' => $car_results,
                'tours' => $tour_results,
            ]
        ]);
    }
}
