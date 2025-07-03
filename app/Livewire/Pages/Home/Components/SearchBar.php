<?php

namespace App\Livewire\Pages\Home\Components;

use Livewire\Component;

class SearchBar extends Component
{
    public string $lokasi = '';
    public string $layanan = '';
    public int $harga = 0; // Default price

    public array $lokasiOptions = [];
    public array $layananOptions = [];

    public int $maxHarga = 1000000; // Default max price, adjust as needed

    public function mount()
    {
        // Sample data for dropdowns.
        // In a real application, you'd fetch this from a database or config.
        $this->lokasiOptions = [
            '' => 'Pilih Lokasi', // Placeholder
            'jakarta_pusat' => 'Jakarta Pusat',
            'jakarta_selatan' => 'Jakarta Selatan',
            'jakarta_barat' => 'Jakarta Barat',
            'jakarta_timur' => 'Jakarta Timur',
            'jakarta_utara' => 'Jakarta Utara',
            'bandung' => 'Bandung',
            'surabaya' => 'Surabaya',
        ];

        $this->layananOptions = [
            '' => 'Pilih Layanan', // Placeholder
            'potong_rambut' => 'Potong Rambut',
            'creambath' => 'Creambath',
            'shaving' => 'Shaving',
            'hair_spa' => 'Hair Spa',
            'coloring' => 'Coloring',
        ];

        // You can set a default max price based on your application's needs
        // For example, fetch the highest price of a service.
        // For now, we'll keep it as defined or allow it to be passed.
    }

    public function search()
    {
        // This is where you would implement your search logic.
        // For example, emitting an event with the filter values
        // or querying a model.

        // For demonstration, we'll just log the data or you can emit an event.
        // Log::info('Search initiated with:', ['lokasi' => $this->lokasi, 'layanan' => $this->layanan, 'harga' => $this->harga]);

        $this->dispatch('searchPerformed', [
            'lokasi' => $this->lokasi,
            'layanan' => $this->layanan,
            'harga' => $this->harga,
        ]);

        // You might want to redirect or update another part of the page.
        // For example, if you have a results component listening for 'searchPerformed'.
    }
    
    public function render()
    {
        return view('livewire.pages.home.components.search-bar');
    }
}
