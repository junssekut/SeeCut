<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\ReservationSlot;
use App\Models\Vendor;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Create or get a vendor
        $vendor = Vendor::first() ?? Vendor::factory()->create();
        // Create or get a user
        $user = User::first() ?? User::factory()->create();

        $this->command->info($vendor);
        $this->command->info($user);
    
        // Create slots for the vendor
        $slots = [];
        for ($i = 0; $i < 5; $i++) {
            $slots[] = ReservationSlot::create([
                'vendor_id' => $vendor->id,
                'date' => now()->addDays($i)->toDateString(),
                'start_time' => '09:00:00',
                'end_time' => '10:00:00',
            ]);
        }

        // Create reservations for the slots
        foreach ($slots as $i => $slot) {
            Reservation::create([
                'user_id' => $user->id,
                'vendor_id' => $vendor->id,
                'reservation_id' => $slot->id,
                'name' => $user->name == '' ? $faker->name() : '',
                'email' => $faker->unique()->safeEmail,
                'phone' => $faker->phoneNumber,
                'status' => ['pending', 'confirmed', 'cancelled', 'finished'][rand(0,2)],
                'note' => 'Sample reservation #' . ($i+1),
            ]);
        }
    }
} 