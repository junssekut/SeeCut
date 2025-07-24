<div class="space-y-3" id="progress-steps-container">
    @foreach ($steps as $stepNumber => $stepData)
        @php
            $stepState = $this->getStepState($stepNumber);

            // Define CSS classes based on step state
            $containerClasses =
                'flex items-center justify-center space-x-3 p-3 rounded-lg transition-all duration-500 ease-in-out min-h-[60px] ';
            $iconClasses = 'w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0 ';
            $textClasses = 'text-sm font-medium flex-1 text-center ';

            if ($stepState === 'completed') {
                $containerClasses .= 'opacity-100 bg-green-500/10 border border-green-500/20';
                $iconClasses .= 'bg-green-500';
                $textClasses .= 'text-white';
            } elseif ($stepState === 'current') {
                $containerClasses .=
                    'opacity-100 bg-gradient-to-r from-Ecru/20 to-yellow-500/20 border border-Ecru/50 shadow-lg shadow-Ecru/25';
                $iconClasses .= 'bg-Ecru';
                $textClasses .= 'text-white font-bold';
            } else {
                $containerClasses .= 'opacity-50';
                $iconClasses .= 'bg-gray-600';
                $textClasses .= 'text-gray-400';
            }
        @endphp

        <div id="{{ $stepData['id'] }}" class="{{ $containerClasses }}">
            <div id="{{ $stepData['id'] }}-icon" class="{{ $iconClasses }}">
                @if ($stepState === 'completed')
                    <!-- Checkmark for completed steps -->
                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                @elseif ($stepState === 'current')
                    <!-- Spinner for current step -->
                    <div class="w-2 h-2 border border-black border-t-transparent rounded-full animate-spin"></div>
                @else
                    <!-- Spinner for future steps -->
                    <div class="w-2 h-2 border border-white border-t-transparent rounded-full animate-spin"></div>
                @endif
            </div>

            <p id="{{ $stepData['id'] }}-text" class="{{ $textClasses }}">
                {{ $stepData['title'] }}
            </p>
        </div>
    @endforeach
</div>
