<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Http\Request;
// const TOTAL_ROOMS = 10; // تأكد من وجوده في أعلى الكونترولر
class HotelManagerController extends Controller
{
    const TOTAL_ROOMS = 10; // تأكد من وجوده في أعلى الكونترولر
    /**
     * عرض لوحة تحكم مدير الفندق
     */
    public function index()
    {
        // إحصائيات الحجوزات الشهرية
        

        return view('hotelManager.index' );
    }


    // const TOTAL_ROOMS = 10;
    const MONTHS_IN_YEAR = 12;

public function yearlyOccupancyReport(Request $request){
    $year = $request->input('year', now()->year);
    $roomTypeId = $request->input('room_type_id');
    $report = [];
    $summary = [
        'total_rooms' => 0,
        'total_bookings' => 0,
        'total_occupied_days' => 0,
        'total_available_days' => 0
    ];

    // جلب أنواع الغرف للفلتر
    $roomTypes = RoomType::all();
    
    // تحديد أنواع الغرف المراد عرضها
    $selectedTypes = $roomTypeId 
        ? RoomType::where('id', $roomTypeId)->get()
        : $roomTypes;

    foreach ($selectedTypes as $type) {
        $typeReport = [];
        $typeSummary = [
            'total_rooms' => $type->rooms->count(),
            'total_bookings' => 0,
            'total_occupied_days' => 0,
            'total_available_days' => 0
        ];

        $summary['total_rooms'] += $typeSummary['total_rooms'];

        for ($month = 1; $month <= 12; $month++) {
            $startDate = Carbon::create($year, $month, 1)->startOfMonth();
            $endDate = $startDate->copy()->endOfMonth();
            $daysInMonth = $startDate->daysInMonth;
            $roomIds = $type->rooms->pluck('id');
            $totalRoomDays = $typeSummary['total_rooms'] * $daysInMonth;

            $totalOccupiedDays = 0;
            $bookings = [];

            foreach ($roomIds as $roomId) {
                $roomBookings = Booking::where('room_id', $roomId)
                    ->where('status', '<>', 'cancelled')
                    ->whereYear('check_in_date', $year)
                    ->where(function ($query) use ($startDate, $endDate) {
                        $query->where('check_out_date', '>=', $startDate)
                            ->where('check_in_date', '<=', $endDate);
                    })
                    ->get();

                foreach ($roomBookings as $booking) {
                    if (!isset($bookings[$booking->id])) {
                        $bookings[$booking->id] = true;
                        $typeSummary['total_bookings']++;
                    }

                    $start = max($booking->check_in_date, $startDate);
                    $end = min($booking->check_out_date, $endDate);
                    $days = $start->diffInDays($end) + 1;
                    $totalOccupiedDays += $days;
                    $typeSummary['total_occupied_days'] += $days;
                }
            }

            $typeSummary['total_available_days'] += $totalRoomDays - $totalOccupiedDays;
            
            $occupancyRate = $totalRoomDays > 0 ? ($totalOccupiedDays / $totalRoomDays) * 100 : 0;
            $availabilityRate = 100 - $occupancyRate;

            $typeReport[$month] = [
                'month_name' => $startDate->translatedFormat('F'),
                'occupancy_rate' => round($occupancyRate, 2),
                'availability_rate' => round($availabilityRate, 2),
                'total_bookings' => count($bookings),
                'total_occupied_days' => $totalOccupiedDays,
                'available_room_days' => $totalRoomDays - $totalOccupiedDays,
                'days_in_month' => $daysInMonth,
            ];
        }
        
        // إضافة ملخص النوع إلى الإجمالي
        $summary['total_bookings'] += $typeSummary['total_bookings'];
        $summary['total_occupied_days'] += $typeSummary['total_occupied_days'];
        $summary['total_available_days'] += $typeSummary['total_available_days'];
        
        $report[$type->name] = [
            'data' => $typeReport,
            'summary' => $typeSummary
        ];
    }

    // حساب النسب الإجمالية
    $totalDaysInYear = $selectedTypes->isEmpty() ? 0 : $summary['total_rooms'] * 365;
    $summary['occupancy_rate'] = $totalDaysInYear > 0 
        ? round(($summary['total_occupied_days'] / $totalDaysInYear) * 100, 2) 
        : 0;
        
    $summary['availability_rate'] = 100 - $summary['occupancy_rate'];

    return view('hotelManager.yearly-occupancy', [
        'report' => $report,
        'year' => $year,
        'years' => range(now()->year - 5, now()->year + 5),
        'roomTypes' => $roomTypes,
        'selectedRoomTypeId' => $roomTypeId,
        'summary' => $summary
    ]);
}

