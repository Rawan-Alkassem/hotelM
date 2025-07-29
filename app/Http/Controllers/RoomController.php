<?php

namespace App\Http\Controllers;



use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        $rooms = Room::with('roomType')->get();
        return view('rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
        $roomTypes = RoomType::all();
        return  view('rooms.create', compact('roomTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request)
    {
        Room::create($request->validated());

        return redirect()->route('rooms.index')->with('success', 'Room created successfully.');
    }




    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        return view('rooms.show', compact('room'));
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        $roomTypes = RoomType::all();
        return view('rooms.edit', compact('room', 'roomTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request, Room $room)
    {
        $room->update($request->validated());

        return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    }
  
  public function checkRoomAvailability(Request $request)
{
      if (!$request->has('date')) {
        return view('room-availability', [
            'date' => null,
            'days' => 1,
            'availableRooms' => collect(),
            'bookedRooms' => collect(),
            'selectedRoomType' => null,
            'checkOutDate' => null
        ]);
    }
    $request->validate([
        'date' => 'required|date',
        'days' => 'required|integer|min:1', // تأكد من أن الأيام عدد صحيح
        'room_type' => 'nullable|in:SR,DR,VIPSR,VIPDR'
    ]);

    // تحويل الأيام لعدد صحيح للتأكد من النوع
    $days = (int)$request->days;
    $checkInDate = Carbon::parse($request->date);
    $checkOutDate = $checkInDate->copy()->addDays($days);

    // استعلام أساسي للغرف
    $roomQuery = Room::with(['roomType', 'bookings' => function($query) use ($checkInDate, $checkOutDate) {
        $query->whereIn('status', ['pending', 'confirmed'])
              ->where(function($q) use ($checkInDate, $checkOutDate) {
                  $q->whereBetween('check_in_date', [$checkInDate, $checkOutDate])
                    ->orWhereBetween('check_out_date', [$checkInDate, $checkOutDate])
                    ->orWhere(function($q) use ($checkInDate, $checkOutDate) {
                        $q->where('check_in_date', '<', $checkInDate)
                          ->where('check_out_date', '>', $checkOutDate);
                    });
              });
    }]);

    // تطبيق فلتر نوع الغرفة إذا كان موجوداً
    if ($request->filled('room_type')) {
        $roomQuery->where('room_number', 'REGEXP', '[0-9]'.$request->room_type.'$');
    }

    // الغرف المتاحة (غير محجوزة في الفترة المحددة)
    $availableRooms = (clone $roomQuery)
        ->whereDoesntHave('bookings', function($query) use ($checkInDate, $checkOutDate) {
            $query->whereIn('status', ['pending', 'confirmed'])
                  ->where(function($q) use ($checkInDate, $checkOutDate) {
                      $q->whereBetween('check_in_date', [$checkInDate, $checkOutDate])
                        ->orWhereBetween('check_out_date', [$checkInDate, $checkOutDate])
                        ->orWhere(function($q) use ($checkInDate, $checkOutDate) {
                            $q->where('check_in_date', '<', $checkInDate)
                              ->where('check_out_date', '>', $checkOutDate);
                        });
                  });
        })
        ->get();

    // الغرف المحجوزة (محجوزة في الفترة المحددة)
    $bookedRooms = (clone $roomQuery)
        ->whereHas('bookings', function($query) use ($checkInDate, $checkOutDate) {
            $query->whereIn('status', ['pending', 'confirmed'])
                  ->where(function($q) use ($checkInDate, $checkOutDate) {
                      $q->whereBetween('check_in_date', [$checkInDate, $checkOutDate])
                        ->orWhereBetween('check_out_date', [$checkInDate, $checkOutDate])
                        ->orWhere(function($q) use ($checkInDate, $checkOutDate) {
                            $q->where('check_in_date', '<', $checkInDate)
                              ->where('check_out_date', '>', $checkOutDate);
                        });
                  });
        })
        ->get();

    return view('room-availability', [
        'date' => $checkInDate,
        'days' => $days, // تأكد من إرسال المتغير days
        'availableRooms' => $availableRooms,
        'bookedRooms' => $bookedRooms,
        'selectedRoomType' => $request->room_type,
        'checkOutDate' => $checkOutDate // إضافة متغير تاريخ المغادرة
    ]);
}

public function showConfirmation(Request $request)
{
    $request->validate([
        'room_id' => 'required|exists:rooms,id',
        'room_number' => 'required|string',
        'room_type' => 'nullable|string',
        'check_in_date' => 'required|date',
        'check_out_date' => 'required|date',
        'days' => 'required|integer|min:1',
        'price_per_night' => 'required|numeric',
        'total_price' => 'required|numeric'
    ]);

    return view('bookings.confirmation', [
        'bookingDetails' => $request->all()
    ]);
}

public function saveForLater(Request $request)
{
    $validated = $request->validate([
        'room_id' => 'required|exists:rooms,id',
        'check_in_date' => 'required|date',
        'check_out_date' => 'required|date|after:check_in_date',
        'days' => 'required|integer|min:1',
        'total_price' => 'required|numeric'
    ]);

    // يمكنك استخدام نفس نموذج Booking أو إنشاء نموذج جديد للحجوزات المحفوظة
    // $Booking = new BOOKING(); // إذا كنت تريد فصلها في جدول مختلف
    // أو استخدام نفس نموذج Booking مع تغيير الحالة
    $booking = new Booking();
    $booking->user_id = auth()->id();
    $booking->room_id = $validated['room_id'];
    $booking->check_in_date = $validated['check_in_date'];
    $booking->check_out_date = $validated['check_out_date'];
    $booking->total_price = $validated['total_price'];
    $booking->status = 'pending'; // أضف هذه الحالة إلى الحالات المسموحة
    $booking->save();

    return redirect()->route('bookings.index')
           ->with('success', 'تم حفظ الحجز لاحقاً بنجاح');
}
}
