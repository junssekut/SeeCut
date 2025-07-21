<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $thumbnail_url
 * @property int $reviews_count
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\VendorPhoto[] $photos
 */
class Vendor extends Model
{
    /** @use HasFactory<\Database\Factories\VendorFactory> */
    use HasFactory;

    protected $table = 'vendors';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'user_id', 'name', 'address', 'description', 'phone', 
        'rating', 'reviews_count', 'thumbnail_url', 'latitude', 
        'longitude', 'place_id'
    ];

    protected $casts = [
        'rating' => 'float',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    // Custom accessor for photos
    public function getPhotosAttribute() {
        $photos = collect();
        
        // Add thumbnail if exists
        if ($this->thumbnail_url) {
            $photos->push((object) [
                'id' => 'thumbnail',
                'url' => $this->thumbnail_url, // Direct external URL
                'type' => 'thumbnail'
            ]);
        }
        
        // Add hairstylist photos if hairstylists are loaded
        if ($this->relationLoaded('hairstylists')) {
            $this->hairstylists->each(function($hairstylist) use ($photos) {
                if ($hairstylist->vendorPhoto) {
                    $photos->push([
                        'id' => $hairstylist->vendorPhoto->id,
                        'url' => $hairstylist->vendorPhoto->source, // Direct external URL
                        'type' => 'hairstylist'
                    ]);
                }
            });
        }
        
        // Add vendor photos from photos relationship
        if ($this->relationLoaded('photos')) {
            $this->getRelation('photos')->each(function($photo) use ($photos) {
                $photos->push([
                    'id' => $photo->id,
                    'url' => $photo->source,
                    'type' => 'gallery'
                ]);
            });
        }
        
        return $photos->unique('id');
    }

    public function openHours() {
        return $this->hasMany(VendorOpenHour::class);
    }

    public function reviews() {
        return $this->hasMany(VendorReview::class);
    }

    public function services() {
        return $this->hasMany(VendorService::class);
    }

    public function hairstylists() {
        return $this->hasMany(VendorHairstylist::class);
    }

    public function photos() {
        return $this->hasMany(VendorPhoto::class);
    }

    public function vendorSubscriptions() {
        return $this->hasMany(VendorSubscription::class);
    }

    // Computed Properties
    public function getFormattedRatingAttribute()
    {
        return number_format($this->rating, 1);
    }

    public function getFormattedReviewsCountAttribute()
    {
        if ($this->reviews_count >= 1000) {
            return number_format($this->reviews_count / 1000, 1) . 'RB';
        }
        return $this->reviews_count;
    }

    public function getMainImageAttribute()
    {
        if ($this->thumbnail_url) {
            // Since all images are now stored as external URLs, return the source directly
            return $this->thumbnail_url;
        }
        // Try to get first hairstylist photo as fallback
        $firstHairstylist = $this->hairstylists()->with('vendorPhoto')->first();
        if ($firstHairstylist && $firstHairstylist->vendorPhoto) {
            return $firstHairstylist->vendorPhoto->source;
        }
        return asset('assets/images/DashboardBarbershop.png');
    }

    // Scopes
    public function scopeWithFullDetails($query)
    {
        return $query->with([
            'photos',
            'openHours',
            'reviews' => function($query) {
                $query->orderBy('rating', 'desc')->orderBy('id', 'desc');
            },
            'reviews.photos', // Add this to load review photos
            'services',
            'hairstylists.vendorPhoto'
        ]);
    }

    public function scopeRated($query)
    {
        return $query->where('rating', '>', 0);
    }

    public function scopeHighRated($query)
    {
        return $query->where('rating', '>=', 4.0);
    }

    // Helper methods
    public function hasActiveSubscription()
    {
        return $this->vendorSubscriptions()
            ->where('end_date', '>=', now())
            ->exists();
    }

    public function getActiveSubscription()
    {
        return $this->vendorSubscriptions()
            ->with('subscription')
            ->where('end_date', '>=', now())
            ->latest('end_date')
            ->first();
    }

    public function getOperatingHours($day)
    {
        $openHour = $this->openHours->firstWhere('day', $day);
        
        if (!$openHour || !$openHour->open_time || !$openHour->close_time) {
            return '10.00–21.00'; // Default hours
        }

        return date('H.i', strtotime($openHour->open_time)) . '–' . date('H.i', strtotime($openHour->close_time));
    }

    public function isOpenNow()
    {
        $currentDay = date('l'); // Get current day name
        $currentTime = date('H:i:s');
        
        $todayHours = $this->openHours->firstWhere('day', $currentDay);
        
        if (!$todayHours || !$todayHours->open_time || !$todayHours->close_time) {
            return false;
        }

        return $currentTime >= $todayHours->open_time && $currentTime <= $todayHours->close_time;
    }

    public function getStarRatingArray()
    {
        $rating = $this->rating;
        $fullStars = floor($rating);
        $hasHalfStar = $rating - $fullStars >= 0.5;
        $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);

        return [
            'full' => $fullStars,
            'half' => $hasHalfStar ? 1 : 0,
            'empty' => $emptyStars,
            'rating' => $rating
        ];
    }
}
