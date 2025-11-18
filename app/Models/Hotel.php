<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;


class Hotel extends Model
{
    use HasFactory;
    protected $fillable=[
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
    protected $cast=[
        'amenities',
        'policies',
        'contact_info',
    ];
    public function rooms()
{
    return $this->hasMany(Room::class);
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
