<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StyleController;

Route::view('/', view: 'livewire.pages.home')->name('home');

Route::get('/style', [StyleController::class, 'index'])->name('style');

Route::view('/recomendation', view: 'livewire.pages.airecomendation')->name('recomendation');

Route::view('/masuksekarang', view: 'livewire.pages.masuksekarang')->name('masuksekarang');

Route::view('/card-langganan', view: 'livewire.pages.cardlangganan')->name('langganan');

Route::view('/reservation', view: 'livewire.pages.bookingpage')->name('booking page');
// require __DIR__.'/auth.php';
