<?php

namespace App\Livewire\Components;

use Livewire\Component;
use App\Models\VendorService;
use App\Models\Vendor;

class SearchBar extends Component
{
    public string $lokasi = '';
    public string $layanan = '';
    public int $harga = 0; // Default price
    public bool $isLoading = false; // Loading state

    public array $lokasiOptions = [];
    public array $layananOptions = [];

    public int $maxHarga = 1000000; // Default max price, adjust as needed

    public function mount()
    {
        // Location options - filter by Bogor and Kabupaten Bogor only
        $this->lokasiOptions = [
            '' => 'Pilih Lokasi', // Placeholder
            'bogor' => 'Bogor',
            'kabupaten_bogor' => 'Kabupaten Bogor',
        ];

        // Get all available services from database
        $this->layananOptions = ['' => 'Pilih Layanan']; // Start with placeholder
        
        $services = VendorService::select('service_name')
            ->distinct()
            ->orderBy('service_name')
            ->get();
            
        foreach ($services as $service) {
            $this->layananOptions[strtolower(str_replace(' ', '_', $service->service_name))] = $service->service_name;
        }

        // Set max price based on highest service price in database
        $maxPrice = VendorService::max('price');
        $this->maxHarga = $maxPrice ? (int) $maxPrice : 1000000;
    }

    public function search()
    {
        // Start loading
        $this->isLoading = true;
        
        // Small delay to show loading state (optional)
        usleep(300000); // 0.3 seconds
        
        // Redirect to barbershop listing page with search parameters
        return redirect()->route('barbershop.index', [
            'lokasi' => $this->lokasi,
            'layanan' => $this->layanan,
            'harga' => $this->harga,
        ]);
    }
    
    public function render()
    {
        return view('livewire.components.search-bar');
    }
}
