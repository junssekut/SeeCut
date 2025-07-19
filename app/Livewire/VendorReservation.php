<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class VendorReservation extends Component
{
    use WithPagination;

    public $status = 'all';
    public $search = '';

    public function updateStatus($id, $status)
    {
        $reservation = Reservation::find($id);
        if ($reservation) {
            $reservation->status = $status;
            $reservation->save();
            
            // Use notyf for notifications
            notyf()
                ->duration(3000)
                ->ripple(true)
                ->addSuccess('Status reservasi IDX-' . $reservation->id . ' berhasil diganti!');
        }
    }

    public function setStatus($status)
    {
        $this->status = $status;
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        // Add a small delay to prevent excessive queries
        $this->resetPage();
    }

    public function render()
    {
        $vendorId = Auth::user()->vendor->id ?? null; // Adjust if your vendor-user relation is different

        $query = Reservation::query()
            ->where('vendor_id', $vendorId)
            ->with(['slot']);

        if ($this->status !== 'all') {
            $queryStatus = null;

            switch($this->status) {
                case 'masuk':
                    $queryStatus = 'confirmed';
                    break;
                case 'proses':
                    $queryStatus = 'pending';
                    break;
                case 'selesai':
                    $queryStatus = 'finished';
                    break;
                case 'batal':
                    $queryStatus = 'cancelled';
                    break;
                default:
                    $queryStatus = null;
            }

            if ($queryStatus !== null)
                $query->where('status', $queryStatus);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('phone', 'like', '%' . $this->search . '%')
                  ->orWhere('note', 'like', '%' . $this->search . '%');
            });
        }

        $reservations = $query->paginate(10);

        return view('livewire.vendor-reservation', [
            'reservations' => $reservations,
        ])->layout('layouts.vendor');
    }
}
