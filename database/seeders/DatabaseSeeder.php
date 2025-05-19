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
        \App\Models\User::factory(10)->create()->each(function ($user) {
            \App\Models\Subscription::factory()->create(['user_id' => $user->user_id]);
        });

        \App\Models\Vendor::factory(5)->create()->each(function ($vendor) {
            \App\Models\Reservation::factory(3)->create([
                'vendor_id' => $vendor->vendor_id,
                'user_id' => \App\Models\User::inRandomOrder()->first()->user_id
            ]);
        });
    }
}
