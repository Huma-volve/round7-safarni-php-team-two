<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Http\Resources\RoomResource;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{

public function index(Hotel $hotel)
{
  return RoomResource::collection($hotel->rooms);

}


    
 public function store(StoreRoomRequest $request, Hotel $hotel)
 
    {
        $validated = $request->validated();

        // تحويل الحقول JSON لو موجودة
        foreach (['photos','occupancy','seasonal_pricing','availability_calendar','extras'] as $jsonField) {
            if (isset($validated[$jsonField])) {
                $validated[$jsonField] = json_encode($validated[$jsonField]);
            }
        }

        $validated['hotel_id'] = $hotel->id;

        $room = $hotel->rooms()->create($validated);

        return response()->json($room->refresh(), 201);
    }
    public function update(UpdateRoomRequest $request, Hotel $hotel, Room $room)
{
    // تأكد إن الغرفة تنتمي للفندق
    if ($room->hotel_id !== $hotel->id) {
        return response()->json(['message' => 'Room does not belong to this hotel'], 403);
    }

    $validated = $request->validated();

    // تحويل أي حقل JSON لو موجود
    foreach (['photos','occupancy','seasonal_pricing','availability_calendar','extras'] as $jsonField) {
        if (isset($validated[$jsonField])) {
            $validated[$jsonField] = json_encode($validated[$jsonField]);
        }
    }

    $room->update($validated);

    return response()->json($room->refresh(), 200);
}
public function show(Hotel $hotel, Room $room)
{
 
    if ($room->hotel_id !== $hotel->id) {
        return response()->json(['message' => 'Room does not belong to this hotel'], 403);
    }

    return response()->json($room, 200);
}

public function destroy(Hotel $hotel, Room $room)
{
 
    if ($room->hotel_id !== $hotel->id) {
        return response()->json(['message' => 'Room does not belong to this hotel'], 403);
    }

    $room->delete();

    return response()->json(['message' => 'Room deleted successfully'], 200);
}


}
