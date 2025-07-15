<?php

use App\Livewire\Pages\Style\AiRecommendation;
use App\Livewire\Pages\Subscription\SubscriptionPage;
use App\Livewire\Pages\Subscription\Extend;
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

Route::get('/subscription', SubscriptionPage::class);
Route::get('/subscription/extend', Extend::class);

Route::get('/product-detail', function () {
    return view('product-detail');
})->name('product.detail');
Route::view('/test', 'test');

require __DIR__.'/auth.php';