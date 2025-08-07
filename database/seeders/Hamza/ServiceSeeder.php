<?php

namespace Database\Seeders\Hamza;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\RoomType;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            [
                'name' => 'Single bed',
                'description' => 'Comfortable single bed'
            ],
            [
                'name' => 'Double bed',
                'description' => 'Spacious double bed'
            ],
            [
                'name' => 'VIP bed',
                'description' => 'Luxury VIP bed with premium mattress'
            ],
            [
                'name' => 'TV',
                'description' => 'Flat-screen TV with cable channels'
            ],
            [
                'name' => 'Arcade',
                'description' => 'Video game console with popular games'
            ],
            [
                'name' => 'Summer pool',
                'description' => 'Access to outdoor swimming pool'
            ],
            [
                'name' => 'Winter pool',
                'description' => 'Access to indoor heated swimming pool'
            ],
            [
                'name' => 'Breakfast',
                'description' => 'Complimentary morning breakfast'
            ],
            [
                'name' => 'Lunch',
                'description' => 'Optional lunch service'
            ],
            [
                'name' => 'Dinner',
                'description' => 'Optional dinner service'
            ],
        ];

        // حذف الخدمات القديمة أولاً
        Service::query()->delete();

        foreach ($services as $service) {
            Service::create($service);
        }

        // ربط الخدمات بأنواع الغرف
        $this->assignServicesToRoomTypes();
    }

    protected function assignServicesToRoomTypes()
    {
        // خدمات الغرف الفردية العادية
        $singleStandardServices = ['Single bed', 'TV'];

        // خدمات الغرف المزدوجة العادية
        $doubleStandardServices = ['Double bed', 'TV', 'Breakfast'];

        // خدمات الغرف الفردية VIP
        $singleVipServices = ['VIP bed', 'TV', 'Arcade', 'Breakfast', 'Lunch'];

        // خدمات الغرف المزدوجة VIP
        $doubleVipServices = ['VIP bed', 'TV', 'Arcade', 'Summer pool', 'Winter pool', 'Breakfast', 'Lunch', 'Dinner'];

        // ربط الخدمات بالغرف
        RoomType::where('name', 'Standard Single Room')->first()
            ->services()->sync(Service::whereIn('name', $singleStandardServices)->pluck('id'));

        RoomType::where('name', 'Standard Suite')->first()
            ->services()->sync(Service::whereIn('name', $doubleStandardServices)->pluck('id'));

        RoomType::where('name', 'VIP Single Room')->first()
            ->services()->sync(Service::whereIn('name', $singleVipServices)->pluck('id'));

        RoomType::where('name', 'VIP Suite')->first()
            ->services()->sync(Service::whereIn('name', $doubleVipServices)->pluck('id'));
    }
}
