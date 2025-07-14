<?php

namespace Database\Seeders;

use App\Models\VendorSubscription;
use App\Models\Subscription;
use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VendorSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Example: assign each vendor a random subscription
        $vendors = Vendor::all();
        $subscriptions = Subscription::all();

        foreach ($vendors as $vendor) {
            if (mt_rand(1, 100) > 30) continue;
            
            $subscription = $subscriptions->random();
            VendorSubscription::updateOrCreate(
                [
                    'vendor_id' => $vendor->id,
                ],
                [
                    'subscription_id' => $subscription->id,
                    'start_date' => now(),
                    'end_date' => now()->addDays($subscription->duration_days),
                ]
            );
        }
    }
}
