<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\VendorOpenHour;

class VendorOperatingHours extends Component
{
    public $open_hours = [];
    public $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

    public function mount()
    {
        $vendor = Auth::user()->vendor;
        
        // Initialize open hours
        foreach ($this->days as $day) {
            $this->open_hours[$day] = ['open_time' => '', 'close_time' => ''];
        }
        
        // Load existing hours
        $existingHours = VendorOpenHour::where('vendor_id', $vendor->id)->get();
        foreach ($existingHours as $hour) {
            $this->open_hours[$hour->day] = [
                'open_time' => $hour->open_time,
                'close_time' => $hour->close_time
            ];
        }
    }

    public function save()
    {
        $vendor = Auth::user()->vendor;
        
        // Delete existing hours
        VendorOpenHour::where('vendor_id', $vendor->id)->delete();
        
        // Save new hours
        foreach ($this->open_hours as $day => $hours) {
            if (!empty($hours['open_time']) && !empty($hours['close_time'])) {
                VendorOpenHour::create([
                    'vendor_id' => $vendor->id,
                    'day' => $day,
                    'open_time' => $hours['open_time'],
                    'close_time' => $hours['close_time'],
                ]);
            }
        }

        notyf()->duration(3000)->ripple(true)->addInfo('Jam operasional berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.vendor-operating-hours');
    }
}
