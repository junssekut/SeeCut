<div class="min-h-screen bg-gradient-to-br from-[#011C19] via-[#284123] to-[#011C19] relative overflow-hidden">
    <!-- Enhanced Background Animation -->
    <div class="absolute inset-0 animate-gradient-shift"></div>
    <div class="absolute inset-0 bg-overlay"></div>

    <!-- Floating Background Elements -->
    <div
        class="absolute top-20 left-20 w-64 h-64 bg-gradient-to-br from-green-400/20 to-emerald-600/20 rounded-full mix-blend-multiply filter blur-xl animate-float">
    </div>
    <div
        class="absolute top-40 right-32 w-80 h-80 bg-gradient-to-br from-teal-400/15 to-green-500/15 rounded-full mix-blend-multiply filter blur-xl animate-float-delayed">
    </div>
    <div
        class="absolute bottom-32 left-1/3 w-72 h-72 bg-gradient-to-br from-emerald-500/20 to-green-600/20 rounded-full mix-blend-multiply filter blur-xl animate-pulse-glow">
    </div>
    <div
        class="absolute bottom-20 right-20 w-56 h-56 bg-gradient-to-br from-green-300/25 to-teal-500/25 rounded-full mix-blend-multiply filter blur-xl animate-float">
    </div>

    <!-- Subtle geometric shapes -->
    <div class="absolute top-1/4 left-1/4 w-4 h-4 bg-green-400/30 rotate-45 animate-rotate-slow"></div>
    <div class="absolute top-3/4 right-1/4 w-6 h-6 bg-emerald-400/20 rotate-45 animate-rotate-slow"
        style="animation-delay: 10s;"></div>
    <div class="absolute top-1/2 left-3/4 w-3 h-3 bg-teal-400/40 rotate-45 animate-rotate-slow"
        style="animation-delay: 15s;"></div>

    <div class="relative z-10 container mx-auto px-4 py-8">
        <!-- Flash Messages -->
        @if (session()->has('success'))
            <div class="mb-6 bg-green-800 border border-green-600 rounded-xl p-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <p class="text-green-200 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="mb-6 bg-red-800 border border-red-600 rounded-xl p-4">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                    <p class="text-red-200 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Header -->
        <div class="text-center mb-12 animate-fade-in">
            <h1 class="text-5xl md:text-6xl font-bold text-[#D9D9D9] mb-4 font-Kuunari tracking-wide">
                PILIH PAKET LANGGANANMU
            </h1>
            <p class="text-xl text-green-200 font-light">Upgrade pengalaman bisnismu dengan fitur-fitur terdepan</p>
        </div>

        <!-- Current Subscription Status -->
        @if ($currentSubscription)
            <div class="mb-8 max-w-4xl mx-auto">
                <div class="bg-green-800 border border-green-600 rounded-xl p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg class="w-8 h-8 text-green-400 mr-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="text-xl font-bold text-green-200">Langganan Aktif</h3>
                                <p class="text-green-300">
                                    {{ $currentSubscription->subscription->name ?? 'Unknown Plan' }}</p>
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

        @if (!empty($plans))
            <!-- Current Subscription Warning -->
            @if ($currentSubscription)
                <div class="mb-6 max-w-4xl mx-auto">
                    <div class="bg-orange-800 border border-orange-600 rounded-xl p-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-orange-400 mr-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                                </path>
                            </svg>
                            <p class="text-orange-200 font-medium">
                                Catatan: Anda sudah memiliki langganan aktif. Jika melakukan pembelian, langganan baru
                                akan menggantikan yang lama.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
            <!-- Plan Selection -->
            <div class="flex flex-col lg:flex-row justify-center items-center gap-8 mb-12">
                @foreach ($plans as $key => $plan)
                    <div wire:click="selectPlan('{{ $key }}')"
                        class="plan-card cursor-pointer transform transition-all duration-300 hover:scale-105 {{ $selectedPlan === $key ? 'selected' : '' }}">
                        <div
                            class="bg-green-900 rounded-2xl p-8 text-center border border-green-600 hover:border-green-400 transition-all duration-300 min-h-[200px] w-72">
                            <h2
                                class="text-3xl font-bold mb-4 font-Kuunari {{ $selectedPlan === $key ? 'text-[#E9BF80]' : 'text-white' }} transition-colors duration-300">
                                {{ $plan['name'] }}
                            </h2>
                            <div class="text-5xl font-bold text-[#E9BF80] mb-2">{{ $plan['price'] }}</div>
                            <div class="text-lg text-gray-300 mb-4">{{ $plan['duration'] }}</div>
                            <div class="space-y-2">
                                @foreach ($plan['features'] as $feature)
                                    <div class="text-sm text-gray-300 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-green-400 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        {{ $feature }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if ($this->selectedPlanData)
                <!-- Selected Plan Details -->
                <div class="w-full flex items-center justify-center mb-8" wire:key="selected-plan-{{ $selectedPlan }}">
                    <div
                        class="selected-plan-content bg-green-900 rounded-3xl shadow-2xl px-12 py-8 border border-green-600 max-w-2xl w-full transform hover:shadow-3xl">
                        <div
                            class="flex flex-col md:flex-row items-center justify-between space-y-6 md:space-y-0 md:space-x-8">
                            <!-- Price -->
                            <div class="text-center md:text-left">
                                <div class="text-8xl font-bold text-[#E9BF80] font-Kuunari mb-2">
                                    {{ $this->selectedPlanData['price'] ?? 'N/A' }}
                                </div>
                                <div class="text-sm text-gray-400">per
                                    {{ $this->selectedPlanData['duration'] ?? 'N/A' }}
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="text-center md:text-left">
                                <h2 class="text-3xl font-bold text-white mb-2 font-poppins">
                                    {{ $this->selectedPlanData['duration'] ?? 'N/A' }}</h2>
                                <div class="space-y-2">
                                    @if (isset($this->selectedPlanData['features']) && is_array($this->selectedPlanData['features']))
                                        @foreach ($this->selectedPlanData['features'] as $feature)
                                            <div
                                                class="text-gray-200 flex items-center {{ $loop->first ? '' : 'text-sm' }}">
                                                <svg class="w-4 h-4 text-green-400 mr-2" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                {{ $feature }}
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- No Subscription Selected -->
                <div class="w-full flex items-center justify-center mb-8" wire:key="no-plan-selected">
                    <div
                        class="selected-plan-content bg-red-900 rounded-3xl shadow-2xl px-12 py-8 border border-red-600 max-w-2xl w-full transform hover:shadow-3xl">
                        <div class="text-center">
                            <!-- Warning Icon -->
                            <div class="mb-6">
                                <svg class="w-16 h-16 mx-auto text-red-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                                    </path>
                                </svg>
                            </div>

                            <h2 class="text-4xl font-bold text-red-400 mb-4 font-Kuunari">No Subscription Bought</h2>
                            <p class="text-lg text-red-300 font-poppins">
                                Silakan pilih salah satu paket berlangganan yang tersedia di atas
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Payment Button -->
            <div class="flex justify-center">
                <button wire:click="showPayment"
                    class="bg-[#06261E] hover:bg-[#284123] text-white font-bold font-Kuunari text-xl px-12 py-4 rounded-xl shadow-lg hover:shadow-xl transform transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-4 focus:ring-green-500/50">
                    <span class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                            </path>
                        </svg>
                        PEMBAYARAN
                    </span>
                </button>
            </div>
        @else
            <!-- No Plans Available -->
            <div class="text-center py-12">
                <div class="text-gray-400 text-xl mb-4">
                    <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Tidak ada paket berlangganan yang tersedia
                </div>
                <p class="text-gray-500">Silakan hubungi administrator untuk informasi lebih lanjut</p>
            </div>
        @endif
    </div>

    <!-- Payment Overlay -->
    <div
        class="fixed inset-0 bg-black/70 flex items-center justify-center z-50 transition-all duration-300 {{ $showPaymentOverlay ? 'opacity-100 visible' : 'opacity-0 invisible' }}">
        <div
            class="bg-white rounded-3xl shadow-2xl w-[95%] max-w-lg transform transition-all duration-300 {{ $showPaymentOverlay ? 'scale-100 translate-y-0' : 'scale-95 translate-y-4' }}">

            @if ($this->selectedPlanData)
                <!-- Header -->
                <div class="bg-gradient-to-r from-[#06261E] to-[#284123] rounded-t-3xl px-6 py-4 text-center">
                    <h2 class="text-3xl font-bold text-white font-Kuunari">PEMBELIAN PAKET</h2>
                    <p class="text-green-100 font-poppins mt-1">Segera Lakukan Pembayaran</p>
                </div>

                <div class="p-6">
                    <!-- Plan & Duration -->
                    <div class="flex justify-center gap-3 mb-6">
                        <div
                            class="bg-gradient-to-r from-[#06261E] to-[#284123] text-white font-bold text-sm px-4 py-2 rounded-xl font-Kuunari shadow-lg">
                            {{ $this->selectedPlanData['name'] ?? 'N/A' }}
                        </div>
                        <div
                            class="bg-gradient-to-r from-[#E9BF80] to-[#D4A574] text-white font-bold text-sm px-4 py-2 rounded-xl font-Kuunari shadow-lg">
                            {{ $this->selectedPlanData['duration'] ?? 'N/A' }}
                        </div>
                    </div>

                    <!-- VA Info -->
                    <div class="text-center mb-6 p-4 bg-gray-50 rounded-xl">
                        <div class="text-gray-600 font-poppins text-sm mb-2">No. BCA Virtual Account:</div>
                        <div class="font-bold text-xl text-gray-800 font-mono tracking-wider mb-1">1902085887306306
                        </div>
                        <div class="text-gray-600 text-sm">a.n Seecut</div>
                    </div>

                    <!-- Detail Pemesanan -->
                    <div class="mb-6">
                        <h3 class="font-semibold text-lg mb-3 text-gray-800">Detail Pemesanan</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between py-2">
                                <span class="text-gray-600">Harga Paket</span>
                                <span
                                    class="font-semibold text-gray-800">{{ number_format($this->selectedPlanData['rawPrice'] ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between py-2">
                                <span class="text-gray-600">Diskon</span>
                                <span class="text-gray-800">0</span>
                            </div>
                        </div>
                    </div>

                    <!-- Total -->
                    <div
                        class="border-t border-b border-gray-200 py-3 mb-6 flex justify-between text-lg font-bold text-gray-800">
                        <span>TOTAL</span>
                        <span
                            class="text-[#284123]">{{ number_format($this->selectedPlanData['rawPrice'] ?? 0, 0, ',', '.') }}</span>
                    </div>

                    <!-- Deadline Transfer -->
                    <div class="text-center mb-6 p-4 bg-red-50 rounded-xl border border-red-200">
                        <div class="text-red-600 font-semibold mb-1">Transfer Sebelum</div>
                        <div class="text-red-800 font-bold">Pukul {{ $this->formattedPaymentTime }} WIB</div>
                        <div class="text-red-700">{{ $this->formattedPaymentDate }}</div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3">
                        <button wire:click="hidePayment" {{ $isProcessing ? 'disabled' : '' }}
                            class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 {{ $isProcessing ? 'opacity-50 cursor-not-allowed' : '' }}">
                            Batal
                        </button>
                        <button wire:click="confirmSubscription" {{ $isProcessing ? 'disabled' : '' }}
                            class="flex-1 bg-gradient-to-r from-[#06261E] to-[#284123] hover:from-[#284123] hover:to-[#06261E] text-white font-bold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg {{ $isProcessing ? 'opacity-50 cursor-not-allowed' : '' }}">
                            @if ($isProcessing)
                                <div class="flex items-center justify-center">
                                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Memproses...
                                </div>
                            @else
                                Konfirmasi
                            @endif
                        </button>
                    </div>
                </div>
            @else
                <!-- No Subscription Modal -->
                <div class="bg-gradient-to-r from-red-600 to-red-700 rounded-t-3xl px-6 py-4 text-center">
                    <h2 class="text-3xl font-bold text-white font-Kuunari">NO SUBSCRIPTION</h2>
                    <p class="text-red-100 font-poppins mt-1">Pilih paket terlebih dahulu</p>
                </div>

                <div class="p-8 text-center">
                    <!-- Warning Icon -->
                    <div class="mb-6">
                        <svg class="w-20 h-20 mx-auto text-red-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                            </path>
                        </svg>
                    </div>

                    <h3 class="text-2xl font-bold text-gray-800 mb-4 font-Kuunari">Tidak Ada Paket Dipilih</h3>
                    <p class="text-gray-600 text-lg mb-6 font-poppins">
                        Silakan pilih salah satu paket berlangganan yang tersedia sebelum melakukan pembayaran.
                    </p>

                    <!-- Close Button -->
                    <button wire:click="hidePayment"
                        class="bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-bold py-3 px-8 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg font-Kuunari">
                        Tutup
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
    <style>
        /* Custom Notyf styles for wider notifications */
        .notyf__toast {
            max-width: 500px !important;
            /* Increased from default ~320px */
            min-width: 300px !important;
        }

        .notyf__wrapper {
            padding: 16px 20px !important;
            /* More padding for better text spacing */
        }

        .notyf__message {
            word-wrap: break-word !important;
            white-space: normal !important;
            line-height: 1.4 !important;
        }

        /* For mobile devices */
        @media (max-width: 640px) {
            .notyf__toast {
                max-width: calc(100vw - 40px) !important;
                margin: 0 20px !important;
            }
        }

        @keyframes gradient-shift {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes float {
            0% {
                transform: translateY(0px) rotate(0deg);
            }

            33% {
                transform: translateY(-20px) rotate(5deg);
            }

            66% {
                transform: translateY(10px) rotate(-3deg);
            }

            100% {
                transform: translateY(0px) rotate(0deg);
            }
        }

        @keyframes pulse-glow {

            0%,
            100% {
                opacity: 0.3;
                transform: scale(1);
            }

            50% {
                opacity: 0.6;
                transform: scale(1.1);
            }
        }

        @keyframes content-change {
            0% {
                opacity: 0;
                transform: translateY(20px) scale(0.95);
            }

            100% {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes slide-in-up {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes plan-selection-pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.4);
            }

            50% {
                box-shadow: 0 0 0 10px rgba(34, 197, 94, 0.1);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0);
            }
        }

        .animate-content-change {
            animation: content-change 0.5s ease-out forwards;
        }

        .animate-slide-in-up {
            animation: slide-in-up 0.4s ease-out forwards;
        }

        .selected-plan-content {
            animation: slide-in-up 0.6s ease-out forwards;
        }

        .plan-card.selected {
            animation: plan-selection-pulse 0.6s ease-out;
        }

        /* Enhanced content transition */
        .selected-plan-content>div {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .selected-plan-content .text-8xl {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .selected-plan-content .space-y-2>div {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .selected-plan-content .space-y-2>div:nth-child(1) {
            transition-delay: 0.1s;
        }

        .selected-plan-content .space-y-2>div:nth-child(2) {
            transition-delay: 0.2s;
        }

        .selected-plan-content .space-y-2>div:nth-child(3) {
            transition-delay: 0.3s;
        }

        .selected-plan-content .space-y-2>div:nth-child(4) {
            transition-delay: 0.4s;
        }

        @keyframes rotate-slow {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .animate-gradient-shift {
            background: linear-gradient(-45deg, #011C19, #284123, #1a4d3a, #0f2d24, #011C19);
            background-size: 400% 400%;
            animation: gradient-shift 8s ease infinite;
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-float-delayed {
            animation: float 8s ease-in-out infinite reverse;
        }

        .animate-pulse-glow {
            animation: pulse-glow 4s ease-in-out infinite;
        }

        .animate-rotate-slow {
            animation: rotate-slow 20s linear infinite;
        }

        .animate-fade-in {
            animation: fade-in 0.8s ease-out;
        }

        .plan-card.selected {
            transform: scale(1.05);
        }

        .plan-card.selected>div {
            border-color: rgba(34, 197, 94, 0.8);
            background: rgb(20, 83, 45);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .shadow-3xl {
            box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.3);
        }

        /* Smooth plan selection transition */
        .plan-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .plan-card:hover {
            transform: translateY(-5px);
        }

        .plan-card.selected:hover {
            transform: scale(1.05) translateY(-5px);
        }

        /* Enhanced background effects */
        .bg-overlay {
            background: radial-gradient(circle at 20% 50%, rgba(34, 197, 94, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(16, 185, 129, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(5, 150, 105, 0.1) 0%, transparent 50%);
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Simple fade-in animation for plan cards
            const planCards = document.querySelectorAll('.plan-card');
            planCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 200);
            });

            // Close overlay on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    @this.call('hidePayment');
                }
            });
        });
    </script>
@endpush
