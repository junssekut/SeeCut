<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorSubscription;
use App\Models\Subscription;

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
        try {
            // Prepare all data for the dashboard
            $this->getSummaryData();
            $this->getChartData();
            $this->getVendorActivities();
            $this->getSubscriptionPlans();
            $this->getRecentSubscriptions();
        } catch (\Exception $e) {
            // Fallback to safe default values
            $this->totalSubscriptions = 0;
            $this->totalRevenue = 0;
            $this->totalUsers = 0;
            $this->chartData = [
                'months' => [],
                'revenues' => []
            ];
            $this->subscriptionPlans = [];
            $this->recentSubscriptions = [];
            $this->vendorActivities = [];
        }
    }

    private function getSummaryData()
    {
        try {
            // Calculate total subscriptions from VendorSubscription table
            $this->totalSubscriptions = VendorSubscription::count();
            
            // Calculate total revenue from actual subscription prices
            $this->totalRevenue = VendorSubscription::with('subscription')
                ->get()
                ->sum(function($vendorSubscription) {
                    return $vendorSubscription->subscription->price ?? 0;
                });
            
            // Calculate total users (customers only, exclude vendors and admins)
            $this->totalUsers = User::whereHas('profile', function($query) {
                $query->where('role', 'customer');
            })->count();
        } catch (\Exception $e) {
            // Fallback values if database error
            $this->totalSubscriptions = 0;
            $this->totalRevenue = 0;
            $this->totalUsers = 0;
        }
    }

    private function getChartData()
    {
        try {
            // Get actual monthly revenue from VendorSubscription
            $months = [];
            $revenues = [];
            
            for ($i = 5; $i >= 0; $i--) {
                $month = now()->subMonths($i);
                $startOfMonth = $month->startOfMonth()->toDateString();
                $endOfMonth = $month->endOfMonth()->toDateString();
                
                // Calculate revenue for subscriptions active in this month
                $monthlyRevenue = VendorSubscription::with('subscription')
                    ->where(function($query) use ($startOfMonth, $endOfMonth) {
                        $query->where('start_date', '<=', $endOfMonth)
                              ->where('end_date', '>=', $startOfMonth);
                    })
                    ->get()
                    ->sum(function($vendorSubscription) {
                        return $vendorSubscription->subscription->price ?? 0;
                    });
                
                $months[] = $month->format('M Y');
                $revenues[] = max(0, round($monthlyRevenue / 1000000, 1)); // Convert to millions, ensure non-negative
            }
            
            $this->chartData = [
                'months' => $months,
                'revenues' => $revenues
            ];
        } catch (\Exception $e) {
            // Fallback to safe default values
            $this->chartData = [
                'months' => ['Jan 2025', 'Feb 2025', 'Mar 2025', 'Apr 2025', 'May 2025', 'Jun 2025'],
                'revenues' => [0, 0, 0, 0, 0, 0]
            ];
        }
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
        // Get actual recent subscriptions from VendorSubscription
        $recentSubscriptions = VendorSubscription::with(['vendor', 'subscription'])
            ->orderBy('start_date', 'desc')
            ->take(6)
            ->get();

        $this->recentSubscriptions = [];
        
        foreach ($recentSubscriptions as $subscription) {
            // Calculate how long ago the subscription started
            $startDate = \Carbon\Carbon::parse($subscription->start_date);
            $timeAgo = $startDate->diffForHumans();
            
            $this->recentSubscriptions[] = [
                'id' => $subscription->vendor->id,
                'name' => $subscription->vendor->name ?? 'Unknown Vendor',
                'plan' => $subscription->subscription->name ?? 'Unknown Plan',
                'time' => $timeAgo,
                'avatar' => 'https://ui-avatars.cc/api/?name=' . urlencode($subscription->vendor->name ?? 'UV') . '&background=10b981&color=ffffff&size=40&rounded=true'
            ];
        }
        
        // If no recent subscriptions, show empty state
        if (empty($this->recentSubscriptions)) {
            $this->recentSubscriptions = [];
        }
    }

    private function getSubscriptionPlans()
    {
        // Get actual subscription plan distribution from database
        $planCounts = VendorSubscription::with('subscription')
            ->get()
            ->groupBy('subscription.name')
            ->map(function ($group) {
                return [
                    'count' => $group->count(),
                    'price' => $group->first()->subscription->price ?? 0
                ];
            });

        $totalSubscriptions = $this->totalSubscriptions;
        
        if ($totalSubscriptions == 0) {
            $this->subscriptionPlans = [];
            return;
        }

        $this->subscriptionPlans = [];
        $colors = ['#4a90e2', '#50e3c2', '#bd10e0', '#f5a623', '#d0021b'];
        $colorIndex = 0;

        foreach ($planCounts as $planName => $data) {
            $percentage = $totalSubscriptions > 0 ? round(($data['count'] / $totalSubscriptions) * 100, 1) : 0;
            
            $this->subscriptionPlans[] = [
                'name' => $planName,
                'count' => $data['count'],
                'percentage' => $percentage,
                'price' => $data['price'],
                'color' => $colors[$colorIndex % count($colors)]
            ];
            $colorIndex++;
        }
    }

    public function render()
    {
        return view('livewire.admin-home')->layout('layouts.admin');
    }
}
