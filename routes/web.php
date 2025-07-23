<?php

use App\Livewire\Berlangganan;
use App\Livewire\AdminHome;
use App\Livewire\Pages\Style\AiRecommendation;
use App\Livewire\Pages\Subscription\SubscriptionPage;
use App\Livewire\Extend;
use App\Livewire\VendorReservation;
use Illuminate\Support\Facades\Route;
use App\Livewire\Home;
use App\Livewire\Pages\Style\StylingDetail;
use App\Livewire\Information;

Route::get('/berlangganan', Berlangganan::class)->name('berlangganan');

Route::get('/', Home::class)->name('home');

Route::get('/dashboard', AdminHome::class)
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
        Route::get('/subscription/extend', Extend::Class);

        // Route::post('/logout');
    });

Route::get('/subscription', SubscriptionPage::class);

Route::get('/product-detail', function () {
    return view('product-detail');
})->name('product.detail');

Route::get('/dashboard', AdminHome::class)->name('dashboard');


Route::get('/information', Information::class);

require __DIR__.'/auth.php';