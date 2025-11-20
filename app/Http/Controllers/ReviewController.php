<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Review;
use App\ReviewService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
 public function store(StoreReviewRequest $request)
    {
        $userId = auth()->id();

        // Mapping للـ polymorphic types
        $map = [
            'hotel' => \App\Models\Hotel::class,
            'room'  => \App\Models\Room::class,
            // 'tour'  => \App\Models\Tour::class,
        ];

        $reviewableType = $map[$request->reviewable_type];

        // شرط إتمام الحجز قبل كتابة الريفيو
        if (!ReviewService::userCanReview($userId, $request->reviewable_type, $request->reviewable_id)) {
            return response()->json([
                'success' => false,
                'message' => 'You can only review items you have completed booking for.'
            ], 403);
        }

        $review = Review::create([
            'user_id'        => $userId,
            'rating'         => $request->rating,
            'title'          => $request->title,
            'body'           => $request->body,
            'photos'         => $request->photos,
            'reviewable_id'  => $request->reviewable_id,
            'reviewable_type'=> $reviewableType,
            'status'         => 'approved',
        ]);

        return response()->json([
            'success' => true,
            'data' => $review
        ]);
    }
}
