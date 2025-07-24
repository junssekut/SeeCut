<div class="relative min-h-screen bg-black overflow-hidden">
    <!-- Background Image/Pattern -->
    <div class="absolute inset-0 bg-gradient-to-br from-black via-gray-900 to-black"></div>

    <!-- Back Button -->
    <div class="absolute top-6 left-8 md:left-16 lg:left-48 z-30">
        <button onclick="history.back()"
            class="w-10 h-10 rounded-full bg-Ecru hover:bg-white transition-all duration-300 flex items-center justify-center shadow-lg">
            <svg width="14" height="28" viewBox="0 0 14 28" fill="none" xmlns="http://www.w3.org/2000/svg"
                class="w-4 h-6 text-gray-700">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M2.15016 13.1704L8.74999 6.57059L10.3997 8.22026L4.62466 13.9953L10.3997 19.7703L8.74999 21.4199L2.15016 14.8201C1.93144 14.6013 1.80857 14.3046 1.80857 13.9953C1.80857 13.6859 1.93144 13.3892 2.15016 13.1704Z"
                    fill="#6B592E" />
            </svg>
        </button>
    </div>

    <!-- Vendor Warning -->
    @if ($showVendorWarning)
        <div class="relative z-20 pt-20 pb-20">
            <div class="container mx-auto px-8 md:px-16 lg:px-48">
                <div class="max-w-4xl mx-auto text-center">
                    <!-- Warning Icon -->
                    <div class="mb-8">
                        <div class="w-24 h-24 mx-auto bg-blue-500/20 rounded-full flex items-center justify-center">
                            <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <h1 class="font-Kuunari text-4xl md:text-5xl text-Ecru mb-6">
                        AKSES KHUSUS VENDOR
                    </h1>

                    <p class="font-poppins text-xl text-Seasalt mb-8 leading-relaxed max-w-2xl mx-auto">
                        Anda sudah terdaftar sebagai vendor. Untuk mengelola langganan bisnis Anda, silakan gunakan
                        halaman khusus vendor.
                    </p>

                    <div class="space-y-4">
                        <a href="{{ route('vendor.extend') }}"
                            class="inline-block bg-Satin-Sheen-Yellow text-Taupe px-8 py-4 rounded-xl font-Kuunari text-xl font-bold
                                   hover:bg-yellow-400 transition-all duration-300 transform hover:scale-105 shadow-lg">
                            KELOLA LANGGANAN VENDOR
                        </a>

                        <div class="text-gray-400">
                            <p class="text-sm">atau</p>
                        </div>

                        <a href="{{ route('home') }}"
                            class="inline-block border border-Seasalt text-Seasalt px-6 py-3 rounded-xl font-Kuunari text-lg
                                   hover:bg-Seasalt hover:text-black transition-all duration-300">
                            KEMBALI KE BERANDA
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Main Content -->
        <div class="relative z-20 pt-20 pb-20">
            <div class="container mx-auto px-8 md:px-16 lg:px-48">

                <!-- Header Section -->
                <div class="text-center mb-16">
                    <h1 class="font-Kuunari text-5xl md:text-6xl text-Ecru mb-6 leading-tight">
                        BISNIS BARBERSHOP KAMU, LEVEL-UP SEKARANG.
                    </h1>
                    <p class="font-poppins text-xl text-Seasalt max-w-4xl mx-auto leading-relaxed">
                        Kamu punya usaha barbershop dan mau tampil lebih profesional? Pakai fitur Seecut: dari sistem
                        booking otomatis, halaman profil digital, sampai laporan harian—semua langsung dari satu tempat.
                        Kelola bisnismu tanpa ribet!
                    </p>
                </div>

                <!-- Current Subscription Status -->
                @if ($currentSubscription)
                    <div class="max-w-4xl mx-auto mb-12">
                        <div class="bg-green-500/10 border border-green-500/30 rounded-2xl p-6 backdrop-blur-lg">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg class="w-8 h-8 text-green-400 mr-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <div>
                                        <h3 class="text-green-300 font-semibold text-lg">Langganan Aktif</h3>
                                        <p class="text-green-200">{{ $currentSubscription->subscription->name }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-green-200 font-semibold">Berlaku sampai</p>
                                    <p class="text-xl font-bold text-green-300">
                                        {{ \Carbon\Carbon::parse($currentSubscription->end_date)->format('d M Y') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Subscription Plans -->
                <div class="flex flex-col lg:flex-row justify-center items-stretch gap-8 mb-16">
                    @foreach ($plans as $plan)
                        <div class="w-full lg:w-1/3 max-w-sm mx-auto">
                            <div
                                class="bg-Eerie-Black rounded-2xl overflow-hidden h-full
                                    transition-all duration-300 transform hover:-translate-y-2 hover:scale-105 hover:shadow-2xl group relative">

                                <!-- Top accent line -->
                                <div
                                    class="h-1 bg-Ecru w-full transition-all duration-300 group-hover:bg-Satin-Sheen-Yellow">
                                </div>

                                <!-- Card content -->
                                <div class="p-8 flex flex-col h-full">
                                    <div class="text-center mb-8">
                                        <h3 class="font-Kuunari text-white text-xl mb-4">{{ strtoupper($plan['name']) }}
                                        </h3>
                                        <div class="text-8xl font-Kuunari text-Satin-Sheen-Yellow mb-4 text-shadow-up">
                                            {{ $plan['formatted_price'] }}
                                        </div>
                                    </div>

                                    <div class="flex-grow">
                                        <div class="space-y-4 text-center mb-8">
                                            <p class="text-white font-medium">{{ $plan['duration_text'] }}</p>
                                            @foreach ($plan['features'] as $feature)
                                                <p class="text-white">{{ $feature }}</p>
                                            @endforeach
                                        </div>
                                    </div>

                                    <button wire:click="selectPlan({{ $plan['id'] }})"
                                        class="w-full py-4 bg-Satin-Sheen-Yellow text-Taupe rounded-lg font-Kuunari text-xl font-bold
                                           hover:bg-yellow-400 transition-all duration-300 transform hover:scale-105 shadow-lg">
                                        LANGGANAN SEKARANG
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Footer CTA -->
                <div class="text-center">
                    <h2 class="font-Kuunari text-4xl text-Ecru mb-8">
                        TUNGGU APALAGI, LANGGANAN SEKARANG!
                    </h2>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="absolute bottom-0 left-0 right-0 bg-black border-t border-gray-800">
            <div class="container mx-auto px-8 md:px-16 lg:px-48 py-8">
                <div class="flex flex-col md:flex-row justify-between items-start">
                    <!-- Logo and Description -->
                    <div class="mb-8 md:mb-0 md:w-1/2">
                        <div class="mb-4">
                            <img class="w-24" src="{{ asset('assets/images/logo-text.png') }}" alt="SeeCut">
                        </div>
                        <p class="text-gray-400 text-sm leading-relaxed max-w-md">
                            Bangun barbershop profesional lebih mudah bersama Seecut. Platform lengkap yang kamu
                            perlukan
                            untuk mengembangkan layanan digital dan tingkatkan pelanggan dari satu tempat.
                        </p>
                        <p class="text-gray-500 text-xs mt-4">© 2025 Seecut. All rights reserved.</p>
                    </div>

                    <!-- Links -->
                    <div class="md:w-1/2 md:text-right">
                        <div class="space-y-2">
                            <p class="text-Ecru font-semibold text-sm uppercase tracking-wide">SUBSCRIBE</p>
                            <p class="text-Ecru font-semibold text-sm uppercase tracking-wide">FIND BARBERSHOP</p>
                            <p class="text-Ecru font-semibold text-sm uppercase tracking-wide">AI RECOMMENDATION</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Payment Modal -->
    @if ($showPaymentModal && $selectedPlan)
        <div class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50">
            <div class="bg-white rounded-2xl shadow-2xl w-[95%] max-w-lg transform transition-all duration-300">
                <!-- Header -->
                <div class="bg-gradient-to-r from-Eerie-Black to-gray-800 rounded-t-2xl px-6 py-4 text-center">
                    <h2 class="text-2xl font-bold text-white font-Kuunari">KONFIRMASI LANGGANAN</h2>
                    <p class="text-gray-300 font-poppins mt-1">{{ $selectedPlan['name'] }}</p>
                </div>

                <div class="p-6">
                    <!-- Plan Details -->
                    <div class="text-center mb-6">
                        <div class="text-5xl font-Kuunari text-Satin-Sheen-Yellow mb-2">
                            {{ $selectedPlan['formatted_price'] }}
                        </div>
                        <p class="text-gray-600">{{ $selectedPlan['duration_text'] }}</p>
                    </div>

                    <!-- Features -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-lg mb-3 text-gray-800">Fitur yang didapat:</h3>
                        <div class="space-y-2">
                            @foreach ($selectedPlan['features'] as $feature)
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-gray-700">{{ $feature }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Total -->
                    <div
                        class="border-t border-b border-gray-200 py-3 mb-6 flex justify-between text-lg font-bold text-gray-800">
                        <span>TOTAL</span>
                        <span>Rp {{ number_format($selectedPlan['price'], 0, ',', '.') }}</span>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3">
                        <button wire:click="closeModal"
                            class="flex-1 py-3 border border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition-colors duration-300">
                            Batal
                        </button>
                        <button wire:click="confirmSubscription"
                            class="flex-1 py-3 bg-Satin-Sheen-Yellow text-Taupe rounded-xl font-semibold hover:bg-yellow-400 transition-colors duration-300 {{ $isProcessing ? 'opacity-50 cursor-not-allowed' : '' }}"
                            {{ $isProcessing ? 'disabled' : '' }}>
                            @if ($isProcessing)
                                <span class="flex items-center justify-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-Taupe"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Memproses...
                                </span>
                            @else
                                Konfirmasi Langganan
                            @endif
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('styles')
    <style>
        .text-shadow-up {
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #1f2937;
        }

        ::-webkit-scrollbar-thumb {
            background: #374151;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #4b5563;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Close modal on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    @this.call('closeModal');
                }
            });
        });

        // Listen for notifications
        document.addEventListener('livewire:init', () => {
            Livewire.on('show-notification', (event) => {
                const data = event[0] || event;
                if (typeof notyf !== 'undefined') {
                    if (data.type === 'success') {
                        notyf.success(data.message);
                    } else if (data.type === 'error') {
                        notyf.error(data.message);
                    }
                }
            });
        });
    </script>
@endpush
