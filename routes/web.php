<?php

use App\Livewire\Pages\Style\AiRecommendation;
use App\Livewire\Pages\Subscription\SubscriptionPage;
use Illuminate\Support\Facades\Route;
use App\Livewire\Pages\Home\Home;
use App\Livewire\Pages\Style\StylingDetail;
use App\Livewire\MasukDev;

// Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/', Home::class)->name('home');

Route::prefix('style')
    ->group(function () {
        Route::get('/', StylingDetail::class)->name('style');
        Route::get('/recommendation', AiRecommendation::class)->name('style.recommendation');
    });

Route::get('/subscription', SubscriptionPage::class);

Route::get('/masuk', MasukDev::class)->name('masuk.dev');

require __DIR__.'/auth.php';