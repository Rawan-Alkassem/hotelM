<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // ✅ تعديل هنا: استخدام firstOrCreate لتفادي التكرار
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'full_name' => 'Admin1',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole('Admin');

        // ✅ تعديل هنا
        $hotelManager = User::firstOrCreate(
            ['email' => 'hotelmanager@example.com'],
            [
                'full_name' => 'Hotel Manager1',
                'password' => Hash::make('password'),
            ]
        );
        $hotelManager->assignRole('Hotel Manager');

        // ✅ تعديل هنا
        $receptionist = User::firstOrCreate(
            ['email' => 'Recep@example.com'],
            [
                'full_name' => 'Receptionist1',
                'password' => Hash::make('password'),
            ]
        );
        $receptionist->assignRole('Receptionist');

        // ✅ تعديل هنا
        $customer = User::firstOrCreate(
            ['email' => 'Customer@example.com'],
            [
                'full_name' => 'Customer1',
                'password' => Hash::make('password'),
            ]
        );
        $customer->assignRole('Customer');
    }
}
