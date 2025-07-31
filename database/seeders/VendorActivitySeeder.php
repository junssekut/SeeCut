<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VendorActivity;
use App\Models\User;

class VendorActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get vendor users
        $vendors = User::whereHas('profile', function($query) {
            $query->where('role', 'vendor');
        })->get();

        if ($vendors->isEmpty()) {
            return; // No vendors to create activities for
        }

        $activities = [
            [
                'type' => 'update',
                'descriptions' => [
                    'Memperbarui informasi profil barbershop',
                    'Mengubah jam operasional',
                    'Memperbarui daftar layanan',
                    'Mengubah harga layanan potong rambut'
                ],
                'entity_types' => ['profile', 'operating_hours', 'service', 'service']
            ],
            [
                'type' => 'create', 
                'descriptions' => [
                    'Menambahkan layanan baru',
                    'Membuat paket promo spesial',
                    'Menambahkan stylist baru',
                    'Membuat jadwal khusus akhir pekan'
                ],
                'entity_types' => ['service', 'promotion', 'hairstylist', 'schedule']
            ],
            [
                'type' => 'confirm',
                'descriptions' => [
                    'Mengkonfirmasi reservasi pelanggan',
                    'Menyetujui booking untuk hari ini',
                    'Mengkonfirmasi pembayaran customer',
                    'Menyelesaikan layanan untuk pelanggan'
                ],
                'entity_types' => ['reservation', 'reservation', 'payment', 'service']
            ],
            [
                'type' => 'upload',
                'descriptions' => [
                    'Mengunggah foto hasil potongan terbaru',
                    'Memperbarui galeri barbershop',
                    'Menambahkan foto stylist baru',
                    'Mengunggah sertifikat barbershop'
                ],
                'entity_types' => ['photo', 'photo', 'photo', 'document']
            ]
        ];

        // Create activities for each vendor
        foreach ($vendors as $vendor) {
            // Create 15-25 activities per vendor over the last 30 days
            $activityCount = rand(15, 25);
            
            for ($i = 0; $i < $activityCount; $i++) {
                $activityGroup = $activities[array_rand($activities)];
                $descIndex = array_rand($activityGroup['descriptions']);
                
                VendorActivity::create([
                    'vendor_id' => $vendor->id,
                    'activity_type' => $activityGroup['type'],
                    'activity_description' => $activityGroup['descriptions'][$descIndex],
                    'entity_type' => $activityGroup['entity_types'][$descIndex],
                    'entity_id' => rand(1, 100), // Mock entity ID
                    'metadata' => [
                        'ip_address' => '192.168.1.' . rand(1, 255),
                        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
                    ],
                    'created_at' => now()->subDays(rand(0, 30))->subHours(rand(0, 23))->subMinutes(rand(0, 59)),
                    'updated_at' => now()->subDays(rand(0, 30))->subHours(rand(0, 23))->subMinutes(rand(0, 59)),
                ]);
            }
        }
    }
}
