<?php

namespace App;

use App\Models\Booking;

class ReviewService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
        public static function userCanReview($userId, $reviewableType, $reviewableId)
    {
        return Booking::where('user_id', $userId)
            ->where('category', $reviewableType) 
            ->where('item_id', $reviewableId)
            ->where('status', 'completed')
            ->exists();
    }
}
