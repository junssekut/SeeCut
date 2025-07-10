<?php

use App\Livewire\Pages\Style\AiRecommendation;
use App\Livewire\Pages\Subscription\SubscriptionPage;
use App\Livewire\Pages\Subscription\Extend;
use App\Livewire\VendorReservation;
use Illuminate\Support\Facades\Route;
use App\Livewire\Home;
use App\Livewire\Pages\Style\StylingDetail;

Route::get('/', Home::class)->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::prefix('style')
    ->group(function () {
        Route::get('/', StylingDetail::class)->name('style');
        Route::get('/recommendation', AiRecommendation::class)->name('style.recommendation');
    });

Route::prefix('vendor')
    ->as('vendor.')
    ->middleware('vendor')
    ->group(function() {
        Route::get('/reservation', VendorReservation::class)->name('reservation');
    });

Route::get('/subscription', SubscriptionPage::class);
Route::get('/subscription/extend', Extend::Class);

Route::view('/test', 'test');

require __DIR__.'/auth.php';