<?php

namespace Database\Seeders\Hamza;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run()
    {
        // حذف الحجوزات القديمة
        // Booking::truncate();

        // التواريخ المتاحة (أغسطس 2025 فقط)
        $startOfMonth = Carbon::create(2025, 8, 1);
        $endOfMonth = Carbon::create(2025, 8, 31);

        // إنشاء 10 حجوزات عشوائية
        for ($i = 1; $i <= 10; $i++) {
            // توليد تاريخ دخول عشوائي في أغسطس 2025
            $checkIn = $startOfMonth->copy()->addDays(rand(0, 27));
            
            // توليد تاريخ خروج (1-7 أيام بعد تاريخ الدخول)
            $checkOut = $checkIn->copy()->addDays(rand(1, 7));
            
            // إذا تجاوز تاريخ الخروج نهاية الشهر، نضبطه ليكون آخر يوم في أغسطس
            if ($checkOut->greaterThan($endOfMonth)) {
                $checkOut = $endOfMonth;
            }
            
            // حساب عدد الأيام والمبلغ الإجمالي
            $days = $checkIn->diffInDays($checkOut);
            $totalPrice = $days * 180;
            
            // حالات الحجز العشوائية
$statuses = ['pending', 'confirmed', 'cancelled', 'completed'];
            $randomStatus = $statuses[array_rand($statuses)];
            
            // إنشاء الحجز
            Booking::create([
                'user_id' => 3,
                'room_id' => 1,
                'status' => $randomStatus,
                'check_in_date' => $checkIn,
                'check_out_date' => $checkOut,
                'total_price' => $totalPrice,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}