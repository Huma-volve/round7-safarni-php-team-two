<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
class Room extends Model  implements HasMedia
{
   use HasFactory;
    
     use InteractsWithMedia;

public function registerMediaCollections(): void
{
    $this->addMediaCollection('main_image')->singleFile();
    $this->addMediaCollection('photos');
}
 protected $fillable = [
        'hotel_id',
        'name',
        'description',
        'capacity',  
        'room_area',
        'price_per_night',
        'offer', 
        'availability_calendar',
    ];

    protected $casts = [
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
