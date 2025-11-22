<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Car extends Model
{
    use HasFactory;
    protected $fillable = [
        'model',
        'price',
        'rating',
        'image',
        'category_id',
        'city',
        'location'
    ];

    protected $hidden = ['location'];

protected $appends = ['lat', 'lng'];

public function getLatAttribute()
{
    return DB::selectOne('SELECT ST_Y(location) as lat FROM cars WHERE id=?', [$this->id])->lat;
}

public function getLngAttribute()
{
    return DB::selectOne('SELECT ST_X(location) as lng FROM cars WHERE id=?', [$this->id])->lng;
}

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
