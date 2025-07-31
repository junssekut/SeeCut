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
        $this->call([
            UserSeeder::class,
            VendorSeeder::class,
            ReservationSeeder::class,
            SubscriptionSeeder::class,
            VendorSubscriptionSeeder::class,
            VendorServiceSeeder::class,
            VendorActivitySeeder::class,
        ]);
    }
}
