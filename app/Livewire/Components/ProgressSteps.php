<?php

namespace App\Livewire\Components;

use Livewire\Component;

class ProgressSteps extends Component
{
    public $currentStep;
    public $progressPercentage;
    public $progressStatus;
    
    protected $listeners = ['updateProgress' => 'updateProgress'];
    
    public $steps = [
        1 => [
            'id' => 'step-1',
            'title' => 'Memvalidasi gambar',
            'stepNames' => ['validation', 'started', 'upload']
        ],
        2 => [
            'id' => 'step-2', 
            'title' => 'Menganalisis wajah',
            'stepNames' => ['analysis', 'face_analysis']
        ],
        3 => [
            'id' => 'step-3',
            'title' => 'Membuat rekomendasi', 
            'stepNames' => ['generating_recommendations', 'recommendations']
        ],
        4 => [
            'id' => 'step-4',
            'title' => 'Membuat pratinjau',
            'stepNames' => ['image_generation_1', 'generation', 'image_generation', 'image_generation_2', 'image_generation_3', 'image_generation_4']
        ],
        5 => [
            'id' => 'step-5',
            'title' => 'Menyelesaikan',
            'stepNames' => ['finalizing', 'complete']
        ]
    ];

    public function mount($currentStep = '', $progressPercentage = 0, $progressStatus = '')
    {
        $this->currentStep = $currentStep;
        $this->progressPercentage = $progressPercentage;
        $this->progressStatus = $progressStatus;
    }

    public function updateProgress($currentStep, $progressPercentage, $progressStatus)
    {
        $this->currentStep = $currentStep;
        $this->progressPercentage = $progressPercentage;
        $this->progressStatus = $progressStatus;
    }

    public function getCurrentStepNumber()
    {
        if ($this->currentStep === 'error') {
            return 0;
        }

        foreach ($this->steps as $stepNumber => $stepData) {
            if (in_array($this->currentStep, $stepData['stepNames'])) {
                return $stepNumber;
            }
        }

        return 1; // Default to step 1
    }

    public function getStepState($stepNumber)
    {
        $currentStepNumber = $this->getCurrentStepNumber();
        
        if ($stepNumber < $currentStepNumber) {
            return 'completed';
        } elseif ($stepNumber === $currentStepNumber) {
            return $this->currentStep === 'complete' ? 'completed' : 'current';
        } else {
            return 'future';
        }
    }

    public function render()
    {
        return view('livewire.components.progress-steps');
    }
}
