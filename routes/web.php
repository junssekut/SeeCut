<?php

use App\Livewire\Berlangganan;
use App\Livewire\AdminHome;
use App\Livewire\Pages\Style\AiRecommendation;
use App\Livewire\Pages\Subscription\SubscriptionPage;
use App\Livewire\Extend;
use App\Livewire\ProductDetail;
use App\Livewire\BarbershopListing;
use App\Livewire\VendorProfile;
use App\Livewire\VendorReservation;
use Illuminate\Support\Facades\Route;
use App\Livewire\Home;
use App\Livewire\Pages\Style\StylingDetail;
use App\Livewire\UserProfile;
// use App\Livewire\Information;

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
    return view('product-detail-sisil');
})->name('product.detail');

Route::get('/dashboard', AdminHome::class)->name('dashboard');


// Barbershop routes
Route::get('/barbershop', BarbershopListing::class)->name('barbershop.index');
Route::get('/barbershop/{id}', ProductDetail::class)->name('barbershop.view');

//Route::get('/information', Information::class);
Route::get('/profile', UserProfile::class)->name('profile');

// User logout route
Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('home');
})->name('logout');

require __DIR__.'/auth.php';