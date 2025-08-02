<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'user_management',
            'role_management',
            'hotel_management',
            'booking_management',
            'reception_operations',
            'customer_operations'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles and assign permissions
        $admin = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $admin->givePermissionTo([
            'user_management',
            'role_management',
            'hotel_management',
            'booking_management'
        ]);

        $hotelManager = Role::firstOrCreate(['name' => 'Hotel Manager', 'guard_name' => 'web']);
        $hotelManager->givePermissionTo([
            'hotel_management',
            'booking_management'
        ]);

        $receptionist = Role::firstOrCreate(['name' => 'Receptionist', 'guard_name' => 'web']);
        $receptionist->givePermissionTo([
            'reception_operations',
            'booking_management'
        ]);

        $customer = Role::firstOrCreate(['name' => 'Customer', 'guard_name' => 'web']);
        $customer->givePermissionTo([
            'customer_operations'
        ]);
    }
}
