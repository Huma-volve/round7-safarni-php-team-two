<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use App\Traits\HasMediaCollections;
use App\Traits\AddMedia;
use Spatie\Image\Manipulations;



class Hotel extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasMediaCollections, AddMedia;
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
        'location',
        'contact_info'
    ];
    protected $cast = [
        'amenities',
        'policies',
        'contact_info',
    ];

    /**
     * Register media collections.
     */
    protected array $mediaCollections = [
        'hotel_image' => ['single' => true, 'disk' => 'public'],
        'hotel_gallery' => ['single' => false, 'disk' => 'public', 'limit' => 12],
    ];

    /**
     * Register conversions (thumbnails, responsive sizes).
     * تقدر تعدل القياسات حسب احتياج الواجهة.
     */
    protected array $mediaConversions = [
        [
            'name' => 'thumb_webp',
            'width' => 400,
            'height' => 300,
            'format' => Manipulations::FORMAT_WEBP,
            'collections' => ['hotel_image', 'gallery'],
            'queued' => false,
            'sharpen' => 5,
        ],
        [
            'name' => 'large_webp',
            'width' => 1600,
            'height' => 900,
            'format' => Manipulations::FORMAT_WEBP,
            'collections' => ['hotel_image', 'hotel_gallery'],
            'queued' => false,
        ],
    ];
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

}
