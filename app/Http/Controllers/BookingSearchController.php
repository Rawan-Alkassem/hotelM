<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room;

class BookingSearchController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'room_type' => 'nullable|in:SR,DR,VIPSR,VIPDR',
            'status' => 'nullable|in:pending,confirmed,cancelled,finished',
            'date' => 'nullable|date'
        ]);

        $query = Booking::with(['room.roomType', 'user']);

        // Filter by room type
        if (!empty($validated['room_type'])) {
            $query->whereHas('room', function($q) use ($validated) {
                $q->where('room_number', 'LIKE', '%'.$validated['room_type'].'%');
            });
        }

        // Filter by status
        if (!empty($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        // Filter by date
        if (!empty($validated['date'])) {
            $query->whereDate('check_in_date', '<=', $validated['date'])
                  ->whereDate('check_out_date', '>=', $validated['date']);
        }

        $bookings = $query->paginate(10);

        return view('bookings.filter', compact('bookings'));
    }
}
