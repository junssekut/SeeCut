<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Vendor;
use App\Models\VendorPhoto;
use App\Models\VendorOpenHour;
use App\Models\VendorReview;
use App\Models\VendorReviewPhoto;
use App\Models\User;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = base_path('backend/barbershops_enhanced_descriptions.json');
        $vendorsData = json_decode(file_get_contents($jsonPath), true);

        foreach ($vendorsData as $vendorData) {
            DB::beginTransaction();
            try {
                $this->command->info('Seeding vendor: ' . $vendorData['name']);

                // Create or get a user for this vendor
                $user = User::factory()->create([
                    'username' => 'vendor_' . \Str::slug($vendorData['name']) . '_' . uniqid(),
                    'email' => \Str::slug($vendorData['name']) . '+' . uniqid() . '@example.com',
                    'password' => bcrypt('password'), // Default password
                ]);

                $user->profile()->updateOrCreate([], [
                    'role' => 'vendor',
                ]);

                // Create Vendor with user_id
                $vendor = Vendor::create([
                    'user_id' => $user->id,
                    'name' => $vendorData['name'],
                    'address' => $vendorData['address'],
                    'phone' => $vendorData['phone'],
                    'rating' => $vendorData['rating'] ?? 0.0,
                    'reviews_count' => $vendorData['reviews_count'],
                    'latitude' => $vendorData['latitude'],
                    'longitude' => $vendorData['longitude'],
                    'place_id' => $vendorData['place_id'],
                    'description' => $vendorData['description'],
                    // thumbnail_id to be set later
                ]);
                $this->command->info('Created vendor: ' . $vendor->id);

                // 2. Create VendorPhoto records
                $photoIds = [];
                $thumbnailPhoto = null;
                
                // Use the first photo from all_photos_urls as thumbnail (better quality than main_thumbnail_url)
                if (!empty($vendorData['all_photos_urls'])) {
                    $thumbnailPhoto = VendorPhoto::create([
                        'type' => 'link',
                        'source' => $vendorData['all_photos_urls'][0], // Use first photo as thumbnail
                        'category' => 'general'
                    ]);
                    $photoIds[] = $thumbnailPhoto->id;
                    
                    // Create remaining photos (skip first one since we already used it as thumbnail)
                    foreach (array_slice($vendorData['all_photos_urls'], 1) as $photoUrl) {
                        $photo = VendorPhoto::create([
                            'type' => 'link',
                            'source' => $photoUrl,
                            'category' => 'general'
                        ]);
                        $photoIds[] = $photo->id;
                    }
                } else {
                    // Fallback: create a photo from main_thumbnail_url if all_photos_urls is empty
                    $thumbnailPhoto = VendorPhoto::create([
                        'type' => 'link',
                        'source' => $vendorData['main_thumbnail_url'],
                        'category' => 'general'
                    ]);
                    $photoIds[] = $thumbnailPhoto->id;
                }
                
                // Set thumbnail_id to the first/best quality photo
                $vendor->thumbnail_id = $thumbnailPhoto->id;
                $vendor->save();
                // $this->command->info('Created photos for vendor: ' . $vendor->id);

                // 3. Create VendorOpenHour records
                if (!empty($vendorData['open_hours'])) {
                    foreach ($vendorData['open_hours'] as $openHour) {
                        if (preg_match('/^(\w+):\s*(.+)$/', $openHour, $matches)) {
                            $day = $matches[1];
                            $times = $matches[2];
                            // $this->command->info('Parsing open hour times: "' . $times . '"');
                            $dashPos = preg_match('/\d+\s*[AP]M\s*(.)\s*\d+\s*[AP]M/', $times, $dashMatch) ? $dashMatch[1] : null;
                            if ($dashPos) {
                                // $this->command->info('Dash character code: ' . mb_ord($dashPos, 'UTF-8'));
                            }
                            if (preg_match('/(\d{1,2}(?::\d{2})?\s*[AP]M)\s*[\x{2013}\x{2014}\x{2012}\x{2010}-]\s*(\d{1,2}(?::\d{2})?\s*[AP]M)/u', $times, $timeMatches)) {
                                $open = date('H:i:s', strtotime($timeMatches[1]));
                                $close = date('H:i:s', strtotime($timeMatches[2]));
                            } else {
                                $open = null;
                                $close = null;
                            }
                            VendorOpenHour::create([
                                'vendor_id' => $vendor->id,
                                'day' => $day,
                                'open_time' => $open,
                                'close_time' => $close,
                            ]);
                        }
                    }
                } else {
                    // If open_hours is null or empty, create default open hours for all days
                    $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
                    foreach ($days as $day) {
                        VendorOpenHour::create([
                            'vendor_id' => $vendor->id,
                            'day' => $day,
                            'open_time' => '08:00:00',
                            'close_time' => '22:00:00',
                        ]);
                    }
                }
                // $this->command->info('Created open hours for vendor: ' . $vendor->id);

                // 4. Create VendorReview and VendorReviewPhoto records
                foreach ($vendorData['reviews_data'] as $reviewData) {
                    $review = VendorReview::create([
                        'vendor_id' => $vendor->id,
                        'user_name' => $reviewData['user_name'],
                        'contributor_id' => $reviewData['contributor_id'],
                        'rating' => $reviewData['rating'],
                        'link' => $reviewData['link'],
                        'snippet' => $reviewData['snippet'] ?? '',
                        'iso_date' => isset($reviewData['iso_date']) ? date('Y-m-d H:i:s', strtotime($reviewData['iso_date'])) : null,
                    ]);
                    foreach ($reviewData['review_images_urls'] as $reviewPhotoUrl) {
                        VendorReviewPhoto::create([
                            'review_id' => $review->id,
                            'type' => 'link',
                            'source' => $reviewPhotoUrl,
                        ]);
                    }
                }
                // $this->command->info('Created reviews for vendor: ' . $vendor->id);

                DB::commit();
                $this->command->info('Committed vendor: ' . $vendor->id);
            } catch (\Exception $e) {
                DB::rollBack();
                $this->command->error('Rolled back vendor: ' . ($vendorData['name'] ?? 'unknown') . ' - ' . $e->getMessage());
                throw $e;
            }
        }
    }
}
