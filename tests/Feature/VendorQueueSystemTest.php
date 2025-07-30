<?php

use App\Models\User;
use App\Models\Vendor;
use App\Models\Reservation;
use App\Models\ReservationSlot;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationStatusUpdated;

test('vendor can process next customer in queue automatically', function () {
    Mail::fake();
    
    // Create a vendor user
    $vendor = Vendor::factory()->create();
    $user = User::factory()->create([
        'vendor_id' => $vendor->id
    ]);
    
    // Create some reservations for today
    $slot1 = ReservationSlot::factory()->create([
        'date' => Carbon::today(),
        'start_time' => '09:00:00'
    ]);
    $slot2 = ReservationSlot::factory()->create([
        'date' => Carbon::today(),
        'start_time' => '10:00:00'
    ]);
    
    $reservation1 = Reservation::factory()->create([
        'vendor_id' => $vendor->id,
        'reservation_id' => $slot1->id,
        'status' => 'confirmed',
        'email' => 'customer1@example.com'
    ]);
    
    $reservation2 = Reservation::factory()->create([
        'vendor_id' => $vendor->id,
        'reservation_id' => $slot2->id,
        'status' => 'confirmed',  
        'email' => 'customer2@example.com'
    ]);
    
    // Act as the vendor
    $this->actingAs($user);
    
    // Start the day - should process first customer
    $component = Livewire::test(\App\Livewire\VendorReservation::class)
        ->call('startDay');
    
    // Assert first customer is now in processing
    $reservation1->refresh();
    expect($reservation1->status)->toBe('pending');
    
    // Assert email was sent
    Mail::assertSent(ReservationStatusUpdated::class, function ($mail) use ($reservation1) {
        return $mail->reservation->id === $reservation1->id;
    });
    
    // Complete first customer - should automatically process second
    $component->call('updateStatus', $reservation1->id, 'finished');
    
    // Assert second customer is now in processing
    $reservation2->refresh();
    expect($reservation2->status)->toBe('pending');
    
    // Assert email was sent to second customer
    Mail::assertSent(ReservationStatusUpdated::class, function ($mail) use ($reservation2) {
        return $mail->reservation->id === $reservation2->id;
    });
});

test('queue statistics are calculated correctly', function () {
    // Create a vendor user
    $vendor = Vendor::factory()->create();
    $user = User::factory()->create([
        'vendor_id' => $vendor->id
    ]);
    
    // Create reservations with different statuses for today
    $todaySlots = ReservationSlot::factory()->count(5)->create([
        'date' => Carbon::today()
    ]);
    
    $reservations = collect();
    $statuses = ['confirmed', 'confirmed', 'pending', 'finished', 'cancelled'];
    
    foreach ($todaySlots as $index => $slot) {
        $reservations->push(Reservation::factory()->create([
            'vendor_id' => $vendor->id,
            'reservation_id' => $slot->id,
            'status' => $statuses[$index]
        ]));
    }
    
    // Act as the vendor
    $this->actingAs($user);
    
    // Test queue statistics
    $component = Livewire::test(\App\Livewire\VendorReservation::class);
    $stats = $component->instance()->getQueueStats();
    
    expect($stats['total'])->toBe(5);
    expect($stats['confirmed'])->toBe(2);
    expect($stats['processing'])->toBe(1);
    expect($stats['finished'])->toBe(1);
    expect($stats['cancelled'])->toBe(1);
});
