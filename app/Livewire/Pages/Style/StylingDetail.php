<?php

namespace App\Livewire\Pages\Style;

use Livewire\Component;

class StylingDetail extends Component
{
    public function render()
    {
        $hairStyles = [
            [
                'name' => 'Buzz Cut',
                'description' => 'Gaya potong super pendek yang praktis dan memberikan kesan bersih serta tegas.',
                'image' => 'buzzcut.jpg',
            ],
            [
                'name' => 'Crew Cut',
                'description' => 'Potongan klasik dengan sedikit panjang di atas, cocok untuk tampilan rapi dan profesional.',
                'image' => 'crewcut.jpg',
            ],
            [
                'name' => 'Side Cut',
                'description' => 'Gaya dengan bagian samping tipis dan atas lebih panjang, memberikan kesan modern.',
                'image' => 'sidecut.jpg',
            ],
            [
                'name' => 'French Crop',
                'description' => 'Gaya potongan pendek dengan poni depan rata, memberikan tampilan tegas namun tetap stylish.',
                'image' => 'frenchcrop.jpg',
            ],
            [
                'name' => 'Slicked Back',
                'description' => 'Tampilan rambut disisir ke belakang dengan rapi, menciptakan kesan elegan dan berwibawa.',
                'image' => 'slickedback.jpg',
            ],
            [
                'name' => 'Taper Cut',
                'description' => 'Potongan samping tipis dengan bagian atas lebih panjang, sempurna.',
                'image' => 'tapercut.jpg',
            ],
            [
                'name' => 'CEPAK NGENTOD',
                'description' => 'Potongan samping tipis dengan bagian atas lebih panjang, sempurna.',
                'image' => 'tapercut.jpg',
            ],
        ];

        return view('livewire.pages.style.styling-detail', compact('hairStyles'))->layout('layouts.app');
    }
}
