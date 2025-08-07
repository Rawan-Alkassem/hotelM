<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Room;
use App\Models\User;
use App\Models\Booking;
use App\Models\RoomType;
use Illuminate\Http\Request;
use App\Models\CheckInOutLog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Http\Middleware\CheckBookingDates;
use App\Notifications\BookingStatusChanged;
use Illuminate\Pagination\LengthAwarePaginator;
use Symfony\Component\HttpFoundation\RedirectResponse;

class BookingController extends Controller
{
public function __construct()
{
    // $this->middleware(CheckBookingDates::class)->only('store');
}

    public function index()
    {
        $bookings = Booking::with('user')->paginate(10);
        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        // $users = User::all();
 $customers = User::whereHas('roles', function($query) {
        $query->where('name', 'Customer');
    })->get();

        $rooms = Room::where('status', 'available')->get();
        return view('bookings.create', compact('customers', 'rooms'));
    }
////////////////////////////////////////////////////
//
//
//


      public function store(Request $request): RedirectResponse
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
        'room_id' => 'required|exists:rooms,id',
   'check_in_date' => 'required|date|after_or_equal:today',
    'check_out_date' => 'required|date|after:check_in_date',
       ], [
        'check_in_date.after_or_equal' => 'Check-in date must be today or a future date',
        'check_out_date.after' => 'Check-out date must be after check-in date',
        'room_id.required' => 'Please select a room',
        'room_id.exists' => 'The selected room does not exist',
    ]);
     $data = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);

$room = Room::with('roomType')->findOrFail($data['room_id']);

    $days = Carbon::parse($request->check_in_date)
        ->diffInDays(Carbon::parse($request->check_out_date));

    $validated['total_price'] = $days * $room->roomType->price;
    $validated['status'] = 'pending';

 $booking =   Booking::create($validated);
 $booking->user->notify(new BookingStatusChanged($booking));

    return redirect()->route('bookings.index')
        ->with('success', '  The booking has been successfully updated. ');
}

    // public function edit(Booking $booking)
    // {
    //     $users = User::all();
    //     $rooms = Room::where('status', 'available')->get();
    //     return view('bookings.edit', compact('booking', 'users', 'rooms'));
    // }

    public function edit(Booking $booking)
{
    $customers = User::whereHas('roles', function($query) {
        $query->where('name', 'Customer');
    })->get();

    $roomTypes = RoomType::all();
    $rooms = Room::with('roomType')->get();

    return view('bookings.edit', compact('booking', 'customers', 'roomTypes', 'rooms'));
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



    // التأكد أن المستخدم المحدد لديه دور Customer
    $customer = User::findOrFail($request->user_id);
    if (!$customer->hasRole('Customer')) {
        return back()->withErrors(['user_id' => 'The selected user is not a customer']);
    }

    $days = Carbon::parse($request->check_in_date)
        ->diffInDays(Carbon::parse($request->check_out_date));
$room = Room::with('roomType')->findOrFail($validated['room_id']);

    $validated['total_price'] = $days * $room->roomType->price;
    $booking->update($validated);



 $booking->user->notify(new BookingStatusChanged($booking));

    return redirect()->route('bookings.index')
        ->with('success', '  The booking has been successfully updated. ');
        // $days = Carbon::parse($request->check_in_date)
        //     ->diffInDays(Carbon::parse($request->check_out_date));

        // $validated['total_price'] = $days * 180;

        // $booking->update($validated);

        // return redirect()->route('bookings.index')
        //     ->with('success', 'تم تحديث الحجز بنجاح');
    }
//
//
//
    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('bookings.index')
            ->with('success', ' The booking has been successfully deleted.');
    }
    public function finish(Booking $booking)
{
    $booking->update(['status' => 'finished']);

    return redirect()->route('bookings.index')
        ->with('success', 'Booking marked as finished successfully');
}


//

//

///


public function info(Booking $booking)
{
    $booking->load(['user', 'room.roomType', 'checkInOutLogs']);

    return view('bookings.info', compact('booking'));
}


public function editLog(Booking $booking)
{
    $booking->load(['checkInOutLogs']);
    return view('bookings.edit-log', compact('booking'));
}

public function updateLog(Request $request, Booking $booking){
    $validated = $request->validate([
        'check_in_time' => 'nullable|date',
        'check_out_time' => 'nullable|date|after:check_in_time',
    ]);

    if (!$booking->checkInOutLogs) {
        // إنشاء سجل جديد إذا لم يكن موجوداً
        $booking->checkInOutLogs()->create([
            'receptionist_id' => auth()->id(),
            'check_in_time' => $validated['check_in_time'],
            'check_out_time' => $validated['check_out_time']
        ]);
    } else {
        // تحديث السجل الموجود
        $booking->checkInOutLogs->update([
            'check_in_time' => $validated['check_in_time'],
            'check_out_time' => $validated['check_out_time'],
            'receptionist_id' => auth()->id()
        ]);
    }

    return redirect()->route('bookings.info', $booking->id)
        ->with('success', 'Check-in and check-out times have been successfully updated.');
}

public function confirmBooking(Request $request)
{
    // لن نعيد التحقق من التواريخ هنا لأن الميدل وير قام بذلك
    $validated = $request->validate([
        'room_id' => 'required|exists:rooms,id',
        'check_in_date' => 'required|date',
        'check_out_date' => 'required|date',
        'total_price' => 'required|numeric|min:0',
        'receptionist_id' => 'nullable|exists:users,id'
    ]);

    // إنشاء الحجز
    $booking = Booking::create([
        'user_id' => Auth::id(),
        'room_id' => $validated['room_id'],
        'receptionist_id' => $validated['receptionist_id'] ?? null,
        'check_in_date' => $validated['check_in_date'],
        'check_out_date' => $validated['check_out_date'],
        'total_price' => $validated['total_price'],
        'status' => 'confirmed'
    ]);
 $booking->user->notify(new BookingStatusChanged($booking));

    // تحديث حالة الغرفة
    Room::where('id', $validated['room_id'])->update(['status' => 'booked']);

    return redirect()->route('bookings.index')
                     ->with('success', 'The booking has been successfully confirmed!');
}










}
