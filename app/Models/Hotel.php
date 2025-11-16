<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
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
}
