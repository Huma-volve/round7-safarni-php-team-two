<?php

namespace App\Http\Controllers;

use App\Http\Resources\HotelResource;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
  
    public function index()
    {
        $hotels = Hotel::with('rooms')->paginate(10); // pagination
        return HotelResource::collection($hotels);
    }

  
    public function show($id)
    {
        $hotel = Hotel::with('rooms')->findOrFail($id);
        return new HotelResource($hotel);
    }

    
    public function nearby(Request $request, $id)
    {
        $hotel = Hotel::findOrFail($id);

        $lat = $request->query('lat', $hotel->latitude);
        $lng = $request->query('lng', $hotel->longitude);
        $radius = 10; 

        $nearby = Hotel::where('id', '!=', $hotel->id)
            ->selectRaw("*, (6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance", [$lat, $lng, $lat])
            ->having('distance', '<=', $radius)
            ->orderBy('distance', 'asc')
            ->with('rooms')
            ->get();

        return HotelResource::collection($nearby);
    }
}
