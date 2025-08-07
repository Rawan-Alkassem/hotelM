<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
 use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Service;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ReportController extends Controller
{
    //
// use Carbon\Carbon;
// use App\Models\Booking;

public function profitReport()
{
    $now = Carbon::now();

    $profits = [];

    $profits['this_month'] = Booking::whereMonth('created_at', $now->month)
        ->whereYear('created_at', $now->year)
        ->sum('total_price');

    $profits['last_month'] = Booking::whereMonth('created_at', $now->copy()->subMonth()->month)
        ->whereYear('created_at', $now->copy()->subMonth()->year)
        ->sum('total_price');

    $profits['this_year'] = Booking::whereYear('created_at', $now->year)->sum('total_price');

    $profits['last_year'] = Booking::whereYear('created_at', $now->copy()->subYear()->year)->sum('total_price');

    // أرباح الأسابيع الأربعة الماضية
    $profits['last_4_weeks'] = [];
    for ($i = 0; $i < 4; $i++) {
        $start = Carbon::now()->startOfWeek()->subWeeks($i);
        $end = $start->copy()->endOfWeek();
        $profits['last_4_weeks'][4 - $i] = Booking::whereBetween('created_at', [$start, $end])->sum('total_price');
    }

    // إضافات
    $profits['total_bookings'] = Booking::count();
    $monthly = Booking::selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
        ->whereYear('created_at', $now->year)
        ->groupBy('month')
        ->orderByDesc('total')
        ->get();

    $profits['top_month'] = $monthly->first() ? Carbon::create()->month($monthly->first()->month)->format('F') : '-';
    $profits['top_month_value'] = $monthly->first()->total ?? 0;
    $profits['monthly_average'] = round($monthly->avg('total'), 2);

    return view('reports.profits', compact('profits'));
}


    public function index()
    {
        // تقرير الأرباح
        $totalRevenue = Booking::where('status', 'finished')->sum('total_price');

        // الخدمات الأكثر طلباً
        $popularServices = DB::table('services')
            ->select('services.name', DB::raw('COUNT(*) as usage_count'))
            ->join('room_type_services', 'services.id', '=', 'room_type_services.service_id')
            ->join('room_types', 'room_type_services.room_type_id', '=', 'room_types.id')
            ->join('rooms', 'rooms.room_type_id', '=', 'room_types.id')
            ->join('bookings', 'bookings.room_id', '=', 'rooms.id')
            ->whereIn('bookings.status', ['finished', 'confirmed'])
            ->groupBy('services.name')
            ->orderByDesc('usage_count')
            ->limit(10)
            ->get();

        return view('reports.index', compact('totalRevenue', 'popularServices'));
    }
}
