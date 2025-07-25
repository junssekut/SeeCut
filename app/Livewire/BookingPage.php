<?php

namespace App\Livewire;

use App\Models\Reservation;
use App\Models\ReservationSlot;
use App\Models\Vendor;
use App\Models\VendorOpenHour;
use App\Models\VendorService;
use Carbon\Carbon;
use Livewire\Component;

class BookingPage extends Component
{
    public $selectedDate = '';
    public $selectedTime = '';
    public $selectedSlotId = '';
    public $service = '';
    public $customerName = '';
    public $customerPhone = '';
    public $customerEmail = '';
    
    public $vendorId;
    public $vendor;
    public $availableDates = [];
    public $availableTimeSlots = [];
    public $services = [];
    public $vendorServices = []; // Store full service objects with prices

    public function mount($vendor = null, $service = null)
    {
        // Get vendor ID from route parameter or default
        $this->vendorId = $vendor ?? request()->get('vendor') ?? 1;
        
        // Load vendor information
        $this->vendor = Vendor::find($this->vendorId);
        
        if (!$this->vendor) {
            abort(404, 'Barbershop not found');
        }
        
        // Load services for this vendor from database
        $this->vendorServices = VendorService::where('vendor_id', $this->vendorId)->get();
        $this->services = $this->vendorServices->pluck('service_name')->toArray();
        
        // If no services found, provide default fallback
        if (empty($this->services)) {
            $this->services = [
                'Haircut Premium',
                'Haircut & Shave', 
                'Hair Coloring',
                'Hair Wash',
                'Beard Trim'
            ];
            // Create temporary service objects for fallback
            $this->vendorServices = collect($this->services)->map(function($serviceName) {
                return (object) [
                    'id' => null,
                    'service_name' => $serviceName,
                    'price' => 0
                ];
            });
        }
        
        // Pre-select service if passed from barbershop detail page
        $serviceFromQuery = request()->get('service');
        if ($serviceFromQuery && in_array($serviceFromQuery, $this->services)) {
            $this->service = $serviceFromQuery;
        } elseif ($service && in_array($service, $this->services)) {
            $this->service = $service;
        }
        
        $this->generateAvailableDates();
        if ($this->selectedDate) {
            $this->loadTimeSlots();
        }
    }

    public function generateAvailableDates()
    {
        $this->availableDates = [];
        $startDate = Carbon::today();
        
        for ($i = 0; $i < 7; $i++) {
            $date = $startDate->copy()->addDays($i);
            $dayName = $date->format('l'); // Get day name (Monday, Tuesday, etc.)
            
            // Check if vendor is open on this day
            $openHour = VendorOpenHour::where('vendor_id', $this->vendorId)
                ->where('day', $dayName)
                ->first();
            
            // Disable if vendor is closed (no open hours or open_time/close_time is null)
            $isDisabled = !$openHour || !$openHour->open_time || !$openHour->close_time;
            
            $this->availableDates[] = [
                'date' => $date->format('Y-m-d'),
                'display_date' => $date->format('d'),
                'display_day' => $this->getIndonesianDay($date->format('D')),
                'disabled' => $isDisabled
            ];
        }
        
        // Set first available date as selected
        $firstAvailable = collect($this->availableDates)->first(function($date) {
            return !$date['disabled'];
        });
        if ($firstAvailable) {
            $this->selectedDate = $firstAvailable['date'];
        }
    }

    public function loadTimeSlots()
    {
        if (!$this->selectedDate) {
            $this->availableTimeSlots = [];
            return;
        }

        // Get vendor operating hours for the selected date
        $selectedDateCarbon = Carbon::parse($this->selectedDate);
        $dayName = $selectedDateCarbon->format('l'); // Get day name (Monday, Tuesday, etc.)
        
        $openHour = VendorOpenHour::where('vendor_id', $this->vendorId)
            ->where('day', $dayName)
            ->first();
        
        // If vendor is closed on this day, return empty slots
        if (!$openHour || !$openHour->open_time || !$openHour->close_time) {
            $this->availableTimeSlots = [];
            return;
        }

        // Parse vendor operating hours
        $vendorOpenTime = Carbon::parse($openHour->open_time);
        $vendorCloseTime = Carbon::parse($openHour->close_time);

        // Create default time slots
        $defaultTimes = [
            ['start' => '08:00', 'end' => '09:00'],
            ['start' => '10:00', 'end' => '11:00'],
            ['start' => '11:00', 'end' => '12:00'],
            ['start' => '12:00', 'end' => '13:00'],
            ['start' => '14:00', 'end' => '15:00'],
            ['start' => '16:00', 'end' => '17:00'],
            ['start' => '17:00', 'end' => '18:00'],
            ['start' => '19:00', 'end' => '20:00'],
            ['start' => '21:00', 'end' => '22:00'],
        ];

        $this->availableTimeSlots = [];

        foreach ($defaultTimes as $time) {
            $timeString = $time['start'] . ' - ' . $time['end'];
            
            // Parse slot times
            $slotStartTime = Carbon::parse($time['start']);
            $slotEndTime = Carbon::parse($time['end']);
            
            // Check if this time slot is within vendor operating hours
            $isWithinOperatingHours = $slotStartTime->greaterThanOrEqualTo($vendorOpenTime) && 
                                     $slotEndTime->lessThanOrEqualTo($vendorCloseTime);
            
            // Skip if not within operating hours
            if (!$isWithinOperatingHours) {
                continue;
            }
            
            // Check if there's an existing slot for this time
            $existingSlot = ReservationSlot::where('vendor_id', $this->vendorId)
                ->where('date', $this->selectedDate)
                ->where('start_time', $time['start'])
                ->where('end_time', $time['end'])
                ->first();
            
            // Check if this time slot is already booked
            $isBooked = false;
            if ($existingSlot) {
                $isBooked = Reservation::where('reservation_id', $existingSlot->id)
                    ->whereIn('status', ['pending', 'confirmed'])
                    ->exists();
            }

            $this->availableTimeSlots[] = [
                'id' => $existingSlot ? $existingSlot->id : null,
                'time' => $timeString,
                'start_time' => $time['start'],
                'end_time' => $time['end'],
                'available' => !$isBooked
            ];
        }
        
        // Set first available time as default
        $firstAvailable = collect($this->availableTimeSlots)->first(function($slot) {
            return $slot['available'];
        });
        if ($firstAvailable) {
            $this->selectedTime = $firstAvailable['time'];
            $this->selectedSlotId = $firstAvailable['id'];
        }
    }

