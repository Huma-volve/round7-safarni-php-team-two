<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlightSeat extends Model
{
    /** @use HasFactory<\Database\Factories\FlightSeatFactory> */
    use HasFactory;
    public function flights(){
        return $this->belongsTo(Flight::class,'flight_id');
    }
}
