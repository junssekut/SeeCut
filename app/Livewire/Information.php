<?php

namespace App\Livewire;

use Livewire\Component;

class Information extends Component
{
    public function render()
    {
        return view('livewire.information')->layout('layouts.vendor');
    }
}