    public function selectDate($date)
    {
        $this->selectedDate = $date;
        $this->selectedTime = '';
        $this->selectedSlotId = '';
        $this->loadTimeSlots();
    }

    public function selectTime($time, $slotId = null)
    {
        $this->selectedTime = $time;
        $this->selectedSlotId = $slotId;
    }

    public function fillUserInfo()
    {
        $user = auth()->user();
        if ($user) {
            // Get name from user's name field or profile first_name + last_name
            if ($user->name) {
                $this->customerName = $user->name;
            } elseif ($user->profile) {
                $firstName = $user->profile->first_name ?? '';
                $lastName = $user->profile->last_name ?? '';
                $this->customerName = trim($firstName . ' ' . $lastName);
            }
            
            // Get phone from profile
            $this->customerPhone = $user->profile->phone ?? $user->phone ?? '';
            
            // Get email from user
            $this->customerEmail = $user->email ?? '';
        }
    }

    public function submitBooking()
    {
        $this->validate([
            'selectedDate' => 'required|date|after_or_equal:today',
            'selectedTime' => 'required|string',
            'service' => 'required|string',
            'customerName' => 'required|string|min:2',
            'customerPhone' => 'required|string|min:10',
            'customerEmail' => 'required|email',
        ], [
            'selectedDate.required' => 'Pilih tanggal terlebih dahulu',
            'selectedTime.required' => 'Pilih waktu terlebih dahulu',
            'service.required' => 'Pilih layanan terlebih dahulu',
            'customerName.required' => 'Nama pelanggan harus diisi',
            'customerPhone.required' => 'Nomor handphone harus diisi',
            'customerEmail.required' => 'Email harus diisi',
            'customerEmail.email' => 'Format email tidak valid',
        ]);

        try {
            // Parse the selected time to get start and end times
            $timeParts = explode(' - ', $this->selectedTime);
            $startTime = $timeParts[0];
            $endTime = $timeParts[1];

            // Get or create reservation slot
            $reservationSlot = ReservationSlot::firstOrCreate([
                'vendor_id' => $this->vendorId,
                'date' => $this->selectedDate,
                'start_time' => $startTime,
                'end_time' => $endTime,
            ]);

            // Check if this slot is already booked
            $existingReservation = Reservation::where('reservation_id', $reservationSlot->id)
                ->whereIn('status', ['pending', 'confirmed'])
                ->exists();

            if ($existingReservation) {
                $this->dispatch('show-notification', [
                    'type' => 'error',
                    'message' => 'Slot waktu sudah dibooking. Silakan pilih waktu lain.'
                ]);
                $this->loadTimeSlots(); // Refresh slots
                return;
            }

            // Create reservation
            $reservation = Reservation::create([
                'user_id' => auth()->id(),
                'vendor_id' => $this->vendorId,
                'reservation_id' => $reservationSlot->id,
                'name' => $this->customerName,
                'email' => $this->customerEmail,
                'phone' => $this->customerPhone,
                'status' => 'pending',
                'note' => $this->service, // Store service in note field
            ]);

            // Show success message
            $this->dispatch('show-notification', [
                'type' => 'success',
                'message' => 'Reservasi berhasil dibuat! Kami akan segera menghubungi Anda.'
            ]);
            
            // Reset form
            $this->reset(['service', 'customerName', 'customerPhone', 'customerEmail']);
            $this->loadTimeSlots(); // Refresh available slots
            
        } catch (\Exception $e) {
            $this->dispatch('show-notification', [
                'type' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    private function getIndonesianDay($day)
    {
        $days = [
            'Mon' => 'sen', 'Tue' => 'sel', 'Wed' => 'rab', 
            'Thu' => 'kam', 'Fri' => 'jum', 'Sat' => 'sab', 'Sun' => 'min'
        ];
        return $days[$day] ?? $day;
    }

    public function getSelectedServicePrice()
    {
        if (!$this->service) {
            return 0;
        }
        
        $selectedService = $this->vendorServices->firstWhere('service_name', $this->service);
        return $selectedService ? $selectedService->price : 0;
    }

    public function getFormattedSelectedServicePrice()
    {
        $price = $this->getSelectedServicePrice();
        return $price > 0 ? 'Rp ' . number_format($price, 0, ',', '.') : 'Gratis';
    }

    public function getFormattedSelectedDate()
    {
        if ($this->selectedDate) {
            return Carbon::parse($this->selectedDate)->locale('id')->isoFormat('DD MMMM YYYY');
        }
        return '-';
    }

    public function render()
    {
        return view('livewire.booking-page')->layout('layouts.app');
    }
}
