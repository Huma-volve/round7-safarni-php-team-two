<?php
namespace App\Services;

use App\Models\Room;
use App\Models\Booking;
use Carbon\Carbon;

class HotelBookingService
{
    public function checkAvailability(Room $room, $checkIn, $checkOut)
    {
        $dates = [];
        $current = Carbon::parse($checkIn);
        $end = Carbon::parse($checkOut);
        while ($current->lt($end)) {
            $dates[] = $current->toDateString();
            $current->addDay();
        }
      
// تحقق من التوافر
$conflict = collect($dates)->every(fn($date) => in_array($date, $room->availability_calendar));

    
 return !$conflict;

 



    }
public function book(Room $room, $userId, $checkIn, $checkOut)
{
    if (!$this->checkAvailability($room, $checkIn, $checkOut)) {
        return false;
    }

    // توليد الأيام المطلوبة
    $bookedDates = collect(range(Carbon::parse($checkIn)->timestamp, Carbon::parse($checkOut)->subDay()->timestamp, 86400))
        ->map(fn($ts) => Carbon::createFromTimestamp($ts)->toDateString())
        ->toArray();

    // إضافة الأيام المحجوزة إلى availability_calendar أو booked_dates
    $room->availability_calendar = array_merge($room->availability_calendar, $bookedDates);
    $room->save();

    $current = Carbon::parse($checkIn);
    $end = Carbon::parse($checkOut);
    $numberOfDays = $current->diffInDays($end);
    $total_price = ($numberOfDays + 1) * $room->price_per_night;

    // إنشاء الحجز
    return Booking::create([
        'user_id' => $userId,
        'category' => 'hotel',
        'item_id' => $room->id,
        'status' => 'confirmed',
        'total_price' => $total_price,
        'meta' => [
            'check_in' => $checkIn,
            'check_out' => $checkOut,
            'dates' => $bookedDates
        ]
    ]);
}

}
