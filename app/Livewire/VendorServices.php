<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\VendorService;

class VendorServices extends Component
{
    public $services = [];
    public $new_service_name = '';
    public $new_service_price = '';

    public function mount()
    {
        $this->loadServices();
    }

    public function loadServices()
    {
        $vendor = Auth::user()->vendor;
        $this->services = VendorService::where('vendor_id', $vendor->id)->get()->toArray();
    }

    public function addService()
    {
        $this->validate([
            'new_service_name' => 'required|string|max:255',
            'new_service_price' => 'required|numeric|min:0',
        ]);

        $vendor = Auth::user()->vendor;
        
        $service = VendorService::create([
            'vendor_id' => $vendor->id,
            'service_name' => $this->new_service_name,
            'price' => $this->new_service_price,
        ]);

        $this->services[] = $service->toArray();
        
        notyf()->duration(3000)->ripple(true)->addSuccess('Layanan baru' . $this->new_service_name . ' telah ditambahkan!');

        $this->new_service_name = '';
        $this->new_service_price = '';
    }

    public function removeService($serviceId)
    {
        $service = VendorService::find($serviceId);

        notyf()->duration(3000)->ripple(true)->addInfo('Layanan ' . $service->service_name . ' berhasil dihapus.');

        $service->delete();
        $this->services = array_filter($this->services, function($service) use ($serviceId) {
            return $service['id'] !== $serviceId;
        });
    }

    public function render()
    {
        return view('livewire.vendor-services');
    }
}
