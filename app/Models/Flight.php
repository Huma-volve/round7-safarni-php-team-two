<?php

namespace App\Models;

use App\Enums\FlightStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    /** @use HasFactory<\Database\Factories\FlightFactory> */
    use HasFactory;
    protected $guarded=[];
    protected $casts=[
        'status'=>FlightStatus::class,
        'departure_at' => 'datetime',
        'arrival_at' => 'datetime',
    ];
    public function original_airport()
    {
        return $this->belongsTo(Airport::class,'origin_airport_id');
    }
    public function dest_airport(){
        return $this->belongsTo(Airport::class,'dest_airport_id');
    }
    public function carriers(){
        return $this->belongsTo(Carrier::class,'carrier_id');
    }

}
