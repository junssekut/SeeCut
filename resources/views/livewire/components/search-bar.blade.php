<div
    class="relative z-20 bg-Eerie-Black p-6 md:p-8 md:py-6 rounded-lg shadow-lg font-sans w-full border-t-8 border-t-Ecru">

    {{-- Custom CSS for enhanced animations --}}
    <style>
        @keyframes pulse-glow {

            0%,
            100% {
                box-shadow: 0 0 0 0 rgba(251, 191, 36, 0.4);
                transform: scale(1);
            }

            50% {
                box-shadow: 0 0 0 10px rgba(251, 191, 36, 0);
                transform: scale(1.02);
            }
        }

        @keyframes bounce-dots {

            0%,
            80%,
            100% {
                transform: translateY(0);
                opacity: 0.5;
            }

            40% {
                transform: translateY(-8px);
                opacity: 1;
            }
        }

        @keyframes progress-bar {
            0% {
                width: 0%;
            }

            50% {
                width: 70%;
            }

            100% {
                width: 100%;
            }
        }

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .loading-button {
            animation: pulse-glow 2s infinite;
        }

        .bounce-dot {
            animation: bounce-dots 1.6s infinite ease-in-out both;
        }

        .bounce-dot:nth-child(1) {
            animation-delay: -0.32s;
        }

        .bounce-dot:nth-child(2) {
            animation-delay: -0.16s;
        }

        .bounce-dot:nth-child(3) {
            animation-delay: 0s;
        }

        .progress-bar {
            animation: progress-bar 1.5s ease-in-out infinite;
        }

        .fade-in {
            animation: fade-in 0.3s ease-out;
        }

        .loading-text {
            background: linear-gradient(90deg, #2d3748, #4a5568, #2d3748);
            background-size: 200% 100%;
            animation: shimmer 1.5s ease-in-out infinite;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }
    </style>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-end">

        {{-- Location Input --}}
        <div class="space-y-2">
            <label for="lokasi"
                class="block text-xl font-medium font-Kuunari text-Seasalt uppercase tracking-wider">LOKASI</label>
            <select wire:model.live="lokasi" id="lokasi" name="lokasi"
                class="block w-full bg-Charcoal border-none text-Dark-Charcoal placeholder-Dark-Charcoal rounded-md shadow-sm py-3 px-4 focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                @foreach ($lokasiOptions as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        {{-- Service Input --}}
        <div class="space-y-2">
            <label for="layanan"
                class="block text-xl font-medium font-Kuunari text-Seasalt uppercase tracking-wider">LAYANAN</label>
            <select wire:model.live="layanan" id="layanan" name="layanan"
                class="block w-full bg-Charcoal border-none text-Dark-Charcoal placeholder-Dark-Charcoal rounded-md shadow-sm py-3 px-4 focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                @foreach ($layananOptions as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        {{-- Price Input --}}
        <div class="space-y-2">
            <label for="harga"
                class="block text-xl font-medium font-Kuunari text-Seasalt uppercase tracking-wider">HARGA</label>
            <div class="flex flex-col items-center">
                <input wire:model.live="harga" id="harga" name="harga" type="range" min="0"
                    max="{{ $maxHarga }}" step="10000"
                    class="w-full h-2 bg-neutral-700 rounded-lg appearance-none cursor-pointer accent-amber-500">
                <span class="mt-2 text-sm text-Seasalt">
                    Rp {{ number_format($harga, 0, ',', '.') }} - Rp {{ number_format($maxHarga, 0, ',', '.') }}
                </span>
            </div>
        </div>

        {{-- Search Button --}}
        <div class="flex items-end">
            <button wire:click="search" type="button" wire:loading.attr="disabled" wire:loading.class="loading-button"
                class="relative text-lg w-full bg-Ecru hover:bg-Dun disabled:bg-opacity-80 disabled:cursor-not-allowed text-Dark-Charcoal-2 font-Kuunari font-semibold py-3 px-6 rounded-md shadow-sm transition-all duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-neutral-800 focus:ring-amber-400 overflow-hidden">

                {{-- Progress bar background --}}
                <div wire:loading wire:target="search"
                    class="absolute bottom-0 left-0 h-1 bg-Dark-Charcoal-2 rounded-b-md progress-bar opacity-30"></div>

                {{-- Button text - visible when not loading --}}
                <span wire:loading.remove wire:target="search" class="transition-all duration-300">
                    CARI BARBERSHOP
                </span>

                {{-- Loading state with enhanced animation --}}
                <div wire:loading wire:target="search" class="flex items-center justify-center space-x-3 fade-in">
                    {{-- Animated dots --}}
                    <div class="flex space-x-1">
                        <div class="w-2.5 h-2.5 bg-Dark-Charcoal-2 rounded-full bounce-dot"></div>
                        <div class="w-2.5 h-2.5 bg-Dark-Charcoal-2 rounded-full bounce-dot"></div>
                        <div class="w-2.5 h-2.5 bg-Dark-Charcoal-2 rounded-full bounce-dot"></div>
                    </div>

                    {{-- Loading text with shimmer effect --}}
                    <span class="text-Dark-Charcoal-2 font-semibold">
                        Mencari Barbershop...
                    </span>
                </div>
            </button>
        </div>
    </div>

    {{-- Optional: Display selected values for debugging --}}
    {{--
    <div class="mt-6 p-4 bg-neutral-700 rounded text-white text-xs">
        <p>Debug:</p>
        <p>Lokasi: {{ $lokasi ?: 'Tidak dipilih' }}</p>
        <p>Layanan: {{ $layanan ?: 'Tidak dipilih' }}</p>
        <p>Harga Maksimal: Rp {{ number_format($harga, 0, ',', '.') }}</p>
    </div>
    --}}
</div>
