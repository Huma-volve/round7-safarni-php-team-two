<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
   use HasFactory;

      protected $fillable = [
        'booking_id',
        'amount',
        'currency',
        'gateway',
        'status',
        'transaction_id',
        'response_json',
    ];

    protected $casts = [
        'response_json' => 'array',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
