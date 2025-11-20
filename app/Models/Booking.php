<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Payment;
use App\Models\Room;
use App\Models\User;


class Booking extends Model
{
    use HasFactory;
    /** @use HasFactory<\Database\Factories\BookingFactory> */

    protected $fillable = [
        'user_id',
        'room_id',
        'check_in',
        'check_out',
        'category',
        'item_id',
        'status',
        'total_price',
        'payment_status'
    ];

    protected $casts = [
        'guests' => 'array',
        'check_in' => 'date',
        'check_out' => 'date',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

}
