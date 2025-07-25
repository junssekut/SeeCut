<div class="relative min-h-screen overflow-x-hidden">
    <!-- Background Image -->
    <div class="absolute inset-0 z-0 bg-center bg-contain bg-no-repeat opacity-10"
        style="background-image: url('{{ asset('assets/images/wave.png') }}');">
    </div>

    <div class="relative flex flex-col px-4 sm:px-6 md:px-16 lg:px-48 max-w-full">
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

        {{-- Success/Error Messages --}}
        @if (session()->has('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex flex-col xl:flex-row justify-between items-start gap-8 lg:gap-12">
            {{-- Left Section --}}
            <div class="w-full xl:w-1/2 flex-shrink-0">
                <div class="mb-6">
                    <h1 class="text-3xl md:text-4xl lg:text-5xl xl:text-6xl uppercase font-Kuunari text-Ecru mb-6">
                        pilih slot
                    </h1>
                    
                    <form wire:submit="submitBooking" class="space-y-6">
                        {{-- Date Selection --}}
                        <div class="space-y-3">
                            <label class="block text-lg md:text-xl font-Poppins font-medium text-Seasalt">
                                Pilih Tanggal 
                                <span class="text-Seasalt/20">- Juli 2025 <span class="text-red-500">*</span></span>
                            </label>
                            <div class="flex items-center gap-3 overflow-x-auto pb-2 font-Poppins">
                                @foreach($availableDates as $date)
                                    <div wire:click="selectDate('{{ $date['date'] }}')"
                                        class="text-center p-3 border rounded-lg cursor-pointer flex-shrink-0 w-16 transition-all duration-200
                                        @if($date['disabled'])
                                            bg-transparent border-Seasalt/5 text-Seasalt/50 cursor-not-allowed
                                        @elseif($selectedDate === $date['date'])
                                            bg-Satin-Sheen-Yellow border-Satin-Sheen-Yellow text-Eerie-Black
                                        @else
                                            bg-transparent border-Satin-Sheen-Yellow text-Seasalt hover:bg-Satin-Sheen-Yellow hover:text-Eerie-Black
                                        @endif">
                                        <p class="font-light uppercase text-xs">{{ $date['display_day'] }}</p>
                                        <p class="font-bold text-lg">{{ $date['display_date'] }}</p>
                                    </div>
                                @endforeach
                            </div>
                            @error('selectedDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Time Selection --}}
                        <div class="space-y-3">
                            <label class="block text-lg md:text-xl font-Poppins font-medium text-Seasalt">
                                Pilih Waktu<span class="text-red-500">*</span>
                            </label>
                            <div class="font-Poppins font-medium text-Seasalt">
                                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 text-sm">
                                    @foreach($availableTimeSlots as $slot)
                                        <button type="button" 
                                            wire:click="selectTime('{{ $slot['time'] }}', '{{ $slot['id'] }}')"
                                            @class([
                                                'text-center p-3 border rounded-lg transition-all duration-200',
                                                'bg-Satin-Sheen-Yellow text-Eerie-Black border-Satin-Sheen-Yellow' => $selectedTime === $slot['time'],
                                                'bg-transparent text-Seasalt border-Satin-Sheen-Yellow hover:bg-Satin-Sheen-Yellow hover:text-Eerie-Black' => $selectedTime !== $slot['time'] && $slot['available'],
                                                'cursor-not-allowed bg-transparent border-Seasalt/5 text-Seasalt/50' => !$slot['available'],
                                                'cursor-pointer' => $slot['available']
                                            ])
                                            @disabled(!$slot['available'])>
                                            {{ $slot['time'] }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                            @error('selectedTime') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                                                'cursor-not-allowed border-Seasalt/5 text-Seasalt/50' => !$slot['available'],
                                                'cursor-pointer' => $slot['available']
                                            ])
                                            @disabled(!$slot['available'])>
                                            {{ $slot['time'] }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                            @error('selectedTime') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Service Selection --}}
                        <div>
                            <div class="mb-4">
                                <label class="block text-lg md:text-xl font-Poppins font-medium text-Seasalt">
                                    Layanan<span class="text-red-500 ml-1">*</span>
                                </label>
                            </div>
                            <div class="relative">
                                <select wire:model="service"
                                    class="custom-input appearance-none w-full p-4 pl-12 rounded-lg focus:outline-none focus:ring-2 focus:ring-Satin-Sheen-Yellow bg-Eerie-Black text-Seasalt border border-Satin-Sheen-Yellow">
                                    <option value="" disabled>Pilih layanan yang anda inginkan</option>
                                    @foreach($services as $serviceOption)
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
                            @error('service') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Customer Name --}}
                        <div>
                            <div class="mb-4">
                                <label class="block text-lg md:text-xl font-Poppins font-medium text-Seasalt">
                                    Nama Pelanggan<span class="text-red-500 ml-1">*</span>
                                </label>
                            </div>
                            <div class="relative">
                                <input type="text" wire:model="customerName" placeholder="Masukkan nama anda"
                                    class="custom-input w-full p-4 pl-12 rounded-lg focus:outline-none focus:ring-2 focus:ring-Satin-Sheen-Yellow bg-Eerie-Black text-Seasalt border border-Satin-Sheen-Yellow">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            @error('customerName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Phone Number --}}
                        <div>
                            <div class="mb-4">
                                <label class="block text-lg md:text-xl font-Poppins font-medium text-Seasalt">
                                    Phone Number<span class="text-red-500 ml-1">*</span>
                                </label>
                            </div>
                            <div class="relative">
                                <input type="tel" wire:model="customerPhone" placeholder="Masukkan nomor handphone anda"
                                    class="custom-input w-full p-4 pl-12 rounded-lg focus:outline-none focus:ring-2 focus:ring-Satin-Sheen-Yellow bg-Eerie-Black text-Seasalt border border-Satin-Sheen-Yellow">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 6.75z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            @error('customerPhone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        {{-- Email --}}
                        <div>
                            <div class="mb-4">
                                <label class="block text-lg md:text-xl font-Poppins font-medium text-Seasalt">
                                    Email<span class="text-red-500 ml-1">*</span>
                                </label>
                            </div>
                            <div class="relative">
                                <input type="email" wire:model="customerEmail" placeholder="Masukkan email anda"
                                    class="custom-input w-full p-4 pl-12 rounded-lg focus:outline-none focus:ring-2 focus:ring-Satin-Sheen-Yellow bg-Eerie-Black text-Seasalt border border-Satin-Sheen-Yellow">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                            @error('customerEmail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </form>
                </div>
            </div>
            {{-- Divider Line --}}
            <div class="hidden xl:flex gap-[2px] mx-4">
                <div class="w-[1px] bg-Ecru h-full min-h-[400px]"></div>
                <div class="w-[1px] bg-Ecru h-full min-h-[400px]"></div>
            </div>

            {{-- Right Section - Reservation Details --}}
            <div class="w-full xl:w-1/2 flex-shrink-0">
                <div class="mb-6 space-y-6">
                    <h1 class="text-3xl md:text-4xl lg:text-5xl xl:text-6xl uppercase font-Kuunari text-Ecru mb-6">
                        detail reservasi
                    </h1>
                    
                    <div class="border border-Ecru rounded-lg p-4 md:p-6 space-y-4 text-sm md:text-base bg-Eerie-Black/30">
                        <div class="flex justify-between items-center font-Poppins font-medium text-lg md:text-xl">
                            <span class="text-Seasalt/60">Tanggal</span>
                            <span class="text-Seasalt text-right">{{ $this->getFormattedSelectedDate() }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center font-Poppins font-medium text-lg md:text-xl">
                            <span class="text-Seasalt/60">Waktu</span>
                            <span class="text-Seasalt text-right">{{ $selectedTime ?: '-' }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center font-Poppins font-medium text-lg md:text-xl">
                            <span class="text-Seasalt/60">Layanan</span>
                            <span class="text-Seasalt text-right">{{ $service ?: '-' }}</span>
                        </div>
                        
                        <hr class="border-Field-Drab/50 my-4">
                        
                        <div class="flex justify-between items-center font-Poppins font-medium text-lg md:text-xl">
                            <span class="text-Seasalt/60">Nama</span>
                            <span class="text-Seasalt text-right">{{ $customerName ?: '-' }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center font-Poppins font-medium text-lg md:text-xl">
                            <span class="text-Seasalt/60">No. Handphone</span>
                            <span class="text-Seasalt text-right">{{ $customerPhone ?: '-' }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center font-Poppins font-medium text-lg md:text-xl">
                            <span class="text-Seasalt/60">Email</span>
                            <span class="text-Seasalt text-right truncate max-w-[150px]">{{ $customerEmail ?: '-' }}</span>
                        </div>
                    </div>
                    
                    <button type="submit" form="bookingForm" wire:click="submitBooking"
                        class="w-full mt-6 bg-Ecru text-Eerie-Black font-bold text-lg py-4 rounded-lg hover:bg-Dun transition-colors duration-300 uppercase tracking-wide shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                        wire:loading.attr="disabled"
                        wire:loading.class="opacity-50 cursor-not-allowed">
                        <span wire:loading.remove>reservasi sekarang</span>
                        <span wire:loading class="flex items-center justify-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-Eerie-Black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add custom styles for better responsive design --}}
@push('styles')
<style>
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    
    .custom-input {
        transition: all 0.3s ease;
    }
    
    .custom-input:focus {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    /* Better mobile responsiveness */
    @media (max-width: 768px) {
        .text-3xl {
            font-size: 2rem;
        }
        .text-4xl {
            font-size: 2.25rem;
        }
    }
</style>
@endpush
