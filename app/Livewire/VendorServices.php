<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\VendorService;
use App\Traits\LogsVendorActivity;
use function Flasher\Notyf\Prime\notyf;

class VendorServices extends Component
{
    use LogsVendorActivity;
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
        
        // Log service creation activity
        $this->logVendorActivity(
            self::ACTIVITY_CREATE,
            "Menambahkan layanan baru '{$this->new_service_name}' dengan harga Rp " . number_format($this->new_service_price, 0, ',', '.'),
            self::ENTITY_SERVICE,
            $service->id,
            [
                'service_name' => $this->new_service_name,
                'price' => $this->new_service_price,
                'action' => 'create'
            ]
        );
        
        notyf()->duration(3000)->ripple(true)->addSuccess('Layanan baru ' . $this->new_service_name . ' telah ditambahkan!');

        $this->new_service_name = '';
        $this->new_service_price = '';
    }

    public function removeService($serviceId)
    {
        $service = VendorService::find($serviceId);
        
        if ($service) {
            $serviceName = $service->service_name;
            $servicePrice = $service->price;
            
            // Log service deletion activity
            $this->logVendorActivity(
                self::ACTIVITY_DELETE,
                "Menghapus layanan '{$serviceName}'",
                self::ENTITY_SERVICE,
                $serviceId,
                [
                    'service_name' => $serviceName,
                    'price' => $servicePrice,
                    'action' => 'delete'
                ]
            );
            
            notyf()->duration(3000)->ripple(true)->addInfo('Layanan ' . $serviceName . ' berhasil dihapus.');
            
            $service->delete();
            $this->services = array_filter($this->services, function($service) use ($serviceId) {
                return $service['id'] !== $serviceId;
            });
        }
    }

    public function render()
    {
        return view('livewire.vendor-services');
    }
}
