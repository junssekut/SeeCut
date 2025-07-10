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
    public $reservationStatuses = [];

    public function mount()
    {
        // Initialize $reservationStatuses as an associative array for status binding
        $this->reservationStatuses = [];
        $vendorId = Auth::user()->vendor->id ?? null;
        $query = Reservation::query()->where('vendor_id', $vendorId);
        foreach ($query->get() as $reservation) {
            $this->reservationStatuses[$reservation->id]['status'] = $reservation->status;
        }
    }

    public function updatedReservationStatuses($value, $key)
    {
        // $key is like '123.status'
        [$id, $field] = explode('.', $key);
        if ($field === 'status') {
            $reservation = Reservation::find($id);
            if ($reservation) {
                $reservation->status = $value;
                $reservation->save();
            }
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
                  ->orWhere('phone', 'like', '%' . $this->search . '%');
            });
        }

        $reservations = $query->paginate(10);

        foreach ($reservations as $reservation) {
            if (!isset($this->reservationStatuses[$reservation->id]['status'])) {
                $this->reservationStatuses[$reservation->id]['status'] = $reservation->status;
            }
        }

        return view('livewire.vendor-reservation', [
            'reservations' => $reservations,
        ])->layout('layouts.vendor');
    }
}