 public function monthlyOccupancy(Request $request)
{
    $month = $request->input('month', now()->month);
    $year = $request->input('year', now()->year);
    $roomTypeId = $request->input('room_type_id'); // الفلتر الجديد
    
    $startDate = Carbon::create($year, $month, 1)->startOfMonth();
    $endDate = $startDate->copy()->endOfMonth();
    $daysInMonth = $startDate->daysInMonth;

    // جلب الغرف حسب النوع المحدد
    if ($roomTypeId) {
        $roomIds = Room::where('room_type_id', $roomTypeId)->pluck('id');
        $roomType = RoomType::find($roomTypeId);
        $totalRooms = Room::where('room_type_id', $roomTypeId)->count();
    } else {
        $roomIds = Room::pluck('id');
        $roomType = null;
        $totalRooms = Room::count();
    }

    $totalRoomDays = $totalRooms * $daysInMonth;
    $totalOccupiedDays = 0;
    $dailyOccupancy = [];

    // إعداد بيانات لكل يوم في الشهر
    for ($day = 1; $day <= $daysInMonth; $day++) {
        $currentDate = Carbon::create($year, $month, $day);
        $dailyOccupancy[$day] = [
            'date' => $currentDate->format('Y-m-d'),
            'occupied' => 0,
            'available' => $totalRooms
        ];
    }

    foreach ($roomIds as $roomId) {
        $bookings = Booking::where('room_id', $roomId)
            ->where('status', '<>', 'cancelled')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->where('check_out_date', '>=', $startDate)
                    ->where('check_in_date', '<=', $endDate);
            })
            ->get();

        foreach ($bookings as $booking) {
            $start = max($booking->check_in_date, $startDate);
            $end = min($booking->check_out_date, $endDate);
            $days = $start->diffInDays($end);

            for ($i = 0; $i <= $days; $i++) {
                $currentDay = $start->copy()->addDays($i)->day;
                $dailyOccupancy[$currentDay]['occupied']++;
                $dailyOccupancy[$currentDay]['available']--;
                $totalOccupiedDays++;
            }
        }
    }

    $occupancyRate = $totalRoomDays > 0 ? ($totalOccupiedDays / $totalRoomDays) * 100 : 0;

    $totalOccupiedSum = 0;
    $totalAvailableSum = 0;
    
    foreach ($dailyOccupancy as $day => $data) {
        $totalOccupiedSum += $data['occupied'];
        $totalAvailableSum += $data['available'];
    }

    return view('hotelManager.monthly-occupancy', [
          'totalOccupiedSum' => $totalOccupiedSum,
        'totalAvailableSum' => $totalAvailableSum,
        'dailyOccupancy' => $dailyOccupancy,
        'monthName' => $startDate->translatedFormat('F'),
        'year' => $year,
        'occupancyRate' => round($occupancyRate, 2),
        'availabilityRate' => round(100 - $occupancyRate, 2),
        'totalBookings' => Booking::whereMonth('check_in_date', $month)
                                ->whereYear('check_in_date', $year)
                                ->when($roomTypeId, function ($query) use ($roomTypeId) {
                                    return $query->whereHas('room', function ($q) use ($roomTypeId) {
                                        $q->where('room_type_id', $roomTypeId);
                                    });
                                })
                                ->count(),
        'month' => $month,
        'year' => $year,
        'months' => [
            1 => 'يناير', 2 => 'فبراير', 3 => 'مارس', 4 => 'أبريل',
            5 => 'مايو', 6 => 'يونيو', 7 => 'يوليو', 8 => 'أغسطس',
            9 => 'سبتمبر', 10 => 'أكتوبر', 11 => 'نوفمبر', 12 => 'ديسمبر'
        ],
        'years' => range(now()->year - 2, now()->year + 1),
        'roomTypes' => RoomType::all(), // تمرير أنواع الغرف للفلتر
        'selectedRoomTypeId' => $roomTypeId, // تمرير نوع الغرفة المختار
        'roomType' => $roomType, // تمرير بيانات نوع الغرفة
        'totalRooms' => $totalRooms // إجمالي الغرف للعرض
    ]);
}
}
