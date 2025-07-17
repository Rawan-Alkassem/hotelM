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
        $admin = User::create([
            'full_name' => 'Admin1',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('Admin');

        $hotelManager = User::create([
            'full_name' => 'Hotel Manager1',
            'email' => 'hotelmanager@example.com',
            'password' => Hash::make('password'),
        ]);

        $hotelManager->assignRole('Hotel Manager');

    }
}
