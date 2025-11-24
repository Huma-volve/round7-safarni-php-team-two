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

        //highly rated hotels
        $hotels=Hotel::all();
        //calculate average ratings for each hotel
        $hotel_avg_ratings=[];
        foreach($hotels as $hotel){
            $avg=$hotel->reviews()->avg('rating');
            $hotel_avg_ratings[$hotel->id] = $avg;
        }
        //sort hotels by average ratings
        $hotel_avg_ratings = collect($hotel_avg_ratings)->sortDesc();
        $ordered_hotel_ids = $hotel_avg_ratings->keys()->toArray();
        $hotel_results = Car::whereIn('id', $ordered_hotel_ids )->orderByRaw("FIELD(id, " . implode(',', $ordered_hotel_ids ) . ")");

        $high_rated_hotels=$hotel_results->limit(5)->get();
        //highly rated cars
        $cars=Car::all();
        //calculate average ratings for each car
        $car_avg_ratings=[];
        foreach($cars as $car){
            $avg=$car->reviews()->avg('rating');
            $car_avg_ratings[$car->id] = $avg;
        }
        //sort cars by average ratings
        $car_avg_ratings_sorted = collect($car_avg_ratings)->sortDesc();
        $ordered_car_ids = $car_avg_ratings_sorted->keys()->toArray();
        $car_results = Car::whereIn('id', $ordered_car_ids )->orderByRaw("FIELD(id, " . implode(',', $ordered_car_ids ) . ")");

        $high_rated_cars=$car_results->limit(5)->get();
        //highly rated tours
        $tours=Tour::all();
        //calculate average ratings for each tour
        $tour_avg_ratings=[];
        foreach($tours as $tour){
            $avg=$tour->reviews()->avg('rating');
            $tour_avg_ratings[$tour->id] = $avg;
        }
        //sort tours by average ratings
        $tour_avg_ratings = collect($tour_avg_ratings)->sortDesc();
        $ordered_tour_ids = $tour_avg_ratings->keys()->toArray();
        $tour_results = Car::whereIn('id', $ordered_tour_ids)->orderByRaw("FIELD(id, " . implode(',', $ordered_tour_ids) . ")");

        $high_rated_tours=$tour_results->limit(5)->get();

        //all available tours

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
            $rating_filter = $request->input('rating');
            //filter cars by average rating
            $car_avg_ratings=[];
            $cars = $car_results->get();
            foreach($cars as $car){
                $avg=$car->reviews()->avg('rating');
                if($avg < $rating_filter){
                    continue;
                }
                $car_avg_ratings[$car->id] = $avg;
            }
            $car_avg_ratings_sorted = collect($car_avg_ratings)->sortDesc();
            $ordered_car_ids = $car_avg_ratings_sorted->keys()->toArray();
            if (count($ordered_car_ids) > 0) {
                $car_results = $car_results
                    ->whereIn('id', $ordered_car_ids)
                    ->orderByRaw("FIELD(id, " . implode(',', $ordered_car_ids) . ")");
            } else {
                $car_results = Car::whereRaw('0 = 1'); // return empty result
            }

            //filter hotels by average rating
            $hotel_avg_ratings=[];
            $hotels = $hotel_results->get();
            foreach($hotels as $hotel){
                $avg=$hotel->reviews()->avg('rating');
                if($avg < $rating_filter){
                    continue;
                }
                $hotel_avg_ratings[$hotel->id] = $avg;
            }
            $hotel_avg_ratings_sorted = collect($hotel_avg_ratings)->sortDesc();
            $ordered_hotel_ids = $hotel_avg_ratings_sorted->keys()->toArray();
            if (count($ordered_hotel_ids) > 0) {
                $hotel_results = $hotel_results
                    ->whereIn('id', $ordered_hotel_ids)
                    ->orderByRaw("FIELD(id, " . implode(',', $ordered_hotel_ids) . ")");
            } else {
                $hotel_results = Hotel::whereRaw('0 = 1'); // return empty result
            }

            //filter tours by average rating
            $tour_avg_ratings=[];
            $tours = $tour_results->get();
            foreach($tours as $tour){
                $avg=$tour->reviews()->avg('rating');
                if($avg < $rating_filter){
                    continue;
                }
                $tour_avg_ratings[$tour->id] = $avg;
            }
            $tour_avg_ratings_sorted = collect($tour_avg_ratings)->sortDesc();
            $ordered_tour_ids = $tour_avg_ratings_sorted->keys()->toArray();
            if (count($ordered_tour_ids) > 0) {
                $tour_results = $tour_results
                    ->whereIn('id', $ordered_tour_ids)
                    ->orderByRaw("FIELD(id, " . implode(',', $ordered_tour_ids) . ")");
            } else {
                $tour_results = Tour::whereRaw('0 = 1'); // return empty result
            }
        }

        $car_results=$car_results->limit(10)->get();
        $hotel_results=$hotel_results->limit(10)->get();
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
