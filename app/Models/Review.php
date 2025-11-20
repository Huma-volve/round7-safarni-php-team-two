<?php
// app/Models/Review.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'user_id', 'rating', 'title', 'body', 'photos',
        'reviewable_id', 'reviewable_type', 'status'
    ];

    protected $casts = [
        'photos' => 'array'
    ];

    public function reviewable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
