<?php

namespace Database\Seeders\Hamza;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\RoomType;
use Illuminate\Support\Facades\DB;

class RoomTypeServiceSeeder extends Seeder
{
    public function run()
    {
        // حذف البيانات القديمة أولاً لتجنب التكرار
        DB::table('room_type_service')->truncate();

        // الحصول على جميع أنواع الغرف
        $roomTypes = [
            'Standard Single Room' => ['Single bed', 'TV'],
            'Standard Double Room' => ['Double bed', 'TV', 'Breakfast'],
            'VIP Single Room' => ['VIP bed', 'TV', 'Arcade', 'Breakfast', 'Lunch'],
            'VIP Double Room' => ['VIP bed', 'TV', 'Arcade', 'Summer pool', 'Winter pool', 'Breakfast', 'Lunch', 'Dinner']
        ];

        // ربط الخدمات بالغرف
        foreach ($roomTypes as $roomTypeName => $services) {
            $roomType = RoomType::where('name', $roomTypeName)->first();

            if ($roomType) {
                $serviceIds = Service::whereIn('name', $services)->pluck('id')->toArray();

                foreach ($serviceIds as $serviceId) {
                    DB::table('room_type_service')->insert([
                        'room_type_id' => $roomType->id,
                        'service_id' => $serviceId,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }

        $this->command->info('Room Type Services table seeded successfully with new services!');
    }
}
