<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function flights()
    {
        return $this->hasMany(Flight::class);
    }

    public function hotels()
    {
        return $this->hasMany(Hotel::class);
    }

    public function tours()
    {
        return $this->hasMany(Tour::class);
    }

    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
