<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Vendor;

class AdminHome extends Component
{
    public $totalSubscriptions;
    public $totalRevenue;
    public $totalUsers;
    public $monthlyRevenue;
    public $vendorActivities;
    public $subscriptionPlans;
    public $chartData;
    public $recentSubscriptions;

    protected $listeners = ['refreshChartData'];

    protected $layout = 'layouts.admin';

    public function mount()
    {
        $this->prepareData();
    }

    public function refreshChartData()
    {
        $this->prepareData();
    }

    private function prepareData()
    {
        // Prepare all data for the dashboard
        $this->getSummaryData();
        $this->getChartData();
        $this->getVendorActivities();
        $this->getSubscriptionPlans();
        $this->getRecentSubscriptions();
    }

    private function getSummaryData()
    {
        // Calculate total subscriptions (vendors)
        $this->totalSubscriptions = Vendor::count();
        
        // Calculate total revenue (assuming each subscription has a monthly fee)
        $subscriptionFee = 150000; // IDR per month per subscription
        $this->totalRevenue = $this->totalSubscriptions * $subscriptionFee;
        
        // Calculate total users
        $this->totalUsers = User::count();
    }

    private function getChartData()
    {
        // Since vendors table doesn't have timestamps, create mock monthly data
        $months = [];
        $revenues = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            // Simulate growth pattern - more subscriptions over time
            $baseSubscriptions = max(1, $this->totalSubscriptions - ($i * 2));
            $subscriptionsInMonth = min($baseSubscriptions, $this->totalSubscriptions);
            
            $months[] = $month->format('M Y');
            $revenues[] = round(($subscriptionsInMonth * 150000) / 1000000, 1); // Convert to millions
        }
        
        $this->chartData = [
            'months' => $months,
            'revenues' => $revenues
        ];
    }

    private function getVendorActivities()
    {
        // Generate mock vendor activities based on actual vendors
        $vendors = Vendor::take(10)->get();
        
        // If no vendors exist, create some sample data
        if ($vendors->isEmpty()) {
            $vendors = collect([
                (object)['id' => 1, 'name' => 'Barbershop Garut 1'],
                (object)['id' => 2, 'name' => 'Jack&john\'s Barbershop 3 Sentul City'],
                (object)['id' => 3, 'name' => 'Cukurbe Barbershop Sentul'],
                (object)['id' => 4, 'name' => 'Uppertouch Barbershop Sentul'],
                (object)['id' => 5, 'name' => '180 Barbershop']
            ]);
        }
        
        $activities = [
            'Memperbarui profil barbershop',
            'Menambahkan foto baru',
            'Mengatur jam operasional',
            'Memperbarui layanan',
            'Melakukan reservasi',
            'Membalas review pelanggan',
            'Upload foto hasil potong',
            'Update harga layanan',
            'Menambah slot waktu baru',
            'Konfirmasi reservasi'
        ];
        
        $this->vendorActivities = [];
        
        foreach ($vendors as $index => $vendor) {
            $randomActivity = $activities[array_rand($activities)];
            $timeOptions = [
                '2 menit yang lalu',
                '15 menit yang lalu',
                '1 jam yang lalu',
                '3 jam yang lalu',
                '1 hari yang lalu',
                '2 hari yang lalu'
            ];
            
            $this->vendorActivities[] = [
                'id' => $vendor->id,
                'name' => $vendor->name,
                'activity' => $randomActivity,
                'time' => $timeOptions[array_rand($timeOptions)],
                'avatar' => 'https://ui-avatars.cc/api/?name=' . urlencode($vendor->name) . '&background=4f46e5&color=ffffff&size=56&rounded=true',
                'type' => ['update', 'create', 'confirm', 'upload'][array_rand(['update', 'create', 'confirm', 'upload'])]
            ];
        }
    }

    private function getRecentSubscriptions()
    {
        // Generate mock recent subscriptions based on actual vendors
        $vendors = Vendor::take(6)->get();
        
        // If no vendors exist, create some sample data
        if ($vendors->isEmpty()) {
            $vendors = collect([
                (object)['id' => 1, 'name' => 'Uppertouch Barbershop Sentul'],
                (object)['id' => 2, 'name' => 'Barbershop Garut 1'],
                (object)['id' => 3, 'name' => '180 Barbershop'],
                (object)['id' => 4, 'name' => 'Cukurbe Barbershop Sentul'],
                (object)['id' => 5, 'name' => 'Jack&john\'s Barbershop 3 Sentul City'],
                (object)['id' => 6, 'name' => 'Modern Cuts Barbershop']
            ]);
        }
        
        $plans = ['Basic', 'Standard', 'Pro'];
        $timeOptions = [
            '5 menit yang lalu',
            '30 menit yang lalu',
            '1 jam yang lalu',
            '2 jam yang lalu',
            '5 jam yang lalu',
            '1 hari yang lalu'
        ];
        
        $this->recentSubscriptions = [];
        
        foreach ($vendors as $index => $vendor) {
            $this->recentSubscriptions[] = [
                'id' => $vendor->id,
                'name' => $vendor->name,
                'plan' => $plans[array_rand($plans)],
                'time' => $timeOptions[array_rand($timeOptions)],
                'avatar' => 'https://ui-avatars.cc/api/?name=' . urlencode($vendor->name) . '&background=10b981&color=ffffff&size=40&rounded=true'
            ];
        }
        
        // Sort by most recent first
        usort($this->recentSubscriptions, function($a, $b) {
            $timeValues = [
                '5 menit yang lalu' => 5,
                '30 menit yang lalu' => 30,
                '1 jam yang lalu' => 60,
                '2 jam yang lalu' => 120,
                '5 jam yang lalu' => 300,
                '1 hari yang lalu' => 1440
            ];
            return ($timeValues[$a['time']] ?? 0) - ($timeValues[$b['time']] ?? 0);
        });
    }

    private function getSubscriptionPlans()
    {
        // Simulate subscription plan distribution based on vendor count
        $totalVendors = $this->totalSubscriptions;
        
        if ($totalVendors == 0) {
            $this->subscriptionPlans = [
                ['name' => 'Basic', 'count' => 0, 'percentage' => 0, 'price' => 99000, 'color' => '#4a90e2'],
                ['name' => 'Standard', 'count' => 0, 'percentage' => 0, 'price' => 199000, 'color' => '#50e3c2'],
                ['name' => 'Pro', 'count' => 0, 'percentage' => 0, 'price' => 299000, 'color' => '#bd10e0']
            ];
            return;
        }
        
        // Calculate distribution (Basic: 52%, Standard: 28%, Pro: 20%)
        $basicCount = (int)($totalVendors * 0.52);
        $standardCount = (int)($totalVendors * 0.28);
        $proCount = $totalVendors - $basicCount - $standardCount;
        
        $this->subscriptionPlans = [
            [
                'name' => 'Basic',
                'count' => $basicCount,
                'percentage' => round(($basicCount / $totalVendors) * 100, 1),
                'price' => 99000,
                'color' => '#4a90e2'
            ],
            [
                'name' => 'Standard',
                'count' => $standardCount,
                'percentage' => round(($standardCount / $totalVendors) * 100, 1),
                'price' => 199000,
                'color' => '#50e3c2'
            ],
            [
                'name' => 'Pro',
                'count' => $proCount,
                'percentage' => round(($proCount / $totalVendors) * 100, 1),
                'price' => 299000,
                'color' => '#bd10e0'
            ]
        ];
    }

    public function render()
    {
        return view('livewire.admin-home')->layout('layouts.admin');
    }
}
