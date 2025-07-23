<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SimpleVendorSubscriptionSeeder extends Seeder
{
    public function run()
    {
        // Insert users
        $users = [
            ['id' => 1, 'username' => 'captain_owner', 'email' => 'captain@gmail.com', 'password' => bcrypt('password'), 'email_verified_at' => now()],
            ['id' => 2, 'username' => 'barberking_owner', 'email' => 'barberking@gmail.com', 'password' => bcrypt('password'), 'email_verified_at' => now()],
            ['id' => 3, 'username' => 'royalcuts_owner', 'email' => 'royalcuts@gmail.com', 'password' => bcrypt('password'), 'email_verified_at' => now()],
        ];

        foreach ($users as $user) {
            DB::table('users')->insertOrIgnore($user);
        }

        // Insert vendors
        $vendors = [
            ['id' => 1, 'user_id' => 1, 'name' => 'Captain Barbershop', 'address' => 'JL Pahlawan No.189B', 'phone' => '08123456789', 'rating' => 4.8, 'reviews_count' => 125, 'latitude' => -6.595038, 'longitude' => 106.816635, 'place_id' => 'captain_barbershop'],
            ['id' => 2, 'user_id' => 2, 'name' => 'Barber King', 'address' => 'JL Merdeka No.10', 'phone' => '08123456790', 'rating' => 4.6, 'reviews_count' => 98, 'latitude' => -6.594150, 'longitude' => 106.815123, 'place_id' => 'barber_king'],
            ['id' => 3, 'user_id' => 3, 'name' => 'Royal Cuts', 'address' => 'JL Sudirman No.25', 'phone' => '08123456791', 'rating' => 4.7, 'reviews_count' => 87, 'latitude' => -6.596221, 'longitude' => 106.817445, 'place_id' => 'royal_cuts'],
        ];

        foreach ($vendors as $vendor) {
            DB::table('vendors')->insertOrIgnore($vendor);
        }

        // Insert vendor subscriptions
        $subscriptions = [
            ['id' => 1, 'vendor_id' => 1, 'plan' => 'PLATINUM', 'price' => 500000, 'start_date' => '2024-01-01', 'end_date' => '2025-01-01', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'vendor_id' => 2, 'plan' => 'GOLD', 'price' => 300000, 'start_date' => '2024-01-01', 'end_date' => '2025-01-01', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'vendor_id' => 3, 'plan' => 'SILVER', 'price' => 200000, 'start_date' => '2024-01-01', 'end_date' => '2025-01-01', 'status' => 'active', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($subscriptions as $subscription) {
            DB::table('vendor_subscriptions')->insertOrIgnore($subscription);
        }

        echo "Data inserted successfully!\n";
    }
}
