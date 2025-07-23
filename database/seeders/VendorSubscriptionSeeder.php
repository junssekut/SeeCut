<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vendor;
use App\Models\VendorSubscription;

class VendorSubscriptionSeeder extends Seeder
{
    public function run()
    {
        // Get all vendors
        $vendors = Vendor::with('user')->get();
        
        if ($vendors->isEmpty()) {
            $this->command->error('No vendors found! Please run VendorSeeder first.');
            return;
        }

        $plans = ['BRONZE', 'SILVER', 'GOLD', 'PLATINUM'];
        $prices = [
            'BRONZE' => 100000,
            'SILVER' => 200000,
            'GOLD' => 300000,
            'PLATINUM' => 500000,
        ];

        // Create subscriptions for all vendors
        foreach ($vendors as $vendor) {
            // Random plan
            $plan = $plans[array_rand($plans)];
            
            VendorSubscription::create([
                'vendor_id' => $vendor->id,
                'plan' => $plan,
                'price' => $prices[$plan],
                'start_date' => now()->subDays(rand(30, 365)),
                'end_date' => now()->addDays(rand(30, 365)),
                'status' => 'active'
            ]);
        }

        $this->command->info('Created subscriptions for ' . $vendors->count() . ' vendors.');
    }
}
