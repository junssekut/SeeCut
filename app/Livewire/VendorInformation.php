<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Models\Vendor;
use App\Models\ProfileImage;
use App\Traits\LogsVendorActivity;
use function Flasher\Notyf\Prime\notyf;

class VendorInformation extends Component
{
    use WithFileUploads, LogsVendorActivity;

    public $name, $address, $description;
    public $logo;
    public $currentLogoPath;
    public $latitude;
    public $longitude;

    public function mount()
    {
        $vendor = Auth::user()->vendor;
        $this->name = $vendor->name;
        $this->address = $vendor->address;
        $this->description = $vendor->description ?? '';
        $this->latitude = $vendor->latitude;
        $this->longitude = $vendor->longitude;
        
        // Get the profile image by image_id
        $profile = Auth::user()->profile;
        if ($profile && $profile->image_id) {
            $profileImage = ProfileImage::find($profile->image_id);
            if ($profileImage) {
                $this->currentLogoPath = $profileImage->source;
            }
        }
    }
    
    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $vendor = Auth::user()->vendor;
        $originalData = [
            'name' => $vendor->name,
            'address' => $vendor->address,
            'description' => $vendor->description,
        ];
        
        $vendor->update([
            'name' => $this->name,
            'address' => $this->address,
            'description' => $this->description,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ]);

        // Log vendor activity for profile update
        $changes = [];
        if ($originalData['name'] !== $this->name) $changes[] = 'nama';
        if ($originalData['address'] !== $this->address) $changes[] = 'alamat';
        if ($originalData['description'] !== $this->description) $changes[] = 'deskripsi';
        
        if (!empty($changes)) {
            $this->logVendorActivity(
                self::ACTIVITY_UPDATE,
                'Memperbarui informasi barbershop (' . implode(', ', $changes) . ')',
                self::ENTITY_PROFILE,
                $vendor->id,
                [
                    'changes' => $changes,
                    'original_data' => $originalData,
                    'new_data' => [
                        'name' => $this->name,
                        'address' => $this->address,
                        'description' => $this->description,
                    ]
                ]
            );
        }

        // Handle logo upload
        if ($this->logo) {
            $logoPath = $this->logo->store('vendor-logos', 'public');
            
            $profile = Auth::user()->profile;
            if ($profile && $profile->image_id) {
                $profileImage = ProfileImage::find($profile->image_id);
                if ($profileImage) {
                    $profileImage->update(['source' => $logoPath]);
                } else {
                    $profileImage = ProfileImage::create(['source' => $logoPath]);
                    $profile->update(['image_id' => $profileImage->id]);
                }
            } else {
                $profileImage = ProfileImage::create(['source' => $logoPath]);
                if ($profile) {
                    $profile->update(['image_id' => $profileImage->id]);
                }
            }
            
            $this->currentLogoPath = $logoPath;
            $this->logo = null;
            
            // Log logo upload activity
            $this->logVendorActivity(
                self::ACTIVITY_UPLOAD,
                'Mengunggah logo barbershop baru',
                self::ENTITY_PHOTO,
                $profileImage->id,
                [
                    'file_path' => $logoPath,
                    'file_type' => 'logo'
                ]
            );
        }

        notyf()->duration(3000)->ripple(true)->addSuccess('Informasi barbershop telah berhasil disimpan!');
        session()->flash('message', 'Informasi berhasil disimpan!');
    }

    public function render()
    {
        return view('livewire.vendor-information');
    }
}
