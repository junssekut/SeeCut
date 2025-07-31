<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Subscription;
use App\Models\VendorSubscription;
use App\Models\Vendor;
use App\Traits\LogsVendorActivity;
use Carbon\Carbon;

class SubscriptionPage extends Component
{
    use LogsVendorActivity;
    public $plans = [];
    public $selectedPlan = null;
    public $showPaymentModal = false;
    public $currentSubscription = null;
    public $isProcessing = false;
    public $showVendorWarning = false;

    public function mount()
    {
        // Check if user is a vendor
        if (auth()->check()) {
            $user = auth()->user();
            $vendor = Vendor::where('user_id', $user->id)->first();
            
            if ($vendor) {
                $this->showVendorWarning = true;
                return;
            }
        }
        
        $this->loadPlans();
        $this->loadCurrentSubscription();
    }

    public function loadPlans()
    {
        $subscriptions = Subscription::all();
        
        $this->plans = $subscriptions->map(function($subscription) {
            return [
                'id' => $subscription->id,
                'name' => $subscription->name,
                'price' => $subscription->price,
                'duration_days' => $subscription->duration_days,
                'formatted_price' => number_format($subscription->price / 1000, 0) . 'K',
                'duration_text' => $this->getDurationText($subscription->duration_days),
                'features' => [
                    'Fitur Booking Otomatis',
                    'Halaman Profil Digital'
                ]
            ];
        })->toArray();
    }

    public function loadCurrentSubscription()
    {
        if (auth()->check()) {
            $vendor = Vendor::where('user_id', auth()->id())->first();
            if ($vendor) {
                $this->currentSubscription = VendorSubscription::with('subscription')
                    ->where('vendor_id', $vendor->id)
                    ->where('end_date', '>=', Carbon::now()->format('Y-m-d'))
                    ->first();
            }
        }
    }

    public function selectPlan($planId)
    {
        if (!auth()->check()) {
            $this->dispatch('redirect-to-login');
            return;
        }

        $this->selectedPlan = collect($this->plans)->firstWhere('id', $planId);
        $this->showPaymentModal = true;
    }

    public function closeModal()
    {
        $this->showPaymentModal = false;
        $this->selectedPlan = null;
        $this->isProcessing = false;
    }

    public function confirmSubscription()
    {
        if (!auth()->check()) {
            $this->dispatch('redirect-to-login');
            return;
        }

        if (!$this->selectedPlan) {
            $this->dispatch('show-notification', [
                'type' => 'error',
                'message' => 'Pilih paket terlebih dahulu.'
            ]);
            return;
        }

        $this->isProcessing = true;

        try {
            // First check if user is already a vendor
            $vendor = Vendor::where('user_id', auth()->id())->first();
            
            if (!$vendor) {
                // Create new vendor for the user
                $user = auth()->user();
                $profile = $user->profile;
                $vendorName = trim(($profile->first_name ?? '') . ' ' . ($profile->last_name ?? ''));
                
                // Fallback to username if no name in profile
                if (empty($vendorName)) {
                    $vendorName = $user->username ?? 'Vendor Baru';
                }
                
                $vendor = Vendor::create([
                    'user_id' => auth()->id(),
                    'name' => $vendorName,
                    'address' => '',
                    'description' => '',
                    'phone' => '',
                    'rating' => 0.0,
                    'reviews_count' => 0,
                    'thumbnail_url' => '',
                    'latitude' => -6.2088, // Default Jakarta coordinates
                    'longitude' => 106.8456,
                    'place_id' => 'generated_' . time()
                ]);

                // Update user profile role to vendor
                $profile->update(['role' => 'vendor']);
            }

            $subscription = Subscription::find($this->selectedPlan['id']);
            
            if (!$subscription) {
                $this->dispatch('show-notification', [
                    'type' => 'error',
                    'message' => 'Paket tidak ditemukan.'
                ]);
                $this->isProcessing = false;
                return;
            }

            // Check for existing subscription
            $existingSubscription = VendorSubscription::where('vendor_id', $vendor->id)
                ->where('end_date', '>=', Carbon::now()->format('Y-m-d'))
                ->first();

            $startDate = Carbon::now();
            $endDate = $startDate->copy()->addDays($subscription->duration_days);

            if ($existingSubscription) {
                // Extend existing subscription
                $oldEndDate = $existingSubscription->end_date;
                $existingSubscription->update([
                    'subscription_id' => $subscription->id,
                    'end_date' => $endDate->format('Y-m-d')
                ]);
                
                // Log subscription extension activity
                $this->logVendorActivity(
                    self::ACTIVITY_UPDATE,
                    "Memperpanjang langganan paket '{$subscription->name}' hingga {$endDate->format('d M Y')}",
                    'subscription',
                    $existingSubscription->id,
                    [
                        'subscription_name' => $subscription->name,
                        'old_end_date' => $oldEndDate,
                        'new_end_date' => $endDate->format('Y-m-d'),
                        'duration_days' => $subscription->duration_days,
                        'price' => $subscription->price,
                        'action' => 'extend'
                    ],
                    $vendor->user_id
                );
            } else {
                // Create new subscription
                $newSubscription = VendorSubscription::create([
                    'vendor_id' => $vendor->id,
                    'subscription_id' => $subscription->id,
                    'start_date' => $startDate->format('Y-m-d'),
                    'end_date' => $endDate->format('Y-m-d')
                ]);
                
                // Log new subscription activity
                $this->logVendorActivity(
                    self::ACTIVITY_CREATE,
                    "Berlangganan paket '{$subscription->name}' mulai {$startDate->format('d M Y')} hingga {$endDate->format('d M Y')}",
                    'subscription',
                    $newSubscription->id,
                    [
                        'subscription_name' => $subscription->name,
                        'start_date' => $startDate->format('Y-m-d'),
                        'end_date' => $endDate->format('Y-m-d'),
                        'duration_days' => $subscription->duration_days,
                        'price' => $subscription->price,
                        'action' => 'subscribe'
                    ],
                    $vendor->user_id
                );
            }

            $this->dispatch('show-notification', [
                'type' => 'success',
                'message' => 'Selamat! Langganan berhasil aktif. Akun Anda telah diupgrade menjadi vendor.'
            ]);

            $this->loadCurrentSubscription();
            $this->closeModal();

            // Small delay then redirect to vendor profile to complete setup
            $this->dispatch('redirect-to-vendor-dashboard');

        } catch (\Exception $e) {
            $this->dispatch('show-notification', [
                'type' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }

        $this->isProcessing = false;
    }

    private function getDurationText($days)
    {
        if ($days <= 90) return '3 Bulan';
        if ($days <= 183) return '6 Bulan';
        return '12 Bulan';
    }

    public function render()
    {
        return view('livewire.subscription-page')->layout('layouts.app');
    }
}
