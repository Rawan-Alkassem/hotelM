<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // إنشاء الأدوار
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $receptionistRole = Role::firstOrCreate(['name' => 'Receptionist']);
        $hotelManagerRole = Role::firstOrCreate(['name' => 'Hotel Manager']);

        // تعيين الدور Admin للمستخدم الأول (ID = 1)
        $admin = User::find(1);
        if ($admin && !$admin->hasRole('Admin')) {
            $admin->assignRole($adminRole);
        }

        // تعيين الدور Receptionist للمستخدم الثاني (ID = 2)
        $receptionist = User::find(2);
        if ($receptionist && !$receptionist->hasRole('Receptionist')) {
            $receptionist->assignRole($receptionistRole);
        }

        // تعيين الدور Hotel Manager للمستخدم الثالث (ID = 3)
        $hotelManager = User::find(3);
        if ($hotelManager && !$hotelManager->hasRole('Hotel Manager')) {
            $hotelManager->assignRole($hotelManagerRole);
        }
    }
}
