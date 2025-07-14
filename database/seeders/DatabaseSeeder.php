<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $user = User::factory()->create([
            'username' => 'arjunaandio',
            'email' => 'arzunadio@gmail.com',
            'password' => bcrypt('anjing123'),
        ]);

        $user->profile()->updateOrCreate([], [
            'role' => 2,
        ]);

        $this->call([
            VendorSeeder::class,
            ReservationSeeder::class,
            SubscriptionSeeder::class,
            VendorSubscriptionSeeder::class
        ]);
    }
}
