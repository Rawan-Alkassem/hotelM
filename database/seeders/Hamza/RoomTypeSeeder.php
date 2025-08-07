<?php

namespace Database\Seeders\Hamza;
use App\Models\RoomType;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $roomTypes = [

            [
                'name' => 'Standard Single Room',
                'description' => 'Single room with twin bed and standard view',
                'price' => 100,

            ],
             [
                'name' => 'Standard Suite',
                'description' => 'Double room with queen bed and standard view',
                'price' => 200,

            ],

            [
                'name' => 'VIP Single Room',
                'description' => 'Luxury single room with queen bed and premium view',
                'price' => 300,

            ],
             [
                'name' => 'VIP Suite',
                'description' => 'Luxury double room with king bed and premium view',
                'price' => 400,

            ],
        ];

        foreach ($roomTypes as $roomType) {
            RoomType::create($roomType);
        }
    }
}
