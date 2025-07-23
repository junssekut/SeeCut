<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Url;

class VendorProfile extends Component
{
    #[Url(as: 'section', history: true, keep: true)]
    public $activeSection = 'information';

    public function setActiveSection($section)
    {
        $this->activeSection = $section;
        // Force component to re-render and update URL
        $this->dispatch('section-changed', section: $section);
    }

    public function mount()
    {
        // Validate that the section is valid
        $validSections = ['information', 'operating-hours', 'services', 'hairstylists'];
        if (!in_array($this->activeSection, $validSections)) {
            $this->activeSection = 'information';
        }
        
        // If no section is specified in URL, default to information
        if (empty($this->activeSection)) {
            $this->activeSection = 'information';
        }
    }

    public function updated($property)
    {
        if ($property === 'activeSection') {
            // This will trigger the URL update
            $this->skipRender();
        }
    }

    public function render()
    {
        return view('livewire.vendor-profile')->layout('layouts.vendor');
    }
}