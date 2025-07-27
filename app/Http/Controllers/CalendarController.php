<?php

namespace App\Http\Controllers;

use App\Services\CalendarService;
use Carbon\Carbon;

class CalendarController extends Controller
{
    protected $calendarService;

    public function __construct(CalendarService $calendarService)
    {
        $this->calendarService = $calendarService;
    }

    public function show($year = null, $month = null)
    {
        $calendarData = $this->calendarService->generateCalendarData($year, $month);
        return view('calendar', $calendarData);
    }
     public function report()
    {
        return view('report');
    }
}