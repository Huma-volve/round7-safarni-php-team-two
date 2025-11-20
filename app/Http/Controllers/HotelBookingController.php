<?php
namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Http\Requests\HotelBookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Room;
use App\Services\HotelBookingService;

class HotelBookingController extends Controller
{
    protected $bookingService;

 

 public function __construct(HotelBookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function store(HotelBookingRequest $request)
    {
        $room = Room::findOrFail($request->room_id);

        $booking = $this->bookingService->book($room, $request->user()->id, $request->check_in, $request->check_out);

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'الغرفة غير متاحة في هذه التواريخ'
            ], 422);
        }

        return new BookingResource($booking);
    }
}
