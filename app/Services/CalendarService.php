<?php

namespace App\Services;

use Carbon\Carbon;

class CalendarService
{
    public function generateCalendarData($year = null, $month = null)
    {
        $year = $year ?? now()->year;
        $month = $month ?? now()->month;

        $date = Carbon::create($year, $month, 1);
        $startOfMonth = $date->copy()->startOfMonth();
        $endOfMonth = $date->copy()->endOfMonth();

        // حساب الأيام من الشهر السابق لملء الأسبوع الأول
        $startOfCalendar = $startOfMonth->copy()->startOfWeek();
        
        // حساب الأيام من الشهر التالي لملء الأسبوع الأخير
        $endOfCalendar = $endOfMonth->copy()->endOfWeek();

        $weeks = [];
        $currentDay = $startOfCalendar->copy();

        while ($currentDay->lte($endOfCalendar)) {
            $week = [];
            for ($i = 0; $i < 7; $i++) {
                $week[] = [
                    'day' => $currentDay->day,
                    'month' => $currentDay->month,
                    'year' => $currentDay->year,
                    'isCurrentMonth' => $currentDay->month == $month,
                    'isToday' => $currentDay->isToday(),
                ];
                $currentDay->addDay();
            }
            $weeks[] = $week;
        }

        return [
            'month' => $month,
            'monthName' => $date->monthName,
            'year' => $year,
            'weeks' => $weeks,
            'previousMonth' => $startOfMonth->copy()->subMonth(),
            'nextMonth' => $startOfMonth->copy()->addMonth(),
        ];
    }
}