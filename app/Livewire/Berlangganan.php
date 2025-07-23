<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\VendorSubscription;

class Berlangganan extends Component
{
    public $search = '';
    public $subscriptions = [];
    
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
                $q->select('id', 'user_id', 'name', 'address', 'phone');
            }, 'vendor.user' => function($q) {
                $q->select('id', 'email');
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
                    ->orWhereRaw('LOWER(plan) LIKE ?', [$searchTerm]);
                });
            }

            $vendorSubscriptions = $query->get();

            $this->subscriptions = $vendorSubscriptions->map(function($subscription) {
                return [
                    'id' => $subscription->id,
                    'vendor_id' => $subscription->vendor->id,
                    'logo' => asset('assets/ld/logo-text.png'),
                    'name' => $subscription->vendor->name,
                    'email' => $subscription->vendor->user->email,
                    'alamat' => $subscription->vendor->address,
                    'phone' => $subscription->vendor->phone ?? '-',
                    'jam' => '09:00 - 21:00 WIB',
                    'paket' => $subscription->plan,
                    'price' => number_format((float)$subscription->price, 0, ',', '.'),
                    'start_date' => $subscription->start_date,
                    'end_date' => $subscription->end_date,
                    'status' => $subscription->status,
                    'is_active' => $subscription->status === 'active',
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

            $vendorName = $subscription->vendor->name;
            $subscription->delete();

            // Refresh data setelah hapus
            $this->filterSubscriptions();

            session()->flash('message', "Langganan {$vendorName} berhasil dihapus!");
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan saat menghapus langganan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.berlangganan');
    }
}
