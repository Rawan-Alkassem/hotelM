<?php

namespace Database\Seeders\Hamza;

use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run()
    {
        // التواريخ المستهدفة (أغسطس 2025)
        $startOfMonth = Carbon::create(2025, 8, 1);
        $endOfMonth = Carbon::create(2025, 8, 31);
        $daysInMonth = $startOfMonth->daysInMonth;

        // 1. حجز الغرفة رقم 1 لمدة 25-30 يومًا
        $this->seedRoom1($startOfMonth, $endOfMonth, $daysInMonth);

        // 2. إنشاء حجوزات عشوائية للغرف الأخرى بدون تعارض
        $this->seedOtherRooms($startOfMonth, $endOfMonth);
    }

    protected function seedRoom1($startOfMonth, $endOfMonth, $daysInMonth)
    {
        // تحديد مدة الحجز بين 25-30 يومًا
        $bookingDays = rand(25, 30);
        $checkIn = $startOfMonth->copy()->addDays(rand(0, $daysInMonth - $bookingDays));
        $checkOut = $checkIn->copy()->addDays($bookingDays);

        // تعديل إذا تجاوز نهاية الشهر
        if ($checkOut->greaterThan($endOfMonth)) {
            $checkOut = $endOfMonth;
            $checkIn = $checkOut->copy()->subDays($bookingDays);
        }

        Booking::create([
            'user_id' => 4,
            'receptionist_id' => 3,
            'room_id' => 1,
            'status' => 'confirmed',
            'check_in_date' => $checkIn,
            'check_out_date' => $checkOut,
            'total_price' => $bookingDays * 180,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    protected function seedOtherRooms($startOfMonth, $endOfMonth)
    {
        $rooms = Room::where('id', '!=', 1)->get();
        $statuses = ['pending', 'confirmed', 'cancelled', 'finished'];

        foreach ($rooms as $room) {
            // عدد الحجوزات العشوائية لكل غرفة (بين 1 إلى 3)
            $bookingsCount = rand(1, 3);
            $occupiedDays = [];

            for ($i = 0; $i < $bookingsCount; $i++) {
                $maxAttempts = 10;
                $attempt = 0;
                $created = false;

                while (!$created && $attempt < $maxAttempts) {
                    $attempt++;
                    
                    // توليد مدة الحجز (1-7 أيام)
                    $duration = rand(1, 7);
                    $checkIn = $startOfMonth->copy()->addDays(rand(0, 30 - $duration));
                    $checkOut = $checkIn->copy()->addDays($duration);

                    // تعديل إذا تجاوز نهاية الشهر
                    if ($checkOut->greaterThan($endOfMonth)) {
                        $checkOut = $endOfMonth;
                        $checkIn = $checkOut->copy()->subDays($duration);
                    }

                    // التحقق من عدم التعارض مع حجوزات سابقة لهذه الغرفة
                    $conflict = false;
                    foreach ($occupiedDays as $range) {
                        if ($checkIn->between($range['start'], $range['end']) || 
                            $checkOut->between($range['start'], $range['end']) ||
                            ($checkIn->lte($range['start']) && $checkOut->gte($range['end']))) {
                            $conflict = true;
                            break;
                        }
                    }

                    if (!$conflict) {
                        Booking::create([
                            'user_id' => 4,
                            'receptionist_id' => 3,
                            'room_id' => $room->id,
                            'status' => $statuses[array_rand($statuses)],
                            'check_in_date' => $checkIn,
                            'check_out_date' => $checkOut,
                            'total_price' => $duration * 180,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        $occupiedDays[] = [
                            'start' => $checkIn,
                            'end' => $checkOut
                        ];
                        $created = true;
                    }
                }
            }
        }
    }
}