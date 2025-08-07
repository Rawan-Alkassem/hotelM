<?php




namespace App\Http\Controllers\API;
use Illuminate\Notifications\Notifiable;
use App\Notifications\BookingStatusChanged;


use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Http\Resources\ReviewResource;
use App\Models\Booking;
use App\Models\Room;
use App\Models\BookingReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class BookingController extends Controller
{
    public function index()
    {
        try {
            $bookings = Booking::with(['room.roomType', 'reviews']) // تم تصحيح العلاقات
                ->where('user_id', Auth::id())
                ->get();

            return BookingResource::collection($bookings);
        } catch (Exception $e) {
            return response()->json(['message' => '  An error occurred while fetching the bookings.  ', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);

        try {
            $room = Room::with('roomType')->findOrFail($data['room_id']);

            if ($room->status !== 'available') {
                return response()->json(['message' => 'The room is currently unavailable.'], 400);
            }

            $days = now()->parse($data['check_out_date'])->diffInDays($data['check_in_date']);
            $totalPrice = $days * $room->roomType->price * -1;

            $booking = Booking::create([
                'user_id' => Auth::id(),
                'room_id' => $data['room_id'],
                'check_in_date' => $data['check_in_date'],
                'check_out_date' => $data['check_out_date'],
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            // send email
            $booking->load('room.roomType');
$booking->user->notify(new BookingStatusChanged($booking));

            return new BookingResource($booking);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred while creating the booking.', 'error' => $e->getMessage()], 500);
        }
    }

    public function cancel($id)
    {
        try {
            $booking = Booking::where('user_id', Auth::id())->findOrFail($id);

            if ($booking->status !== 'pending') {
                return response()->json(['message' => 'Only bookings with the status "Pending" can be cancelled.'], 400);
            }

            $booking->update(['status' => 'cancelled']);
$booking->user->notify(new BookingStatusChanged($booking));

            return response()->json(['message' => ' The booking has been successfully cancelled..']);
        } catch (Exception $e) {
            return response()->json(['message' => ' An error occurred while cancelling the booking.', 'error' => $e->getMessage()], 500);
        }
    }

    public function addReview(Request $request, $id)
    {
        $data = $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:500',
        ]);

        try {
            // $booking = Booking::where('user_id', Auth::id())
            //                   ->where('status', 'confirmed')
            //                   ->findOrFail($id);
            $booking = Booking::where('user_id', Auth::id())
                  ->whereIn('status', ['confirmed', 'finished'])
                  ->findOrFail($id);

            $review = $booking->reviews()->create($data); // العلاقة هي reviews not review

            return new ReviewResource($review);
        } catch (Exception $e) {
            return response()->json(['message' => 'An error occurred while adding the review, u can add a review if the booking is confirmed or finished , or the booking is not in your name', 'error' => $e->getMessage()], 500);
        }
    }
}
