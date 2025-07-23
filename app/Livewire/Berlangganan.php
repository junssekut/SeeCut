<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\VendorSubscription;

class Berlangganan extends Component
{
    public $search = '';
    public $subscriptions = [];
    public $selectedVendor = null;
    public $showModal = false;
    
    protected $layout = 'layouts.admin';

    public function mount()
    {
        $this->filterSubscriptions();
    }

    public function updatedSearch()
    {
        $this->filterSubscriptions();
    }

    public function filterSubscriptions()
    {
        try {
            // Use a more efficient query with fewer joins
            $query = VendorSubscription::with(['vendor' => function($q) {
                $q->select('id', 'user_id', 'name', 'address', 'phone', 'thumbnail_url', 'description', 'rating', 'reviews_count');
            }, 'vendor.user' => function($q) {
                $q->select('id', 'email');
            }, 'subscription' => function($q) {
                $q->select('id', 'name', 'price');
            }]);
            
            if (!empty($this->search)) {
                $searchTerm = '%' . strtolower($this->search) . '%';
                $query->where(function($q) use ($searchTerm) {
                    $q->whereHas('vendor', function($vendorQuery) use ($searchTerm) {
                        $vendorQuery->whereRaw('LOWER(name) LIKE ?', [$searchTerm])
                                   ->orWhereRaw('LOWER(address) LIKE ?', [$searchTerm])
                                   ->orWhereRaw('LOWER(phone) LIKE ?', [$searchTerm]);
                    })
                    ->orWhereHas('vendor.user', function($userQuery) use ($searchTerm) {
                        $userQuery->whereRaw('LOWER(email) LIKE ?', [$searchTerm]);
                    })
                    ->orWhereHas('subscription', function($subscriptionQuery) use ($searchTerm) {
                        $subscriptionQuery->whereRaw('LOWER(name) LIKE ?', [$searchTerm]);
                    });
                });
            }

            $vendorSubscriptions = $query->get();

            $this->subscriptions = $vendorSubscriptions->map(function($vendorSubscription) {
                $isActive = $vendorSubscription->end_date >= now();
                return [
                    'id' => $vendorSubscription->id,
                    'vendor_id' => $vendorSubscription->vendor->id,
                    'logo' => $vendorSubscription->vendor->thumbnail_url ?? asset('assets/ld/logo-text.png'),
                    'name' => $vendorSubscription->vendor->name,
                    'email' => $vendorSubscription->vendor->user->email,
                    'alamat' => $vendorSubscription->vendor->address,
                    'phone' => $vendorSubscription->vendor->phone ?? '-',
                    'jam' => '09:00 - 21:00 WIB',
                    'paket' => $vendorSubscription->subscription->name,
                    'price' => number_format((float)$vendorSubscription->subscription->price, 0, ',', '.'),
                    'start_date' => $vendorSubscription->start_date,
                    'end_date' => $vendorSubscription->end_date,
                    'status' => $isActive ? 'active' : 'expired',
                    'is_active' => $isActive,
                ];
            })->toArray();

        } catch (\Exception $e) {
            \Log::error('Error in filterSubscriptions: ' . $e->getMessage());
            $this->subscriptions = [];
        }
    }

    public function deleteSubscription($id)
    {
        try {
            $subscription = VendorSubscription::find($id);
            
            if (!$subscription) {
                session()->flash('error', 'Langganan tidak ditemukan!');
                return;
            }

            $vendorName = $subscription->vendor->name ?? 'Vendor';
            $subscription->delete();

            // Refresh data setelah hapus
            $this->filterSubscriptions();

            session()->flash('message', "Langganan {$vendorName} berhasil dihapus!");
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat menghapus langganan: ' . $e->getMessage());
        }
    }

    public function showVendorDetails($vendorId)
    {
        try {
            // Load vendor subscription data
            $vendorSubscription = VendorSubscription::with(['vendor.user', 'subscription'])
                ->where('vendor_id', $vendorId)
                ->first();

            if ($vendorSubscription && $vendorSubscription->vendor) {
                $vendor = $vendorSubscription->vendor;
                
                $this->selectedVendor = [
                    'id' => $vendor->id,
                    'name' => $vendor->name ?? 'N/A',
                    'email' => $vendor->user ? $vendor->user->email : 'N/A',
                    'phone' => $vendor->phone ?? 'N/A',
                    'address' => $vendor->address ?? 'N/A',
                    'description' => $vendor->description ?? 'Tidak ada deskripsi',
                    'thumbnail_url' => $vendor->thumbnail_url ?? 'https://via.placeholder.com/80x80',
                    'rating' => $vendor->rating ?? 4.5,
                    'reviews_count' => $vendor->reviews_count ?? 0,
                    'subscription' => [
                        'plan' => $vendorSubscription->subscription->name ?? 'N/A',
                        'price' => $vendorSubscription->subscription->price ?? 0,
                        'status' => 'active',
                        'start_date' => $vendorSubscription->start_date ? \Carbon\Carbon::parse($vendorSubscription->start_date)->format('d M Y') : 'N/A',
                        'end_date' => $vendorSubscription->end_date ? \Carbon\Carbon::parse($vendorSubscription->end_date)->format('d M Y') : 'N/A',
                    ]
                ];
                
                $this->showModal = true;
            } else {
                session()->flash('error', 'Vendor tidak ditemukan');
            }
        } catch (\Exception $e) {
            // For debugging, let's see what the error is
            session()->flash('error', 'Error: ' . $e->getMessage());
            
            // If there's an error, use the data from the table as fallback
            $subscription = collect($this->subscriptions)->where('vendor_id', $vendorId)->first();
            if ($subscription) {
                $this->selectedVendor = [
                    'id' => $subscription['vendor_id'],
                    'name' => $subscription['name'],
                    'email' => $subscription['email'] ?? 'N/A',
                    'phone' => 'N/A',
                    'address' => $subscription['alamat'],
                    'description' => 'Tidak ada deskripsi',
                    'thumbnail_url' => $subscription['logo_url'],
                    'rating' => 4.5,
                    'reviews_count' => 0,
                    'subscription' => [
                        'plan' => $subscription['paket'],
                        'price' => str_replace('.', '', $subscription['price']),
                        'status' => $subscription['status'],
                        'start_date' => \Carbon\Carbon::parse($subscription['start_date'])->format('d M Y'),
                        'end_date' => \Carbon\Carbon::parse($subscription['end_date'])->format('d M Y'),
                    ]
                ];
                $this->showModal = true;
            }
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedVendor = null;
    }

    public function render()
    {
        return view('livewire.berlangganan')->layout('layouts.admin');
    }
}
