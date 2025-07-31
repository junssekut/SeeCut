<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Subscription;
use App\Models\VendorSubscription;
use App\Models\Vendor;
use App\Traits\LogsVendorActivity;
use Carbon\Carbon;

class Extend extends Component
{
    use LogsVendorActivity;
    public $selectedPlan = 'standard';
    public $showPaymentOverlay = false;
    public $plans = [];
    public $subscriptions = [];
    public $isProcessing = false;
    public $currentSubscription = null;

    public function mount()
    {
        $this->subscriptions = Subscription::all();
        $this->buildPlans();
        $this->loadCurrentSubscription();
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

    public function buildPlans()
    {
        $this->plans = [];
        
        // Define features for each plan type
        $planFeatures = [
            'basic' => [
                'Fitur Booking Otomatis',
                'Halaman Profil Digital'
            ],
            'standard' => [
                'Fitur Booking Otomatis',
                'Halaman Profil Digital',
                'Analytics Dashboard'
            ],
            'pro' => [
                'Fitur Booking Otomatis',
                'Halaman Profil Digital',
                'Analytics Dashboard',
                'Priority Support'
            ]
        ];

        foreach ($this->subscriptions as $subscription) {
            $planType = $this->getPlanType($subscription->name);
            $this->plans[$planType] = [
                'id' => $subscription->id,
                'name' => strtoupper($subscription->name),
                'price' => $this->formatPrice($subscription->price),
                'duration' => $this->formatDuration($subscription->duration_days),
                'rawPrice' => $subscription->price,
                'features' => $planFeatures[$planType] ?? [
                    'Fitur Booking Otomatis',
                    'Halaman Profil Digital'
                ]
            ];
        }

        // Set default selected plan if exists
        if (empty($this->plans)) {
            $this->selectedPlan = 'standard';
        } else {
            $this->selectedPlan = array_key_first($this->plans);
        }
    }

    private function getPlanType($name)
    {
        $name = strtolower($name);
        if (str_contains($name, 'basic')) return 'basic';
        if (str_contains($name, 'standard')) return 'standard';
        if (str_contains($name, 'pro')) return 'pro';
        return 'standard';
    }

    private function formatPrice($price)
    {
        if ($price >= 1000000) {
            return number_format($price / 1000000, 1) . 'M';
        } elseif ($price >= 1000) {
            return number_format($price / 1000, 0) . 'K';
        }
        return number_format($price, 0);
    }

    private function formatDuration($days)
    {
        if ($days >= 365) {
            $years = intval($days / 365);
            return $years . ' ' . ($years == 1 ? 'Tahun' : 'Tahun');
        } elseif ($days >= 30) {
            $months = intval($days / 30);
            return $months . ' ' . ($months == 1 ? 'Bulan' : 'Bulan');
        } else {
            return $days . ' ' . ($days == 1 ? 'Hari' : 'Hari');
        }
    }

    public function selectPlan($plan)
    {
        $this->selectedPlan = $plan;
    }

    public function getSelectedPlanProperty()
    {
        if (isset($this->plans[$this->selectedPlan])) {
            return $this->plans[$this->selectedPlan];
        }
        
        // Return first available plan if selected plan doesn't exist
        if (!empty($this->plans)) {
            return array_values($this->plans)[0];
        }
        
        return null;
    }

    public function getSelectedPlanDataProperty()
    {
        return $this->getSelectedPlanProperty();
    }

    public function hasSelectedPlan()
    {
        return !empty($this->plans) && isset($this->plans[$this->selectedPlan]);
    }

    public function showPayment()
    {
        $this->showPaymentOverlay = true;
        $this->dispatch('payment-overlay-opened');
    }

    public function hidePayment()
    {
        $this->showPaymentOverlay = false;
        $this->dispatch('payment-overlay-closed');
    }

    public function getPaymentDeadlineProperty()
    {
        return Carbon::now()->addHours(2);
    }

    public function getFormattedPaymentTimeProperty()
    {
        return $this->paymentDeadline->format('H.i');
    }

    public function getFormattedPaymentDateProperty()
    {
        return $this->paymentDeadline->locale('id')->translatedFormat('l, d F Y');
    }

    public function confirmSubscription()
    {
        $this->isProcessing = true;

        // Check if user is authenticated and has a vendor
        if (!auth()->check()) {
            notyf()->error('Anda harus login terlebih dahulu');
            $this->isProcessing = false;
            return;
        }

        // Get the vendor associated with the authenticated user
        $vendor = Vendor::where('user_id', auth()->id())->first();
        
        if (!$vendor) {
            notyf()->error('Vendor tidak ditemukan');
            $this->isProcessing = false;
            return;
        }

        // Check if a plan is selected
        if (!$this->selectedPlan || !isset($this->plans[$this->selectedPlan])) {
            notyf()->error('Silakan pilih salah satu paket berlangganan yang tersedia sebelum melanjutkan pembayaran');
            $this->isProcessing = false;
            return;
        }

        $selectedPlanData = $this->plans[$this->selectedPlan];
        $subscription = Subscription::find($selectedPlanData['id']);

        if (!$subscription) {
            notyf()->error('Paket berlangganan tidak ditemukan');
            $this->isProcessing = false;
            return;
        }

        // Check if vendor already has an active subscription
        $existingSubscription = VendorSubscription::where('vendor_id', $vendor->id)
            ->where('end_date', '>=', Carbon::now()->format('Y-m-d'))
            ->first();

        // Calculate start and end dates
        $startDate = Carbon::now();
        $endDate = $startDate->copy()->addDays($subscription->duration_days);

        try {
            if ($existingSubscription) {
                // Update existing subscription instead of creating new one
                $oldSubscriptionId = $existingSubscription->subscription_id;
                $oldEndDate = $existingSubscription->end_date;
                
                $existingSubscription->update([
                    'subscription_id' => $subscription->id,
                    'start_date' => $startDate->format('Y-m-d'),
                    'end_date' => $endDate->format('Y-m-d'),
                ]);
                
                // Log subscription update/extension activity
                $this->logVendorActivity(
                    self::ACTIVITY_UPDATE,
                    "Memperbarui langganan ke paket '{$subscription->name}' hingga {$endDate->format('d M Y')}",
                    'subscription',
                    $existingSubscription->id,
                    [
                        'old_subscription_id' => $oldSubscriptionId,
                        'new_subscription_id' => $subscription->id,
                        'subscription_name' => $subscription->name,
                        'old_end_date' => $oldEndDate,
                        'new_start_date' => $startDate->format('Y-m-d'),
                        'new_end_date' => $endDate->format('Y-m-d'),
                        'duration_days' => $subscription->duration_days,
                        'price' => $subscription->price,
                        'action' => 'update_subscription'
                    ],
                    $vendor->user_id
                );
                
                $message = 'Berhasil memperbarui langganan ke paket ' . $subscription->name . '! Berlaku sampai ' . $endDate->format('d M Y');
            } else {
                // Create new vendor subscription
                $newSubscription = VendorSubscription::create([
                    'vendor_id' => $vendor->id,
                    'subscription_id' => $subscription->id,
                    'start_date' => $startDate->format('Y-m-d'),
                    'end_date' => $endDate->format('Y-m-d'),
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
                        'action' => 'new_subscription'
                    ],
                    $vendor->user_id
                );
                
                $message = 'Berhasil berlangganan paket ' . $subscription->name . '! Berlaku sampai ' . $endDate->format('d M Y');
            }

            // Hide the payment overlay
            $this->hidePayment();

            // Show success message with Notyf
            notyf()->success($message);
            
            // Reset processing state
            $this->isProcessing = false;
            
            // Optionally redirect or refresh
            return redirect()->route('vendor.extend');
            
        } catch (\Exception $e) {
            notyf()->error('Terjadi kesalahan saat memproses langganan: ' . $e->getMessage());
            $this->isProcessing = false;
        }
    }

    public function render()
    {
        return view('livewire.vendor-subscription-extend')->layout('layouts.vendor');
    }
}
