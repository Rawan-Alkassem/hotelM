<?php
// namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Controller;
// use App\Models\Booking;
// use App\Models\Room;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Validator;

// class BookingController extends Controller
// {
//     public function index()
//     {
//         $user = Auth::user();
//         $bookings = Booking::with(['room', 'room.type', 'reviews'])
//             ->where('user_id', $user->id)
//             ->get();

//         return response()->json($bookings);
//     }

//     public function store(Request $request)
//     {
//         $validator = Validator::make($request->all(), [
//             'room_id' => 'required|exists:rooms,id',
//             'check_in_date' => 'required|date|after_or_equal:today',
//             'check_out_date' => 'required|date|after:check_in_date',
//         ]);

//         if ($validator->fails()) {
//             return response()->json($validator->errors(), 422);
//         }

//         $room = Room::findOrFail($request->room_id);

//         if ($room->status != 'available') {
//             return response()->json(['message' => 'Room is not available'], 400);
//         }

//         $days = (strtotime($request->check_out_date) - strtotime($request->check_in_date)) / (60 * 60 * 24);
//         $totalPrice = $days * $room->price;

//         $booking = Booking::create([
//             'user_id' => Auth::id(),
//             'room_id' => $request->room_id,
//             'check_in_date' => $request->check_in_date,
//             'check_out_date' => $request->check_out_date,
//             'total_price' => $totalPrice,
//             'status' => 'pending',
//         ]);

//         return response()->json($booking, 201);
//     }

//     public function cancel($id)
//     {
//         $booking = Booking::where('user_id', Auth::id())
//             ->where('id', $id)
//             ->firstOrFail();

//         if ($booking->status != 'pending') {
//             return response()->json(['message' => 'Only pending bookings can be canceled'], 400);
//         }

//         $booking->update(['status' => 'cancelled']);

//         return response()->json(['message' => 'Booking cancelled successfully']);
//     }

//     public function addReview(Request $request, $id)
//     {
//         $validator = Validator::make($request->all(), [
//             'rating' => 'required|integer|between:1,5',
//             'comment' => 'nullable|string|max:500',
//         ]);

//         if ($validator->fails()) {
//             return response()->json($validator->errors(), 422);
//         }

//         $booking = Booking::where('user_id', Auth::id())
//             ->where('id', $id)
//             ->where('status', 'completed')
//             ->firstOrFail();

//         $review = $booking->review()->create([
//             'rating' => $request->rating,
//             'comment' => $request->comment,
//         ]);

//         return response()->json($review, 201);
//     }
// }

//🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴🔴


// 2. BookingController.php
// namespace App\Http\Controllers\API;

// use App\Http\Controllers\Controller;
// use App\Http\Resources\BookingResource;
// use App\Http\Resources\ReviewResource;
// use App\Models\Booking;
// use App\Models\Room;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

// class BookingController extends Controller
// {
//     public function index()
//     {
//         $bookings = Booking::with(['room.type', 'review'])
//             ->where('user_id', Auth::id())
//             ->get();

//         return BookingResource::collection($bookings);
//     }

//     public function store(Request $request)
//     {
//         $data = $request->validate([
//             'room_id' => 'required|exists:rooms,id',
//             'check_in_date' => 'required|date|after_or_equal:today',
//             'check_out_date' => 'required|date|after:check_in_date',
//         ]);

//         $room = Room::findOrFail($data['room_id']);

//         if ($room->status !== 'available') {
//             return response()->json(['message' => 'Room is not available'], 400);
//         }

//         $days = now()->parse($data['check_out_date'])->diffInDays($data['check_in_date']);
//         $totalPrice = $days * $room->price;

//         $booking = Booking::create([
//             'user_id' => Auth::id(),
//             'room_id' => $data['room_id'],
//             'check_in_date' => $data['check_in_date'],
//             'check_out_date' => $data['check_out_date'],
//             'total_price' => $totalPrice,
//             'status' => 'pending'
//         ]);

//         return new BookingResource($booking);
//     }

//     public function cancel($id)
//     {
//         $booking = Booking::where('user_id', Auth::id())->findOrFail($id);

//         if ($booking->status !== 'pending') {
//             return response()->json(['message' => 'Only pending bookings can be canceled'], 400);
//         }

//         $booking->update(['status' => 'cancelled']);

//         return response()->json(['message' => 'Booking cancelled successfully']);
//     }

//     // public function addReview(Request $request, $id)
//     // {
//     //     $data = $request->validate([
//     //         'rating' => 'required|integer|between:1,5',
//     //         'comment' => 'nullable|string|max:500',
//     //     ]);

//     //     $booking = Booking::where('user_id', Auth::id())
//     //         ->where('status', 'completed')
//     //         ->findOrFail($id);

//     //     $review = $booking->review()->create($data);

//     //     return new ReviewResource($review);
//     // }

//     public function addReview(Request $request, $id)
// {
//     $data = $request->validate([
//         'rating' => 'required|integer|between:1,5',
//         'comment' => 'nullable|string|max:500',
//     ]);

//     $booking = Booking::where('user_id', Auth::id())
//                       ->where('status', 'completed')
//                       ->findOrFail($id);

//     $review = $booking->review()->create($data);

//     return new ReviewResource($review);
// }

// }



namespace App\Http\Controllers\API;

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
            return response()->json(['message' => 'حدث خطأ أثناء جلب الحجوزات.', 'error' => $e->getMessage()], 500);
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
                return response()->json(['message' => 'الغرفة غير متاحة حالياً.'], 400);
            }

            $days = now()->parse($data['check_out_date'])->diffInDays($data['check_in_date']);
            $totalPrice = $days * $room->roomType->price;

            $booking = Booking::create([
                'user_id' => Auth::id(),
                'room_id' => $data['room_id'],
                'check_in_date' => $data['check_in_date'],
                'check_out_date' => $data['check_out_date'],
                'total_price' => $totalPrice,
                'status' => 'pending',
            ]);

            $booking->load('room.roomType');

            return new BookingResource($booking);
        } catch (Exception $e) {
            return response()->json(['message' => 'حدث خطأ أثناء إنشاء الحجز.', 'error' => $e->getMessage()], 500);
        }
    }

    public function cancel($id)
    {
        try {
            $booking = Booking::where('user_id', Auth::id())->findOrFail($id);

            if ($booking->status !== 'pending') {
                return response()->json(['message' => 'يمكن فقط إلغاء الحجوزات التي حالتها "قيد الانتظار".'], 400);
            }

            $booking->update(['status' => 'cancelled']);

            return response()->json(['message' => 'تم إلغاء الحجز بنجاح.']);
        } catch (Exception $e) {
            return response()->json(['message' => 'حدث خطأ أثناء إلغاء الحجز.', 'error' => $e->getMessage()], 500);
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
            return response()->json(['message' => 'حدث خطأ أثناء إضافة التقييم.', 'error' => $e->getMessage()], 500);
        }
    }
}
