<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingReview;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $bookingId) {
        $booking = Booking::findOrFail($bookingId);

        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        $review = BookingReview::create([
            'booking_id' => $booking->id,
            'rating' => $data['rating'],
            'comment' => $data['comment'],
        ]);

 return response()->json([
            'message' => 'تم إرسال التقييم',
            'review' => $review
        ], 201);   
     }
}

