<?php

namespace App\Livewire;

use App\Models\Vendor;
use App\Models\VendorService;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;

class BarbershopListing extends Component
{
    use WithPagination;

    public bool $showAll = false;

    // These will be read from URL parameters (set by SearchBar component)
    private string $lokasi = '';
    private string $layanan = '';
    private int $harga = 0;

    protected $queryString = [
        'showAll' => ['except' => false]
    ];

    public function mount()
    {
        // Get search parameters from URL (passed by SearchBar component)
        $this->lokasi = request('lokasi', '');
        $this->layanan = request('layanan', '');
        $this->harga = (int) request('harga', 0);
        $this->showAll = (bool) request('showAll', false);
    }

    public function showMore()
    {
        $this->showAll = true;
    }

    public function getBarbershops()
    {
        $query = Vendor::query()
            ->with([
                'vendorSubscriptions' => function($query) {
                    $query->where('end_date', '>=', now());
                },
                'services',
                'reviews'
            ])
            ->where('rating', '>', 0);

        // Apply filters
        if ($this->lokasi) {
            // Filter by Bogor locations
            if ($this->lokasi === 'bogor') {
                $query->where(function($q) {
                    $q->where('address', 'like', '%Kota Bogor%')
                      ->orWhere('address', 'like', '%Bogor City%');
                });
            } elseif ($this->lokasi === 'kabupaten_bogor') {
                $query->where(function($q) {
                    $q->where('address', 'like', '%Kabupaten Bogor%')
                      ->orWhere('address', 'like', '%Bogor Regency%');
                });
            }
        }

        if ($this->layanan) {
            $query->whereHas('services', function(Builder $q) {
                $serviceName = $this->getServiceName($this->layanan);
                $q->where('service_name', 'like', '%' . $serviceName . '%');
            });
        }

        if ($this->harga > 0) {
            $query->whereHas('services', function(Builder $q) {
                $q->where('price', '<=', $this->harga);
            });
        }

        // Order by subscription status first, then by rating
        $query->leftJoin('vendor_subscriptions', function($join) {
                $join->on('vendors.id', '=', 'vendor_subscriptions.vendor_id')
                     ->where('vendor_subscriptions.end_date', '>=', now());
            })
            ->orderBy('vendor_subscriptions.id', 'desc') // Subscribed first
            ->orderBy('rating', 'desc')
            ->select('vendors.*');

        return $query;
    }

    private function getLocationName($locationKey)
    {
        $locationMap = [
            'bogor' => 'Bogor',
            'kabupaten_bogor' => 'Kabupaten Bogor',
        ];

        return $locationMap[$locationKey] ?? '';
    }

    private function getServiceName($serviceKey)
    {
        // Convert service key back to readable name
        $serviceMap = [
            'haircut' => 'Haircut',
            'hair_wash' => 'Hair Wash',
            'shaving' => 'Shaving',
            'beard_trim' => 'Beard Trim',
            'hair_styling' => 'Hair Styling',
            'hair_coloring' => 'Hair Coloring',
            'creambath' => 'Creambath',
            'hair_spa' => 'Hair Spa',
            'eyebrow_trimming' => 'Eyebrow Trimming',
            'mustache_trim' => 'Mustache Trim'
        ];

        return $serviceMap[$serviceKey] ?? ucwords(str_replace('_', ' ', $serviceKey));
    }

    public function render()
    {
        // Always show all with pagination, maintaining subscription ordering
        $barbershops = $this->getBarbershops()->paginate(12);

        return view('livewire.barbershop-listing', [
            'barbershops' => $barbershops
        ])->layout('layouts.app');
    }
}
