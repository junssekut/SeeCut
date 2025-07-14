<?php

namespace App\Livewire;

use Livewire\Component;

class Extend extends Component
{
    public function render()
    {
        return view('livewire.vendor-subscription-extend')->layout('layouts.vendor');;
    }
}
