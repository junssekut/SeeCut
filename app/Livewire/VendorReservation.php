<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationStatusUpdated;
use Carbon\Carbon;

class VendorReservation extends Component
{
    use WithPagination;

    public $status = 'all';
    public $search = '';

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function updateStatus($id, $status)
    {
        $reservation = Reservation::find($id);
        if ($reservation) {
            $oldStatus = $reservation->status;
            $reservation->status = $status;
            $reservation->save();
            
            // Send email notification to the actual customer
            try {
                Mail::to($reservation->email)->send(new ReservationStatusUpdated($reservation, $status));
            } catch (\Exception $e) {
                // Log error but don't fail the status update
                \Log::error('Failed to send reservation email: ' . $e->getMessage());
            }
            
            // Debug log to check if this condition is being hit
            \Log::info('Status updated', [
                'reservation_id' => $id,
                'old_status' => $oldStatus,
                'new_status' => $status,
                'will_process_next' => ($status === 'finished')
            ]);
            
            // Auto-process next reservation if current one is finished
            if ($status === 'finished') {
                \Log::info('Processing next in queue for reservation: ' . $id);
                $this->processNextInQueue();
            }
            
            // Use notyf for notifications
            notyf()
                ->duration(3000)
                ->ripple(true)
                ->addSuccess('Status reservasi IDX-' . $reservation->id . ' berhasil diganti dan email telah dikirim!');
        }
    }

    /**
     * Automatically process the next reservation in queue
     */
    public function processNextInQueue()
    {
        $vendorId = Auth::user()->vendor->id ?? null;
        
        \Log::info('processNextInQueue called', ['vendor_id' => $vendorId]);
        
        if (!$vendorId) {
            \Log::warning('No vendor ID found');
            return;
        }

        // Find the next confirmed reservation (oldest first) for today
        $nextReservation = Reservation::where('reservations.vendor_id', $vendorId)
            ->where('status', 'confirmed')
            ->whereHas('slot', function($query) {
                $query->whereDate('date', Carbon::today());
            })
            ->with('slot')
            ->orderBy('created_at', 'asc')
            ->first();

        \Log::info('Next reservation search result', [
            'found' => $nextReservation ? true : false,
            'reservation_id' => $nextReservation ? $nextReservation->id : null,
            'today' => Carbon::today()->toDateString()
        ]);

        if ($nextReservation) {
            $nextReservation->status = 'pending';
            $nextReservation->save();

            \Log::info('Next reservation updated to pending', ['reservation_id' => $nextReservation->id]);

            // Send email notification to next customer
            try {
                Mail::to($nextReservation->email)->send(new ReservationStatusUpdated($nextReservation, 'pending'));
                
                notyf()
                    ->duration(4000)
                    ->ripple(true)
                    ->addInfo('Pelanggan berikutnya (IDX-' . $nextReservation->id . ') telah dipindahkan ke status Proses dan diberitahu via email!');
            } catch (\Exception $e) {
                \Log::error('Failed to send next queue email: ' . $e->getMessage());
            }
        } else {
            \Log::info('No confirmed reservations found for today');
            notyf()
                ->duration(3000)
                ->ripple(true)
                ->addInfo('Tidak ada lagi pelanggan dalam antrian untuk hari ini.');
        }
    }

