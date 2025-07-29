<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Booking;
use Carbon\Carbon;

class CheckBookingDates
{
  public function handle(Request $request, Closure $next)
{
    $checkIn = Carbon::parse($request->check_in_date);
    $checkOut = Carbon::parse($request->check_out_date);
    $roomId = $request->room_id;

    $overlappingBookings = Booking::where('room_id', $roomId)
        ->where(function ($query) use ($checkIn, $checkOut) {
            $query->where(function ($q) use ($checkIn, $checkOut) {
                $q->where('check_in_date', '<=', $checkIn)
                  ->where('check_out_date', '>=', $checkOut);
            })->orWhere(function ($q) use ($checkIn, $checkOut) {
                $q->where('check_in_date', '<', $checkOut)
                  ->where('check_out_date', '>', $checkIn);
            });
        })
        ->get();

    if ($overlappingBookings->isNotEmpty()) {
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'The room is booked during this period.')
            ->with('overlapping', $overlappingBookings->map(function ($booking) {
                return [
                    'id' => $booking->id,
                    'check_in_date' => $booking->check_in_date,
                    'check_out_date' => $booking->check_out_date,
                    'status' => $booking->status
                ];
            })->toArray());
    }

    return $next($request);
}
}