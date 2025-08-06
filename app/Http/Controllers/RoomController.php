<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomImage;
use App\Models\RoomType;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    /**
     * عرض قائمة الغرف
     */
    public function index()
    {
        $rooms = Room::with('roomType')->get();
        return view('rooms.index', compact('rooms'));
    }

    /**
     * عرض صفحة إضافة غرفة جديدة
     */
    public function create()
    {
        $roomTypes = RoomType::all();
        return view('rooms.create', compact('roomTypes'));
    }

    /**
     * تخزين غرفة جديدة
     */
   public function store(StoreRoomRequest $request)
{
    $room = Room::create($request->validated());

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $imageFile) {
            $path = $imageFile->store('room_images', 'public');
            $room->images()->create([
                'image_path' => $path,
            ]);
        }
    }

    return redirect()->route('rooms.index')->with('success', 'Room created successfully.');
}


    /**
     * عرض تفاصيل غرفة
     */
    public function show(Room $room)
    {
        return view('rooms.show', compact('room'));
    }

    /**
     * عرض صفحة تعديل غرفة
     */
 public function edit(Room $room)
{
    $roomTypes = RoomType::all();
    $allServices = Service::all();  // كل الخدمات المتاحة

    $roomServices = $room->services()->pluck('services.id')->toArray(); // خدمات الغرفة الحالية

    return view('rooms.edit', compact('room', 'roomTypes', 'allServices', 'roomServices'));
}


    /**
     * تحديث بيانات الغرفة
     */
public function update(UpdateRoomRequest $request, Room $room)
{
    $room->update($request->validated());

    // تحديث الخدمات
    if ($request->has('services')) {
        $room->services()->sync($request->input('services'));
    } else {
        $room->services()->detach();
    }

    // حذف الصور اللي علّمها المستخدم للحذف
    if ($request->has('delete_images')) {
        foreach ($request->delete_images as $imageId) {
            $image = RoomImage::find($imageId);
            if ($image) {
                Storage::disk('public')->delete($image->image_path);
                $image->delete();
            }
        }
    }

    // رفع الصور الجديدة إذا وجدت
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $imageFile) {
            $path = $imageFile->store('room_images', 'public');
            $room->images()->create([
                'image_path' => $path,
            ]);
        }
    }

    return redirect()->route('rooms.index')->with('success', 'Room updated successfully.');
}

    /**
     * حذف غرفة
     */
    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Room deleted successfully.');
    }




    /**
     * التحقق من توفر الغرف
     */
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
            'days' => 'required|integer|min:1',
            'room_type' => 'nullable|in:SR,DR,VIPSR,VIPDR'
        ]);

        $days = (int)$request->days;
        $checkInDate = Carbon::parse($request->date);
        $checkOutDate = $checkInDate->copy()->addDays($days);

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

        if ($request->filled('room_type')) {
            $roomQuery->where('room_number', 'REGEXP', '[0-9]'.$request->room_type.'$');
        }

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
            'days' => $days,
            'availableRooms' => $availableRooms,
            'bookedRooms' => $bookedRooms,
            'selectedRoomType' => $request->room_type,
            'checkOutDate' => $checkOutDate
        ]);
    }

    /**
     * عرض صفحة تأكيد الحجز
     */
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

    /**
     * حفظ الحجز لوقت لاحق
     */
    public function saveForLater(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'days' => 'required|integer|min:1',
            'total_price' => 'required|numeric'
        ]);

        $booking = new Booking();
        // $booking->user_id = auth()->id();
        
$booking->user_id = Auth::id();
        $booking->room_id = $validated['room_id'];
        $booking->check_in_date = $validated['check_in_date'];
        $booking->check_out_date = $validated['check_out_date'];
        $booking->total_price = $validated['total_price'];
        $booking->status = 'pending';
        $booking->save();

        return redirect()->route('bookings.index')->with('success', 'تم حفظ الحجز لاحقاً بنجاح');
    }
}
