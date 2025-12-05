<?php

namespace App\Http\Controllers;

use App\Http\Requests\hotel\StoreHotelRequest;
use App\Http\Requests\hotel\UpdateHotelRequest;
use App\Http\Resources\HotelResource;
use App\Http\Resources\RoomResource;
use App\Models\Hotel;
use App\Models\Room;
use App\Services\HotelService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
class HotelController extends Controller
{
    protected HotelService $hotelService;

    public function __construct(HotelService $hotelService)
    {
        $this->hotelService = $hotelService;
    }

    public function index()
    {
        $hotels = Hotel::with('rooms')->paginate(10);
        return HotelResource::collection($hotels);
    }

    public function show($id)
    {
        $hotel = Hotel::with('rooms')->findOrFail($id);
        return new HotelResource($hotel);
    }
    public function rooms(Request $request, $hotelId)
    {
        $perPage = $request->query('per_page', 10); // افتراضي 10
        $rooms = Room::where('hotel_id', $hotelId)->paginate($perPage);

        return RoomResource::collection($rooms);
    }


    public function nearby(Request $request)
    {
        $lat = $request->query('lat');
        $lng = $request->query('lng');

        // إذا المستخدم لم يرسل إحداثيات
        if (!$lat || !$lng) {
            $hotels = $this->hotelService->nearby(null, null); // هيرجع كل الفنادق paginate
            return response()->json([
                'message' => 'Returning all hotels because no location is sent',
                'data' => HotelResource::collection($hotels)
            ]);
        }

        $hotels = $this->hotelService->nearby((float) $lat, (float) $lng, 100);

        return response()->json([
            'message' => 'Nearby hotels based on your location',
            'data' => HotelResource::collection($hotels)
        ]);
    }



}
