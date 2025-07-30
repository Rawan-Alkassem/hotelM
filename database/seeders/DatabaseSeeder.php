<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call(RoleSeeder::class);//false merge hamza
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

      $this->call([
RoleSeeder::class,//edit merge hamza to be true like this
 RolesAndPermissionsSeeder::class,
     UsersTableSeeder::class,
        \Database\Seeders\Hamza\RoomTypeSeeder::class,
      \Database\Seeders\Hamza\ServiceSeeder::class,
               \Database\Seeders\Hamza\RoomTypeServiceSeeder::class,
 \Database\Seeders\Hamza\RoomSeeder::class,
  \Database\Seeders\Hamza\BookingSeeder::class,
            ]);
    }
}
