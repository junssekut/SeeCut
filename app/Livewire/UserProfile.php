<?php

namespace App\Livewire;

use Livewire\Component;

class UserProfile extends Component
{
    public function render()
    {
        return view('livewire.profile')->layout('layouts.app');
    }
}

