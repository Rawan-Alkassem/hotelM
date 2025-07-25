<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use App\Models\Room;
use Illuminate\Support\Carbon;

class RoomPublicController extends Controller
{
   public function index(Request $request)
    {
        $today = Carbon::today();

       
        $rooms = Room::with('roomType', 'images')
            ->where(function ($query) use ($today) {
                $query->where('status', 'available')
                    ->orWhereDoesntHave('bookings', function ($sub) use ($today) {
                        $sub->where('status', 'confirmed')
                            ->where('check_in_date', '<=', $today)
                            ->where('check_out_date', '>', $today);
                    });
            })
            ->get();

        return response()->json($rooms);
    }

    public function show($id)
    {
        $room = Room::with('roomType', 'images', 'roomType.services')->findOrFail($id);
        return response()->json($room);
    }

    public function roomsByType($id)
    {
        $today = Carbon::today();

        $rooms = Room::where('room_type_id', $id)
            ->with([
                'images',
                'bookings' => function ($q) {
                    $q->where('status', 'confirmed');
                }
            ])
            ->get()
            ->filter(function ($room) use ($today) {
                $hasBookingNow = $room->bookings->contains(function ($booking) use ($today) {
                    return $booking->check_in_date <= $today && $booking->check_out_date > $today;
                });

                return !$hasBookingNow;
            })
            ->map(function ($room) use ($today) {
                $nextBooking = $room->bookings
                    ->where('check_in_date', '>', $today)
                    ->sortBy('check_in_date')
                    ->first();

                return [
                    'id' => $room->id,
                    'room_number' => $room->room_number,
                    'price' => $room->price,
                    'status' => $nextBooking ? 'available_now_but_booked_later' : 'completely_available',
                    'next_booking_start' => optional($nextBooking)->check_in_date?->toDateString(),
                    'images' => $room->images->pluck('image_url'),
                ];
            })
            ->values();

 return response()->json($rooms,200);
    }
}
