<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Booking;
use App\Models\CheckInOutLog;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
// use Illuminate\Pagination\LengthAwarePaginator;
// use App\Http\Middleware\CheckBookingDates;

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
    $customers = User::whereHas('roles', function($query) {
        $query->where('name', 'Customer');
    })->get();

    $rooms = Room::where('status', 'available')->get();
    return view('bookings.create', compact('customers', 'rooms'));
}


public function store(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'nullable|exists:users,id',
        'receptionist_id' => 'required|exists:users,id',
        'room_id' => 'required|exists:rooms,id',
        'check_in_date' => 'required|date|after_or_equal:today',
        'check_out_date' => 'required|date|after:check_in_date',
    ], [
        'check_in_date.after_or_equal' => 'Check-in date must be today or a future date',
        'check_out_date.after' => 'Check-out date must be after check-in date',
        'room_id.required' => 'Please select a room',
        'room_id.exists' => 'The selected room does not exist',
        'user_id.required' => 'Please select a customer',
    ]);

    // التأكد أن المستخدم المحدد لديه دور Customer
    $customer = User::findOrFail($request->user_id);
    if (!$customer->hasRole('Customer')) {
        return back()->withErrors(['user_id' => 'The selected user is not a customer']);
    }

    $days = Carbon::parse($request->check_in_date)
        ->diffInDays(Carbon::parse($request->check_out_date));

    $validated['total_price'] = $days * 180;
    $validated['status'] = 'pending';
        $validated['user_id'] = ;

    // إنشاء الحجز
    $booking = Booking::create($validated);

    // إنشاء سجل الدخول والخروج المرتبط بالحجز
    CheckInOutLog::create([
        'booking_id' => $booking->id,
        'receptionist_id' => $validated['receptionist_id'],
        'check_in_time' => null, // سيتم تعيينه عند الدخول الفعلي
        'check_out_time' => null // سيتم تعيينه عند الخروج الفعلي
    ]);

    return redirect()->route('bookings.index')
        ->with('success', 'تم إنشاء الحجز بنجاح');
}
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
        'receptionist_id' => 'required|exists:users,id',
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
    public function finish(Booking $booking)
{
    $booking->update(['status' => 'finished']);

    return redirect()->route('bookings.index')
        ->with('success', 'Booking marked as finished successfully');
}

public function info(Booking $booking){
    $booking->load(['user', 'room.roomType', 'receptionist', 'checkInOutLog.receptionist']);

    return view('bookings.info', compact('booking'));
}


public function editLog(Booking $booking)
{
    $booking->load(['checkInOutLog']);
    return view('bookings.edit-log', compact('booking'));
}

public function updateLog(Request $request, Booking $booking){
    $validated = $request->validate([
        'check_in_time' => 'nullable|date',
        'check_out_time' => 'nullable|date|after:check_in_time',
    ]);

    if (!$booking->checkInOutLog) {
        // إنشاء سجل جديد إذا لم يكن موجوداً
        $booking->checkInOutLog()->create([
            'receptionist_id' => auth()->id(),
            'check_in_time' => $validated['check_in_time'],
            'check_out_time' => $validated['check_out_time']
        ]);
    } else {
        // تحديث السجل الموجود
        $booking->checkInOutLog->update([
            'check_in_time' => $validated['check_in_time'],
            'check_out_time' => $validated['check_out_time'],
            'receptionist_id' => auth()->id()
        ]);
    }

    return redirect()->route('bookings.info', $booking->id)
        ->with('success', 'تم تحديث أوقات الدخول والخروج بنجاح');
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

    // تحديث حالة الغرفة
    Room::where('id', $validated['room_id'])->update(['status' => 'booked']);

    return redirect()->route('bookings.index')
                     ->with('success', 'تم تأكيد الحجز بنجاح!');
}






}