    /**
     * Manually process next customer in queue
     * First finishes current processing customer, then calls next
     */
    public function callNextCustomer()
    {
        $vendorId = Auth::user()->vendor->id ?? null;
        
        if (!$vendorId) {
            \Log::warning('No vendor ID found in callNextCustomer');
            return;
        }

        // First, find any customer currently being processed and mark them as finished
        $currentProcessing = Reservation::where('reservations.vendor_id', $vendorId)
            ->where('status', 'pending')
            ->whereHas('slot', function($query) {
                $query->whereDate('date', Carbon::today());
            })
            ->first();

        if ($currentProcessing) {
            $currentProcessing->status = 'finished';
            $currentProcessing->save();
            
            \Log::info('Marked current processing customer as finished', ['reservation_id' => $currentProcessing->id]);
            
            // Send email notification to finished customer
            try {
                Mail::to($currentProcessing->email)->send(new ReservationStatusUpdated($currentProcessing, 'finished'));
            } catch (\Exception $e) {
                \Log::error('Failed to send finished email: ' . $e->getMessage());
            }

            notyf()
                ->duration(3000)
                ->ripple(true)
                ->addSuccess('Pelanggan saat ini (IDX-' . $currentProcessing->id . ') telah diselesaikan!');
        }

        // Then process the next customer in queue
        $this->processNextInQueue();
    }

    /**
     * Start the day by processing the first customer
     */
    public function startDay()
    {
        $vendorId = Auth::user()->vendor->id ?? null;
        
        if (!$vendorId) return;

        // Find the first confirmed reservation for today
        $firstReservation = Reservation::where('reservations.vendor_id', $vendorId)
            ->where('status', 'confirmed')
            ->whereHas('slot', function($query) {
                $query->whereDate('date', Carbon::today());
            })
            ->with('slot')
            ->orderBy('created_at', 'asc')
            ->first();

        if ($firstReservation) {
            $firstReservation->status = 'pending';
            $firstReservation->save();

            // Send email notification to first customer
            try {
                Mail::to($firstReservation->email)->send(new ReservationStatusUpdated($firstReservation, 'pending'));
                
                notyf()
                    ->duration(4000)
                    ->ripple(true)
                    ->addSuccess('Hari kerja dimulai! Pelanggan pertama (IDX-' . $firstReservation->id . ') telah dipanggil dan diberitahu via email!');
            } catch (\Exception $e) {
                \Log::error('Failed to send start day email: ' . $e->getMessage());
            }
        } else {
            notyf()
                ->duration(3000)
                ->ripple(true)
                ->addInfo('Tidak ada reservasi yang dikonfirmasi untuk hari ini.');
        }
    }

    /**
     * Get queue statistics for today
     */
    public function getQueueStats()
    {
        $vendorId = Auth::user()->vendor->id ?? null;
        
        if (!$vendorId) return [
            'total' => 0,
            'confirmed' => 0,
            'processing' => 0,
            'finished' => 0,
            'cancelled' => 0
        ];

        $today = Carbon::today();
        
        $stats = Reservation::where('reservations.vendor_id', $vendorId)
            ->whereHas('slot', function($query) use ($today) {
                $query->whereDate('date', $today);
            })
            ->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN status = "confirmed" THEN 1 ELSE 0 END) as confirmed,
                SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as processing,
                SUM(CASE WHEN status = "finished" THEN 1 ELSE 0 END) as finished,
                SUM(CASE WHEN status = "cancelled" THEN 1 ELSE 0 END) as cancelled
            ')
            ->first();

        return [
            'total' => $stats->total ?? 0,
            'confirmed' => $stats->confirmed ?? 0,
            'processing' => $stats->processing ?? 0,
            'finished' => $stats->finished ?? 0,
            'cancelled' => $stats->cancelled ?? 0
        ];
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
            ->where('reservations.vendor_id', $vendorId)
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

        // Sort by today first, then by date and time
        $today = Carbon::today()->toDateString();
        $query->leftJoin('reservation_slots', 'reservations.reservation_id', '=', 'reservation_slots.id')
              ->select('reservations.*')
              ->orderByRaw("CASE WHEN reservation_slots.date = ? THEN 0 ELSE 1 END", [$today])
              ->orderBy('reservation_slots.date', 'asc')
              ->orderBy('reservation_slots.start_time', 'asc')
              ->orderBy('reservations.created_at', 'asc');

        $reservations = $query->paginate(10);

        return view('livewire.vendor-reservation', [
            'reservations' => $reservations,
        ])->layout('layouts.vendor');
    }
}
