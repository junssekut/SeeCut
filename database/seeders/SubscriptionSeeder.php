<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subscription;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subscriptions = [
            ['name' => 'Basic Plan', 'price' => 99000, 'duration_days' => 90],
            ['name' => 'Standard Plan', 'price' => 179000, 'duration_days' => 181],
            ['name' => 'Pro Plan', 'price' => 299000, 'duration_days' => 365],
        ];

        foreach ($subscriptions as $subscription) {
            Subscription::updateOrCreate(
                ['name' => $subscription['name']],
                $subscription
            );
        }
    }
}
