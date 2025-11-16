<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'hotel_id',
        'name',
        'description',
        'main_image',
        'photos',
        'occupancy',
        'bed_type',
        'room_area',
        'price_per_night',
        'seasonal_pricing',
        'availability_calendar',
        'refundable',
        'extras',
    ];
    protected $cast = [
        "photos",
        "occupancy",
        "seasonal_pricing",
        "availability_calendar",
        "extras",
    ];
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
