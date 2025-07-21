<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vendor;
use App\Models\VendorService;

class VendorServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            'Haircut',
            'Hair Wash',
            'Shaving',
            'Beard Trim',
            'Hair Styling',
            'Hair Coloring',
            'Creambath',
            'Hair Spa',
            'Eyebrow Trimming',
            'Mustache Trim'
        ];

        $vendors = Vendor::all();
        
        foreach ($vendors as $vendor) {
            // Randomly assign 3-5 services to each vendor
            $numServices = rand(3, 5);
            $selectedServices = collect($services)->random($numServices);
            
            foreach ($selectedServices as $serviceName) {
                // Generate random prices based on service type
                $price = $this->generatePrice($serviceName);
                
                VendorService::create([
                    'vendor_id' => $vendor->id,
                    'service_name' => $serviceName,
                    'price' => $price,
                ]);
            }
        }
    }
    
    private function generatePrice($serviceName)
    {
        $basePrices = [
            'Haircut' => [25000, 50000],
            'Hair Wash' => [15000, 25000],
            'Shaving' => [20000, 35000],
            'Beard Trim' => [15000, 30000],
            'Hair Styling' => [30000, 60000],
            'Hair Coloring' => [80000, 150000],
            'Creambath' => [40000, 80000],
            'Hair Spa' => [50000, 100000],
            'Eyebrow Trimming' => [10000, 20000],
            'Mustache Trim' => [10000, 25000]
        ];
        
        $range = $basePrices[$serviceName] ?? [20000, 50000];
        return rand($range[0], $range[1]);
    }
}
