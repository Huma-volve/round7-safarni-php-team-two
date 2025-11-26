<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarRental extends Model
{
    protected $fillable = [
        'user_id',
        'car_id',

        // Location
        'pickup_location',
        'dropoff_location',
        'pickup_lat',
        'pickup_lng',
        'dropoff_lat',
        'dropoff_lng',

        // Time
        'pickup_time',
        'dropoff_time',

        // Pricing
        'price_per_hour',
        'total_price',

        // Plan
        'plan_type',
        'duration_hours',
        'duration_days',

        // Status
        'status',
        'payment_status',
        'payment_method',

        'payment_time',
    ];

    public function car(){
        return $this->belongsTo(Car::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
