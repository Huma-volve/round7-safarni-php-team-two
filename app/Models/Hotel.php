<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


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
