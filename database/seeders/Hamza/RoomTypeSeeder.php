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
                
            ],
             [
                'name' => 'Standard Double Room',
                'description' => 'Double room with queen bed and standard view',
              
            ],

            [
                'name' => 'VIP Single Room',
                'description' => 'Luxury single room with queen bed and premium view',
                
            ],
             [
                'name' => 'VIP Double Room',
                'description' => 'Luxury double room with king bed and premium view',
                
            ],
        ];

        foreach ($roomTypes as $roomType) {
            RoomType::create($roomType);
        }
    }
}
