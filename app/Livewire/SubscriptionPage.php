<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Subscription;
use App\Models\VendorSubscription;
use App\Models\Vendor;
use Carbon\Carbon;

class SubscriptionPage extends Component
{
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
        if (!$this->selectedPlan) {
            $this->dispatch('show-notification', [
                'type' => 'error',
                'message' => 'Pilih paket terlebih dahulu.'
            ]);
            return;
        }

        $this->isProcessing = true;

        try {
            $vendor = Vendor::where('user_id', auth()->id())->first();
            
            if (!$vendor) {
                $this->dispatch('show-notification', [
                    'type' => 'error',
                    'message' => 'Vendor tidak ditemukan.'
                ]);
                $this->isProcessing = false;
                return;
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
                $existingSubscription->update([
                    'subscription_id' => $subscription->id,
                    'end_date' => $endDate->format('Y-m-d')
                ]);
            } else {
                // Create new subscription
                VendorSubscription::create([
                    'vendor_id' => $vendor->id,
                    'subscription_id' => $subscription->id,
                    'start_date' => $startDate->format('Y-m-d'),
                    'end_date' => $endDate->format('Y-m-d')
                ]);
            }

            $this->dispatch('show-notification', [
                'type' => 'success',
                'message' => 'Langganan berhasil! Terima kasih telah berlangganan.'
            ]);

            $this->loadCurrentSubscription();
            $this->closeModal();

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
