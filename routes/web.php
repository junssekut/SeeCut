<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StyleController;

Route::view('/', view: 'livewire.pages.home')->name('home');

Route::get('/style', [StyleController::class, 'index'])->name('style');

Route::view('/recomendation', view: 'livewire.pages.airecomendation')->name('recomendation');


// require __DIR__.'/auth.php';
