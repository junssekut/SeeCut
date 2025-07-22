<?php

namespace App\Livewire;

use App\Models\Vendor;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        // Get top vendors based on rating and reviews count, then randomize and take 3
        $topVendors = Vendor::select('id', 'name', 'address', 'rating', 'reviews_count', 'thumbnail_url')
            ->where('rating', '>=', 4.0) // Minimum rating of 4.0
            ->where('reviews_count', '>', 0) // Must have reviews
            ->orderByRaw('(rating * 0.7 + (reviews_count / 100) * 0.3) DESC') // Weighted score
            ->limit(10) // Get top 10
            ->get()
            ->shuffle() // Randomize the top 10
            ->take(3); // Take only 3

        return view('livewire.home', compact('topVendors'))
            ->layout('layouts.app');
    }

    public function viewVendor($vendorId)
    {
        return redirect()->route('barbershop.view', $vendorId);
    }
}
