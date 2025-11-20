<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Room extends Model
{
   use HasFactory;
    
 protected $fillable = [
        'hotel_id',
        'name',
        'description',
        'main_image',
        'photos',
        'capacity',  
        'room_area',
        'price_per_night',
        'offer', 
        'availability_calendar',
    ];

    protected $casts = [
           'photos' => 'array',
    'availability_calendar' => 'array',
        'offer' => 'array',  
        'capacity' => 'integer',
        'room_area' => 'integer',
        'price_per_night' => 'decimal:2',
    ];
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
public function bookings()
{
    return $this->hasMany(Booking::class);
}
public function reviews()
{
    return $this->morphMany(Review::class, 'reviewable')->where('status', 'approved');
}

}
