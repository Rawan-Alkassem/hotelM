<?php

namespace Database\Seeders\Hamza;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class RoomSeeder extends Seeder
{
    public function run()
    {
           // تعطيل فحص المفاتيح الأجنبية مؤقتًا
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // حذف جميع السجلات وإعادة تعيين العداد التلقائي
        DB::table('rooms')->truncate();
        
        // تمكين فحص المفاتيح الأجنبية مرة أخرى
        DB::statement('SET FOREIGN_KEY_CHECKS=1;'); 
        // حذف الغرف القديمة أولاً
        Room::query()->delete();

        // إنشاء غرف Standard Single (النوع 1)
        for ($i = 1; $i <10; $i++) {
            Room::create([
                'room_number' => $i . 'SR',
                'room_type_id' => 1,
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // إنشاء غرف Standard Double (النوع 2)
        for ($i = 1; $i < 10; $i++) {
            Room::create([
                'room_number' => $i . 'DR',
                'room_type_id' => 2,
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // إنشاء غرف VIP Single (النوع 3)
        for ($i = 1; $i < 10; $i++) {
            Room::create([
                'room_number' => $i . 'VIPSR',
                'room_type_id' => 3,
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // إنشاء غرف VIP Double (النوع 4)
        for ($i = 1; $i < 10; $i++) {
            Room::create([
                'room_number' => $i . 'VIPDR',
                'room_type_id' => 4,
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // إضافة بعض التواريخ للحجز (اختياري)
        // $this->createSampleBookings();
    }

    // protected function createSampleBookings()
    // {
    //     // غرفة 1SR محجوزة من 2023-06-01 إلى 2023-06-05
    //     $room = Room::where('room_number', '1SR')->first();
    //     $room->bookings()->create([
    //         'check_in' => Carbon::create(2023, 6, 1),
    //         'check_out' => Carbon::create(2023, 6, 5),
    //         'status' => 'confirmed'
    //     ]);
    //     $room->update(['status' => 'booked']);

    //     // غرفة 2DR محجوزة من 2023-06-10 إلى 2023-06-15
    //     $room = Room::where('room_number', '2DR')->first();
    //     $room->bookings()->create([
    //         'check_in' => Carbon::create(2023, 6, 10),
    //         'check_out' => Carbon::create(2023, 6, 15),
    //         'status' => 'confirmed'
    //     ]);
    //     $room->update(['status' => 'booked']);

    //     // يمكنك إضافة المزيد من الأمثلة هنا
    // }
}
