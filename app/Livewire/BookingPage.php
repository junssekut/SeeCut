<?php

namespace App\Livewire;

use Livewire\Component;

class BookingPage extends Component
{
    public function render()
    {
        return view('livewire.booking-page')->layout('layouts.app');
    }
}
