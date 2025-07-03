<?php

namespace App\Livewire\Pages\Home;

use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        return view('livewire.pages.home.home')
            ->layout('layouts.app');
    }
}
