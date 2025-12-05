<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

use Spatie\MediaLibrary\Conversions\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
//use App\Traits\HasMediaCollections;
use App\Traits\AddMedia;
 


class Hotel extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia,AddMedia;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'address',
        'latitude',
        'longitude',
        'image',
        'amenities',
        'rating',
        'policies',
        'city',
        'location',
        'contact_info',
        'category_id',
    ];

    protected $hidden = ['location'];

    protected $casts = [
        'amenities'    => 'array',
        'policies'     => 'array',
        'contact_info' => 'array',
    ];

    /**
     * Register media collections.
     */
 

    /**
     * Register conversions (thumbnails, responsive sizes).
     * تقدر تعدل القياسات حسب احتياج الواجهة.
     */

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('hotel_image')->singleFile()->useDisk('public');
        $this->addMediaCollection('hotel_gallery');
    }

public function registerMediaConversions(Media $media = null): void
{
    
    $this->addMediaConversion('thumb_webp')->useDisk('public')->width(400)
         ->height(300)
         ->format('webp')
         ->sharpen(5)
         ->performOnCollections('hotel_image', 'hotel_gallery');

    $this->addMediaConversion('large_webp')
         ->width(1600)
         ->height(900)
      ->format('webp')
         ->performOnCollections('hotel_image', 'hotel_gallery');
}
 
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable')->where('status', 'approved');
    }

    protected $appends = ['latitude', 'longitude'];

    public function getLatitudeAttribute()
    {
        $result = DB::selectOne('SELECT ST_X(location) as lat FROM hotels WHERE id = ?', [$this->id]);
        return $result?->lat;
    }

    public function getLongitudeAttribute()
    {
        $result = DB::selectOne('SELECT ST_Y(location) as lng FROM hotels WHERE id = ?', [$this->id]);
        return $result?->lng;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
