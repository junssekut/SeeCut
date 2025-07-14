<?php

namespace App\Livewire;

use Livewire\Component;

class VendorProfile extends Component
{
    public function render()
    {
        return view('livewire.vendor-profile')->layout('layouts.vendor');
    }
}
