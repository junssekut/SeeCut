<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Vendor;
use App\Models\VendorPhoto;
use App\Models\VendorOpenHour;
use App\Models\VendorReview;
use App\Models\VendorReviewPhoto;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jsonPath = base_path('backend/barbershops_data_with_image_links.json');
        $vendorsData = json_decode(file_get_contents($jsonPath), true);

        foreach ($vendorsData as $vendorData) {
            DB::beginTransaction();
            try {
                $this->command->info('Seeding vendor: ' . $vendorData['name']);
                // 1. Create Vendor (without thumbnail_id for now)
                $vendor = Vendor::create([
                    'name' => $vendorData['name'],
                    'address' => $vendorData['address'],
                    'phone' => $vendorData['phone'],
                    'rating' => isset($vendorData['rating']) && $vendorData['rating'] !== null ? $vendorData['rating'] : 0.0,
                    'reviews_count' => $vendorData['reviews_count'],
                    'latitude' => $vendorData['latitude'],
                    'longitude' => $vendorData['longitude'],
                    'place_id' => $vendorData['place_id'],
                    // thumbnail_id will be set later
                ]);
                $this->command->info('Created vendor: ' . $vendor->id);

                // 2. Create VendorPhoto records
                $photoIds = [];
                $mainPhoto = VendorPhoto::create([
                    'type' => 'link',
                    'source' => $vendorData['main_thumbnail_url'],
                ]);
                $photoIds[] = $mainPhoto->id;
                foreach ($vendorData['all_photos_urls'] as $photoUrl) {
                    $photo = VendorPhoto::create([
                        'type' => 'link',
                        'source' => $photoUrl,
                    ]);
                    $photoIds[] = $photo->id;
                }
                $vendor->thumbnail_id = $mainPhoto->id;
                $vendor->save();
                $this->command->info('Created photos for vendor: ' . $vendor->id);

                // 3. Create VendorOpenHour records
                if (!empty($vendorData['open_hours'])) {
                    foreach ($vendorData['open_hours'] as $openHour) {
                        if (preg_match('/^(\w+):\s*(.+)$/', $openHour, $matches)) {
                            $day = $matches[1];
                            $times = $matches[2];
                            $this->command->info('Parsing open hour times: "' . $times . '"');
                            $dashPos = preg_match('/\d+\s*[AP]M\s*(.)\s*\d+\s*[AP]M/', $times, $dashMatch) ? $dashMatch[1] : null;
                            if ($dashPos) {
                                $this->command->info('Dash character code: ' . mb_ord($dashPos, 'UTF-8'));
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
                $this->command->info('Created open hours for vendor: ' . $vendor->id);

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
                $this->command->info('Created reviews for vendor: ' . $vendor->id);

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
