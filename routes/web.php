<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StyleController;

Route::view('/', 'livewire.pages.home')->name('home');

Route::get('/style', [StyleController::class, 'index'])->name('style.index');


// require __DIR__.'/auth.php';
