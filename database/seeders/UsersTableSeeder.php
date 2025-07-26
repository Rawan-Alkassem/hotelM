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
        $admin = User::create(attributes: [
            'full_name' => 'Admin1',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('Admin');
//
        $hotelManager = User::create([
            'full_name' => 'Hotel Manager1',
            'email' => 'hotelmanager@example.com',
            'password' => Hash::make('password'),
        ]);
        $hotelManager->assignRole('Hotel Manager');
//
        $Receptionist = User::create([
            'full_name' => 'Receptionist1',
            'email' => 'Recep@example.com',
            'password' => Hash::make('password'),
        ]);
        $Receptionist->assignRole('Receptionist');

        //
        $Customer = User::create([
            'full_name' => 'Customer1',
            'email' => 'Customer@example.com',
            'password' => Hash::make('password'),
        ]);
        $Customer->assignRole('Customer');

    }
}
