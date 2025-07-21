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
    public $reviewsPerPage = 4; // Number of reviews to show initially
    public $currentReviewsCount = 4; // Current number of reviews being shown
    public $showPhotoOverlay = false; // Photo overlay visibility
    public $overlayPhotos = []; // Photos to show in overlay
    public $currentPhotoIndex = 0; // Current photo index in overlay

    public function mount($id = null)
    {
        // For now, use ID 1 as default or passed ID
        $this->vendorId = $id ?? 1;
        
        $this->vendor = Vendor::withFullDetails()
            ->with(['vendorSubscriptions.subscription', 'photos'])
            ->find($this->vendorId);

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
        $this->currentReviewsCount = $this->reviewsPerPage; // Reset to initial count when filter changes
        $this->filterReviews();
    }

    public function loadMoreReviews()
    {
        $this->currentReviewsCount += $this->reviewsPerPage;
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
                return $review->rating == $rating;
            });
        } elseif ($this->reviewFilter === 'with_media') {
            $this->filteredReviews = $reviews->filter(function($review) {
                return $review->photos && $review->photos->count() > 0;
            });
        }
    }

    public function getPaginatedReviews()
    {
        if (!$this->filteredReviews) {
            return collect([]);
        }
        
        // Sort reviews: (1) with images first, (2) with text/snippet, (3) by date
        $sortedReviews = $this->filteredReviews->sort(function($a, $b) {
            // Priority 1: Reviews with images
            $aHasImages = $a->photos && $a->photos->count() > 0;
            $bHasImages = $b->photos && $b->photos->count() > 0;
            
            if ($aHasImages && !$bHasImages) {
                return -1; // a comes first
            } elseif (!$aHasImages && $bHasImages) {
                return 1; // b comes first
            }
            
            // Priority 2: Reviews with text/snippet
            $aHasText = !empty(trim($a->review ?? ''));
            $bHasText = !empty(trim($b->review ?? ''));
            
            if ($aHasText && !$bHasText) {
                return -1; // a comes first
            } elseif (!$aHasText && $bHasText) {
                return 1; // b comes first
            }
            
            // Priority 3: By date (most recent first)
            $aDate = $a->created_at ?? now();
            $bDate = $b->created_at ?? now();
            
            return $bDate <=> $aDate;
        });
        
        return $sortedReviews->take($this->currentReviewsCount);
    }

    public function hasMoreReviews()
    {
        if (!$this->filteredReviews) {
            return false;
        }
        
        return $this->filteredReviews->count() > $this->currentReviewsCount;
    }

    // Photo overlay methods
    public function openPhotoOverlay($photos, $startIndex = 0)
    {
        $this->overlayPhotos = is_array($photos) ? $photos : $photos->toArray();
        $this->currentPhotoIndex = $startIndex;
        $this->showPhotoOverlay = true;
    }

    public function closePhotoOverlay()
    {
        $this->showPhotoOverlay = false;
        $this->overlayPhotos = [];
        $this->currentPhotoIndex = 0;
    }

    public function nextPhoto()
    {
        if ($this->currentPhotoIndex < count($this->overlayPhotos) - 1) {
            $this->currentPhotoIndex++;
        }
    }

    public function prevPhoto()
    {
        if ($this->currentPhotoIndex > 0) {
            $this->currentPhotoIndex--;
        }
    }

    public function getUserInitials($name)
    {
        if (!$name || $name === 'Anonymous') {
            return 'A';
        }
        
        $words = explode(' ', trim($name));
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        
        return strtoupper(substr($name, 0, 2));
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

        // Use exact rating match instead of floor
        return $this->vendor->reviews->filter(function($review) use ($rating) {
            return $review->rating == (int) $rating;
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

    public function hasHairstylists()
    {
        return $this->vendor && $this->vendor->hairstylists && $this->vendor->hairstylists->count() > 0;
    }

    public function render()
    {
        return view('livewire.product-detail')->layout('layouts.app');
    }
}
