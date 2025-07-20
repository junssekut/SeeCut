<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Vendor;

class ProductDetail extends Component
{
    public $vendor;
    public $vendorId;
    public $reviewFilter = 'all'; // New property for review filtering
    public $filteredReviews = []; // New property for filtered reviews

    public function mount($id = null)
    {
        // For now, use ID 1 as default or passed ID
        $this->vendorId = $id ?? 1;
        
        $this->vendor = Vendor::withFullDetails()->find($this->vendorId);

        // Initialize filtered reviews
        $this->filterReviews();
    }

    public function getAverageRating()
    {
        return $this->vendor->rating ?? 4.9;
    }

    public function getTotalReviews()
    {
        return $this->vendor->reviews_count ?? 0;
    }

    public function getFormattedReviewsCount()
    {
        $count = $this->getTotalReviews();
        if ($count >= 1000) {
            return number_format($count / 1000, 1) . 'RB';
        }
        return $count;
    }

    public function getStarRating()
    {
        $rating = $this->getAverageRating();
        return [
            'full' => floor($rating),
            'half' => $rating - floor($rating) >= 0.5 ? 1 : 0,
            'empty' => 5 - floor($rating) - ($rating - floor($rating) >= 0.5 ? 1 : 0),
            'rating' => $rating
        ];
    }

    public function getOperatingHours($day)
    {
        if (method_exists($this->vendor, 'getOperatingHours')) {
            return $this->vendor->getOperatingHours($day);
        }

        // Fallback for default vendor
        $openHour = $this->vendor->openHours->firstWhere('day', $day);
        
        if (!$openHour || !isset($openHour->open_time) || !isset($openHour->close_time)) {
            return '10.00–21.00';
        }

        return date('H.i', strtotime($openHour->open_time)) . '–' . date('H.i', strtotime($openHour->close_time));
    }

    // New methods for enhanced functionality
    public function setReviewFilter($filter)
    {
        $this->reviewFilter = $filter;
        $this->filterReviews();
    }

    public function filterReviews()
    {
        if (!$this->vendor || !isset($this->vendor->reviews)) {
            return;
        }

        $reviews = $this->vendor->reviews;
        
        if ($this->reviewFilter === 'all') {
            $this->filteredReviews = $reviews;
        } elseif (is_numeric($this->reviewFilter)) {
            $rating = (int) $this->reviewFilter;
            $this->filteredReviews = $reviews->filter(function($review) use ($rating) {
                return floor($review->rating) === $rating;
            });
        } elseif ($this->reviewFilter === 'with_media') {
            $this->filteredReviews = $reviews->filter(function($review) {
                return $review->photos && $review->photos->count() > 0;
            });
        }
    }

    public function getReviewCountByRating($rating)
    {
        if (!$this->vendor || !isset($this->vendor->reviews)) {
            return 0;
        }

        if ($rating === 'with_media') {
            return $this->vendor->reviews->filter(function($review) {
                return $review->photos && $review->photos->count() > 0;
            })->count();
        }

        return $this->vendor->reviews->filter(function($review) use ($rating) {
            return floor($review->rating) === (int) $rating;
        })->count();
    }

    public function formatPrice($price)
    {
        if ($price >= 1000000) {
            return number_format($price / 1000000, 1) . 'JT';
        } elseif ($price >= 1000) {
            return number_format($price / 1000, 0) . 'K';
        }
        return number_format($price, 0);
    }

    public function getServiceDuration($price)
    {
        // Estimate duration based on price
        if ($price >= 100000) {
            return '±60 menit';
        } elseif ($price >= 60000) {
            return '±45 menit';
        } elseif ($price >= 45000) {
            return '±30 menit';
        } else {
            return '±25 menit';
        }
    }

    public function render()
    {
        return view('livewire.product-detail')->layout('layouts.app');
    }
}
