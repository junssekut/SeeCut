<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\VendorHairstylist;
use App\Models\VendorPhoto;

class VendorHairstylists extends Component
{
    use WithFileUploads;

    public $hairstylists = [];
    public $new_hairstylist_name = '';
    public $new_hairstylist_description = '';
    public $new_hairstylist_image;
    public $hairstylistImageKey;

    public function mount()
    {
        $this->loadHairstylists();
        $this->hairstylistImageKey = rand();
    }

    public function loadHairstylists()
    {
        $vendor = Auth::user()->vendor;
        $this->hairstylists = VendorHairstylist::where('vendor_id', $vendor->id)
            ->with('vendorPhoto')
            ->get()
            ->map(function($hairstylist) {
                return [
                    'id' => $hairstylist->id,
                    'name' => $hairstylist->name,
                    'description' => $hairstylist->description,
                    'image_id' => $hairstylist->image_id,
                    'image_path' => $hairstylist->vendorPhoto ? $hairstylist->vendorPhoto->source : null,
                ];
            })
            ->toArray();
    }

    public function addHairstylist()
    {
        $this->validate([
            'new_hairstylist_name' => 'required|string|max:255',
            'new_hairstylist_description' => 'nullable|string|max:500',
            'new_hairstylist_image' => 'nullable|image|max:2048',
        ]);

        $vendor = Auth::user()->vendor;
        
        $imageId = null;
        if ($this->new_hairstylist_image) {
            // Store the image file
            $imagePath = $this->new_hairstylist_image->store('hairstylist-images', 'public');
            
            // Create VendorPhoto record
            $vendorPhoto = VendorPhoto::create([
                'type' => 'local',
                'category' => 'hairstylist',
                'source' => $imagePath,
            ]);
            
            $imageId = $vendorPhoto->id;
        }

        $hairstylist = VendorHairstylist::create([
            'vendor_id' => $vendor->id,
            'name' => $this->new_hairstylist_name,
            'description' => $this->new_hairstylist_description,
            'image_id' => $imageId,
        ]);

        // Reload hairstylists to get the proper relationship data
        $this->loadHairstylists();

        notyf()->duration(3000)->ripple(true)->addSuccess('Hairstylist ' . $this->new_hairstylist_name . ' telah ditambahkan!');
        
        $this->new_hairstylist_name = '';
        $this->new_hairstylist_description = '';
        $this->new_hairstylist_image = null;
        $this->hairstylistImageKey = rand();
    }

    public function removeHairstylist($hairstylistId)
    {
        $hairstylist = VendorHairstylist::with('vendorPhoto')->find($hairstylistId);
        
        if ($hairstylist) {
            // Delete the associated photo if it exists
            if ($hairstylist->image_id && $hairstylist->vendorPhoto) {
                // Delete the physical file
                Storage::disk('public')->delete($hairstylist->vendorPhoto->source);
                // Delete the VendorPhoto record
                $hairstylist->vendorPhoto->delete();
            }
            
            notyf()->duration(3000)->ripple(true)->addInfo('Hairstylist ' . $hairstylist->name . ' berhasil dihapus.');

            // Delete the hairstylist record
            $hairstylist->delete();

            // Reload the hairstylists list
            $this->loadHairstylists();
        }
    }

    public function render()
    {
        return view('livewire.vendor-hairstylists');
    }
}
