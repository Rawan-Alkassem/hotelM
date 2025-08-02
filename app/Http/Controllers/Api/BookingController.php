<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $bookings = Booking::with(['room', 'room.type', 'reviews'])
            ->where('user_id', $user->id)
            ->get();

        return response()->json($bookings);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $room = Room::findOrFail($request->room_id);

        if ($room->status != 'available') {
            return response()->json(['message' => 'Room is not available'], 400);
        }

        $days = (strtotime($request->check_out_date) - strtotime($request->check_in_date)) / (60 * 60 * 24);
        $totalPrice = $days * $room->price;

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $request->room_id,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        return response()->json($booking, 201);
    }

    public function cancel($id)
    {
        $booking = Booking::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        if ($booking->status != 'pending') {
            return response()->json(['message' => 'Only pending bookings can be canceled'], 400);
        }

        $booking->update(['status' => 'cancelled']);

        return response()->json(['message' => 'Booking cancelled successfully']);
    }

    public function addReview(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $booking = Booking::where('user_id', Auth::id())
            ->where('id', $id)
            ->where('status', 'completed')
            ->firstOrFail();

        $review = $booking->review()->create([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return response()->json($review, 201);
    }
}