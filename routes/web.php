<?php

use App\Livewire\Pages\Style\AiRecommendation;
use App\Livewire\Pages\Subscription\SubscriptionPage;
use App\Livewire\Extend;
use App\Livewire\VendorProfile;
use App\Livewire\VendorReservation;
use Illuminate\Support\Facades\Route;
use App\Livewire\Home;
use App\Livewire\Pages\Style\StylingDetail;
use App\Livewire\UserProfile;
// use App\Livewire\Information;

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
        Route::get('/subscription/extend', Extend::Class)->name('extend');
        Route::get('/profile', VendorProfile::class)->name('profile');

        Route::get('/logout', function () {
            auth()->logout();
            return redirect()->route('vendor.login');
        })->name('logout');
        
        Route::post('/logout', function () {
            auth()->logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            return redirect()->route('vendor.login');
        })->name('logout.post');
    });

Route::get('/subscription', SubscriptionPage::class);

Route::get('/product-detail', function () {
    return view('product-detail');
})->name('product.detail');
Route::view('/test', 'test');

//Route::get('/information', Information::class);
Route::get('/profile', UserProfile::class)->name('profile');

require __DIR__.'/auth.php';