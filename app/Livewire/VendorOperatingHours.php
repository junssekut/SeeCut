<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\VendorOpenHour;
use App\Traits\LogsVendorActivity;
use function Flasher\Notyf\Prime\notyf;

class VendorOperatingHours extends Component
{
    use LogsVendorActivity;
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
        
        // Get existing hours for comparison
        $existingHours = VendorOpenHour::where('vendor_id', $vendor->id)->get()->keyBy('day');
        
        // Track changes
        $changes = [];
        $newHours = [];
        
        foreach ($this->open_hours as $day => $hours) {
            if (!empty($hours['open_time']) && !empty($hours['close_time'])) {
                $newHours[$day] = $hours;
                
                // Check if this is a change
                if (!isset($existingHours[$day]) || 
                    $existingHours[$day]->open_time !== $hours['open_time'] ||
                    $existingHours[$day]->close_time !== $hours['close_time']) {
                    $changes[] = $day;
                }
            }
        }
        
        // Check for removed days
        foreach ($existingHours as $day => $hour) {
            if (!isset($newHours[$day])) {
                $changes[] = $day . ' (dihapus)';
            }
        }
        
        // Delete existing hours
        VendorOpenHour::where('vendor_id', $vendor->id)->delete();
        
        // Save new hours
        foreach ($newHours as $day => $hours) {
            VendorOpenHour::create([
                'vendor_id' => $vendor->id,
                'day' => $day,
                'open_time' => $hours['open_time'],
                'close_time' => $hours['close_time'],
            ]);
        }

        // Log the activity if there were changes
        if (!empty($changes)) {
            $dayTranslations = [
                'Sunday' => 'Minggu',
                'Monday' => 'Senin', 
                'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis',
                'Friday' => 'Jumat',
                'Saturday' => 'Sabtu'
            ];
            
            $translatedChanges = array_map(function($change) use ($dayTranslations) {
                foreach ($dayTranslations as $en => $id) {
                    $change = str_replace($en, $id, $change);
                }
                return $change;
            }, $changes);
            
            $this->logVendorActivity(
                self::ACTIVITY_UPDATE,
                'Memperbarui jam operasional (' . implode(', ', $translatedChanges) . ')',
                self::ENTITY_OPERATING_HOURS,
                $vendor->id,
                [
                    'changed_days' => $changes,
                    'new_hours' => $newHours,
                    'total_operating_days' => count($newHours)
                ]
            );
        }

        notyf()->duration(3000)->ripple(true)->addInfo('Jam operasional berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.vendor-operating-hours');
    }
}
