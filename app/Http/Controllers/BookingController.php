<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('user')->paginate(20);
        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $users = User::all();
        $rooms = Room::where('status', 'available')->get();
        return view('bookings.create', compact('users', 'rooms'));
    }

        public function store(Request $request)
        {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'room_id' => 'required|exists:rooms,id',
                'check_in_date' => 'required|date',
                'check_out_date' => 'required|date|after:check_in_date',
            ]);

            $days = Carbon::parse($request->check_in_date)
                ->diffInDays(Carbon::parse($request->check_out_date));

            $validated['total_price'] = $days * 180; // 180 هو سعر الليلة
            $validated['status'] = 'pending';

            Booking::create($validated);

            return redirect()->route('bookings.index')
                ->with('success', 'تم إنشاء الحجز بنجاح');
        }

    public function edit(Booking $booking)
    {
        $users = User::all();
        $rooms = Room::where('status', 'available')->get();
        return view('bookings.edit', compact('booking', 'users', 'rooms'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'status' => 'required|in:pending,confirmed,cancelled,finished',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);

        $days = Carbon::parse($request->check_in_date)
            ->diffInDays(Carbon::parse($request->check_out_date));

        $validated['total_price'] = $days * 180;

        $booking->update($validated);

        return redirect()->route('bookings.index')
            ->with('success', 'تم تحديث الحجز بنجاح');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('bookings.index')
            ->with('success', 'تم حذف الحجز بنجاح');
    }
}