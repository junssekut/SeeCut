<div class="relative min-h-screen overflow-x-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0 z-0 bg-center bg-contain bg-no-repeat opacity-10"
        style="background-image: url('{{ asset('assets/images/wave.png') }}');">
    </div>

    <div class="relative flex flex-col px-4 sm:px-6 md:px-12 lg:px-24 xl:px-48 max-w-full">
        {{-- Back Button --}}
        <div class="py-8 md:py-12">
            <button onclick="window.history.back()"
                class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-Ecru hover:bg-Seasalt transition-all duration-300 flex items-center justify-center shadow">
                <svg width="14" height="28" viewBox="0 0 14 28" fill="none" xmlns="http://www.w3.org/2000/svg"
                    class="w-4 md:w-6 h-6 text-gray-700">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M2.15016 13.1704L8.74999 6.57059L10.3997 8.22026L4.62466 13.9953L10.3997 19.7703L8.74999 21.4199L2.15016 14.8201C1.93144 14.6013 1.80857 14.3046 1.80857 13.9953C1.80857 13.6859 1.93144 13.3892 2.15016 13.1704Z"
                        fill="#6B592E" />
                </svg>
            </button>
        </div>

        {{-- Main Content Container --}}
        <div class="w-full max-w-7xl mx-auto">
            {{-- Vendor Information --}}
            @if ($vendor)
                <div class="mb-8 p-4 bg-Eerie-Black/50 border border-Ecru/30 rounded-lg">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-Ecru/20 rounded-lg flex items-center justify-center">
                            <svg class="w-8 h-8 text-Ecru" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-Kuunari text-Ecru uppercase">{{ $vendor->name }}</h2>
                            <p class="text-Seasalt/70 text-sm font-Poppins">
                                {{ $vendor->description ?? 'Professional Barbershop Services' }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
                {{-- Left Section: Pilih Slot --}}
                <div class="flex-1 lg:w-0 min-w-0">
                    <div class="mb-6">
                        <h1 class="text-3xl md:text-4xl lg:text-5xl uppercase font-Kuunari text-Ecru mb-6">pilih slot
                        </h1>

                        <form wire:submit.prevent="submitBooking" id="bookingForm" class="space-y-6">
                            {{-- Date Selection --}}
                            <div class="space-y-3">
                                <label class="block text-lg md:text-xl font-Poppins font-medium text-Seasalt">
                                    Pilih Tanggal
                                    <span class="text-Seasalt/20">- Juli 2025 <span class="text-red-500">*</span></span>
                                </label>
                                <div class="flex items-center gap-3 overflow-x-auto pb-2 font-Poppins">
                                    @foreach ($availableDates as $date)
                                        <button type="button" wire:click="selectDate('{{ $date['date'] }}')"
                                            @class([
                                                'text-center p-3 border rounded-lg flex-shrink-0 w-16 transition-all duration-200',
                                                'bg-Satin-Sheen-Yellow border-Satin-Sheen-Yellow text-Eerie-Black' =>
                                                    $selectedDate === $date['date'],
                                                'bg-transparent border-Satin-Sheen-Yellow text-Seasalt hover:bg-Satin-Sheen-Yellow hover:text-Eerie-Black' =>
                                                    $selectedDate !== $date['date'] && !$date['disabled'],
                                                'cursor-not-allowed bg-transparent border-Seasalt/5 text-Seasalt/50' =>
                                                    $date['disabled'],
                                            ]) @disabled($date['disabled'])>
                                            <p class="font-light uppercase text-xs">{{ $date['display_day'] }}</p>
                                            <p class="font-bold text-lg">{{ $date['display_date'] }}</p>
                                        </button>
                                    @endforeach
                                </div>
                                @error('selectedDate')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Time Selection --}}
                            <div class="space-y-3">
                                <label class="block text-lg md:text-xl font-Poppins font-medium text-Seasalt">
                                    Pilih Waktu<span class="text-red-500">*</span>
                                </label>
                                <div class="font-Poppins font-medium text-Seasalt">
                                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 text-sm">
                                        @foreach ($availableTimeSlots as $slot)
                                            <button type="button"
                                                wire:click="selectTime('{{ $slot['time'] }}', '{{ $slot['id'] }}')"
                                                @class([
                                                    'text-center p-3 border rounded-lg transition-all duration-200 relative overflow-hidden',
                                                    'bg-Satin-Sheen-Yellow text-Eerie-Black border-Satin-Sheen-Yellow shadow-lg transform scale-105' =>
                                                        $selectedTime === $slot['time'],
                                                    'bg-transparent text-Seasalt border-Satin-Sheen-Yellow hover:bg-Satin-Sheen-Yellow hover:text-Eerie-Black hover:shadow-md hover:transform hover:scale-102' =>
                                                        $selectedTime !== $slot['time'] && $slot['available'],
                                                    'cursor-not-allowed bg-gradient-to-br from-red-900/20 to-red-800/10 border-red-600/30 text-red-300/70' => !$slot[
                                                        'available'
                                                    ],
                                                ]) @disabled(!$slot['available'])>
                                                @if (!$slot['available'])
                                                    <!-- Booked slot styling -->
                                                    <div
                                                        class="absolute inset-0 bg-red-600/10 flex items-center justify-center">
                                                        <div
                                                            class="absolute inset-0 opacity-20 bg-[repeating-linear-gradient(45deg,transparent,transparent_8px,rgba(239,68,68,0.3)_8px,rgba(239,68,68,0.3)_16px)]">
                                                        </div>
                                                    </div>
                                                    <div class="relative z-10 flex flex-col items-center">
                                                        <span
                                                            class="text-xs font-medium text-red-400 mb-1">{{ $slot['time'] }}</span>
                                                        <span
                                                            class="text-xs bg-red-600/80 text-red-100 px-2 py-0.5 rounded-full font-bold">BOOKED</span>
                                                    </div>
                                                @else
                                                    <!-- Available slot -->
                                                    <span class="font-medium">{{ $slot['time'] }}</span>
                                                @endif
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                                @error('selectedTime')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Service Selection --}}
                            <div class="space-y-3">
                                <label class="block text-lg md:text-xl font-Poppins font-medium text-Seasalt">
                                    Layanan<span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select wire:model="service" wire:change="$refresh"
                                        class="appearance-none w-full p-4 pl-12 rounded-lg focus:outline-none focus:ring-2 focus:ring-Satin-Sheen-Yellow bg-Eerie-Black text-Seasalt border border-Satin-Sheen-Yellow">
                                        <option value="" disabled>Pilih layanan yang anda inginkan</option>
                                        @foreach ($services as $serviceOption)
                                            <option value="{{ $serviceOption }}">{{ $serviceOption }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.25 7.5l.415-.207a.75.75 0 011.085.67V10.5m0 0h6m-6 0v-1.5m0 1.5v3.375m6-3.375h-6m6 0v-1.5m0 1.5v3.375m0 0l-.415.207a.75.75 0 01-1.085-.67V13.5m11.25-8.25h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 21h15a2.25 2.25 0 002.25-2.25V7.5A2.25 2.25 0 0019.5 5.25z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                @error('service')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Customer Name --}}
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <label class="block text-lg md:text-xl font-Poppins font-medium text-Seasalt">
                                        Nama Pelanggan<span class="text-red-500">*</span>
                                    </label>
                                    @auth
                                        <button type="button" wire:click="fillUserInfo"
                                            class="text-xs text-Ecru hover:text-Satin-Sheen-Yellow transition-colors cursor-pointer font-Poppins">
                                            Gunakan informasi saya
                                        </button>
                                    @endauth
                                </div>
                                <div class="relative">
                                    <input type="text" wire:model="customerName" wire:blur="$refresh"
                                        placeholder="Masukkan nama anda"
                                        class="w-full p-4 pl-12 rounded-lg focus:outline-none focus:ring-2 focus:ring-Satin-Sheen-Yellow bg-Eerie-Black text-Seasalt border border-Satin-Sheen-Yellow">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                @error('customerName')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Phone Number --}}
                            <div class="space-y-3">
                                <label class="block text-lg md:text-xl font-Poppins font-medium text-Seasalt">
                                    Phone Number<span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="tel" wire:model="customerPhone" wire:blur="$refresh"
                                        placeholder="Masukkan nomor handphone anda"
                                        class="w-full p-4 pl-12 rounded-lg focus:outline-none focus:ring-2 focus:ring-Satin-Sheen-Yellow bg-Eerie-Black text-Seasalt border border-Satin-Sheen-Yellow">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 6.75z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                @error('customerPhone')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            {{-- Email --}}
                            <div class="space-y-3">
                                <label class="block text-lg md:text-xl font-Poppins font-medium text-Seasalt">
                                    Email<span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="email" wire:model="customerEmail" wire:blur="$refresh"
                                        placeholder="Masukkan email anda"
                                        class="w-full p-4 pl-12 rounded-lg focus:outline-none focus:ring-2 focus:ring-Satin-Sheen-Yellow bg-Eerie-Black text-Seasalt border border-Satin-Sheen-Yellow">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75">
                                            </path>
                                        </svg>
                                    </div>
                                </div>
                                @error('customerEmail')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Vertical Divider --}}
                {{-- Vertical Divider (Hidden on mobile, visible on lg+) --}}
                <div class="hidden lg:flex">
                    <div class="w-px bg-Ecru/30 min-h-full"></div>
                </div> {{-- Right Section: Detail Reservasi --}}
                <div class="w-full lg:w-80 xl:w-96 flex-shrink-0">
                    <div class="sticky top-8">
                        <h1 class="text-2xl md:text-3xl lg:text-4xl uppercase font-Kuunari text-Ecru mb-6">detail
                            reservasi</h1>

                        <div class="border border-Ecru rounded-lg p-4 space-y-3 text-sm mb-6">
                            <div class="flex justify-between items-center font-Poppins font-medium">
                                <span class="text-Seasalt/60 text-sm">Tanggal</span>
                                <span class="text-Seasalt text-sm font-semibold text-right">
                                    {{ $selectedDate ? \Carbon\Carbon::parse($selectedDate)->locale('id')->isoFormat('DD MMMM YYYY') : '-' }}
                                </span>
                            </div>
                            <div class="flex justify-between items-center font-Poppins font-medium">
                                <span class="text-Seasalt/60 text-sm">Waktu</span>
                                <span class="text-Seasalt text-sm font-semibold">{{ $selectedTime ?: '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center font-Poppins font-medium">
                                <span class="text-Seasalt/60 text-sm">Layanan</span>
                                <span class="text-Seasalt text-sm font-semibold text-right max-w-[60%] truncate"
                                    title="{{ $service }}">{{ $service ?: '-' }}</span>
                            </div>
                            <hr class="border-Seasalt/20 my-3">
                            <div class="flex justify-between items-center font-Poppins font-medium">
                                <span class="text-Seasalt/60 text-sm">Nama</span>
                                <span class="text-Seasalt text-sm font-semibold text-right max-w-[60%] truncate"
                                    title="{{ $customerName }}">{{ $customerName ?: '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center font-Poppins font-medium">
                                <span class="text-Seasalt/60 text-sm">No. HP</span>
                                <span class="text-Seasalt text-sm font-semibold">{{ $customerPhone ?: '-' }}</span>
                            </div>
                            <div class="flex justify-between items-center font-Poppins font-medium">
                                <span class="text-Seasalt/60 text-sm">Email</span>
                                <span class="text-Seasalt text-sm font-semibold text-right max-w-[60%] truncate"
                                    title="{{ $customerEmail }}">{{ $customerEmail ?: '-' }}</span>
                            </div>
                        </div>

                        <button type="submit" form="bookingForm" wire:loading.attr="disabled"
                            class="w-full bg-Ecru text-Taupe font-bold text-base py-3 rounded-lg hover:bg-Dun transition-colors uppercase disabled:opacity-50 disabled:cursor-not-allowed font-Poppins">
                            <span wire:loading.remove wire:target="submitBooking">Reservasi Sekarang</span>
                            <span wire:loading wire:target="submitBooking">Memproses...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .transform {
                transform: translateZ(0);
            }

            .scale-102 {
                transform: scale(1.02);
            }

            .scale-105 {
                transform: scale(1.05);
            }

            /* Improved booked slot animations */
            .booked-slot {
                position: relative;
                overflow: hidden;
            }

            .booked-slot::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(239, 68, 68, 0.1), transparent);
                animation: shimmer 3s infinite;
            }

            @keyframes shimmer {
                0% {
                    left: -100%;
                }

                100% {
                    left: 100%;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Listen for notification events from Livewire
            document.addEventListener('livewire:init', () => {
                Livewire.on('show-notification', (event) => {
                    const {
                        type,
                        message
                    } = event[0];
                    if (window.notyf) {
                        window.notyf.open({
                            type: type,
                            message: message
                        });
                    }
                });
            });
        </script>
    @endpush
