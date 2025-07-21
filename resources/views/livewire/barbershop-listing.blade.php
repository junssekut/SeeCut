<div class="min-h-screen bg-[#0C0C0C]">
    <!-- Header Section -->
    <div class="relative bg-landing bg-center bg-cover bg-no-repeat py-24">
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-[#0C0C0C] z-0"></div>

        <div class="relative z-10 container px-0 mx-auto">
            <!-- Search Bar -->
            <div class="flex flex-col items-center justify-center mb-8">
                <div class="w-full max-w-6xl">
                    <livewire:components.search-bar />
                </div>
            </div>
        </div>
    </div>

    <!-- Results Section -->
    <div class="container mx-auto px-24 py-16">
        <!-- Page Title -->
        <div class="text-center mb-12">
            <h1 class="text-5xl font-Kuunari text-Ecru mb-4">TERSEDIA RESERVASI</h1>
        </div>
        {{-- Barbershops Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            @forelse ($barbershops as $barbershop)
                @php
                    $hasActiveSubscription = $barbershop->vendorSubscriptions->count() > 0;
                @endphp

                <a href="{{ route('barbershop.view', $barbershop->id) }}"
                    class="flex flex-col bg-Eerie-Black rounded-lg overflow-hidden shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 cursor-pointer {{ $hasActiveSubscription ? 'border-t-4 border-Ecru' : '' }}">
                    <!-- Image -->
                    <div class="relative h-64">
                        @if ($barbershop->thumbnail_url)
                            <img src="{{ $barbershop->thumbnail_url }}" alt="{{ $barbershop->name }}"
                                class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-[#2A2A2A] flex items-center justify-center">
                                <span class="text-gray-500">No Image</span>
                            </div>
                        @endif

                        @if ($hasActiveSubscription)
                            <div class="absolute inset-0 bg-[#6B592E]/20"></div>
                            {{-- S-symbol overlay for subscribed --}}
                            <div class="absolute top-4 right-4 opacity-80">
                                <img src="{{ asset('assets/images/home/s-symbol.png') }}" alt="Premium"
                                    class="w-8 h-8">
                            </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="flex flex-col p-6 flex-grow">
                        <p class="font-Poppins font-extralight text-sm text-Ecru mb-1">BARBERSHOP</p>
                        <h3 class="font-Kuunari font-bold text-xl text-Seasalt mb-2">
                            {{ strtoupper($barbershop->name) }}
                        </h3>

                        <!-- Location -->
                        <div class="flex flex-row gap-2 items-center mb-4">
                            <svg viewBox="0 0 37 52" fill="none" class="w-3 h-3 flex-shrink-0"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M0.73587 17.258C0.73587 7.7 7.76387 0 18.3169 0C28.8699 0 35.8979 7.7 35.8979 17.258C35.8979 31.146 18.3169 51.65 18.3169 51.65C18.3169 51.65 0.73587 31.147 0.73587 17.258Z"
                                    fill="#E9BF80" />
                                <circle cx="18.3169" cy="17.258" r="7.29167" fill="#1A1A1A" />
                            </svg>
                            <p class="font-Poppins font-extralight text-sm text-Ecru">{{ $barbershop->address }}
                            </p>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div
                        class="flex flex-row justify-between items-center border-t border-Seasalt/20 py-4 px-6 mt-auto">
                        <!-- Reviews -->
                        <div class="flex flex-row gap-2 items-center">
                            <svg viewBox="0 0 15 15" fill="none" class="w-4 h-4" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12.5 1.25H2.5C1.8125 1.25 1.25 1.8125 1.25 2.5V13.75L3.75 11.25H12.5C13.1875 11.25 13.75 10.6875 13.75 10V2.5C13.75 1.8125 13.1875 1.25 12.5 1.25ZM3.75 8.75V7.20625L8.05 2.90625C8.175 2.78125 8.36875 2.78125 8.49375 2.90625L9.6 4.0125C9.725 4.1375 9.725 4.33125 9.6 4.45625L5.29375 8.75H3.75ZM10.625 8.75H6.5625L7.8125 7.5H10.625C10.9688 7.5 11.25 7.78125 11.25 8.125C11.25 8.46875 10.9688 8.75 10.625 8.75Z"
                                    fill="#FAFAFA" />
                            </svg>
                            <p class="font-Poppins font-light text-xs text-Ecru">{{ $barbershop->reviews_count }}
                                Orang</p>
                        </div>

                        <!-- Star Rating -->
                        <div class="flex space-x-1">
                            @for ($i = 0; $i < 5; $i++)
                                @php
                                    $fillAmount = max(0, min(1, $barbershop->rating - $i));
                                @endphp

                                @if ($fillAmount === 1)
                                    <x-star-icon fill="#E9BF80" class="w-4 h-4" />
                                @elseif ($fillAmount === 0)
                                    <x-star-icon fill="#E5E7EB" class="w-4 h-4" />
                                @else
                                    <div class="relative w-4 h-4">
                                        <x-star-icon fill="#E5E7EB" class="absolute top-0 left-0 w-4 h-4" />
                                        <div class="absolute top-0 left-0 h-full overflow-hidden"
                                            style="width: {{ $fillAmount * 100 }}%">
                                            <x-star-icon fill="#E9BF80" class="w-4 h-4" />
                                        </div>
                                    </div>
                                @endif
                            @endfor
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-16">
                    <div class="bg-Eerie-Black rounded-lg p-8 max-w-md mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-16 h-16 mx-auto text-Ecru mb-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                        <h3 class="text-white text-xl font-Kuunari font-bold mb-3">TIDAK ADA HASIL</h3>
                        <p class="text-gray-400 text-sm font-Poppins">
                            Tidak ada barbershop yang sesuai dengan kriteria pencarian Anda.
                            Coba ubah filter atau kata kunci pencarian.
                        </p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if (method_exists($barbershops, 'hasPages') && $barbershops->hasPages())
            <div class="flex justify-center mt-16">
                <div
                    class="pagination-container bg-Eerie-Black/50 backdrop-blur-sm rounded-2xl p-8 border border-Ecru/10">
                    {{ $barbershops->links('vendor.pagination.custom-barbershop') }}
                </div>
            </div>
        @endif
    </div>
</div>

@push('styles')
    <style>
        /* Premium glow effect for subscribed barbershops in "Show All" view */
        .premium-glow {
            box-shadow: 0 0 20px rgba(233, 191, 128, 0.3), 0 0 40px rgba(233, 191, 128, 0.1);
            animation: premium-pulse 3s ease-in-out infinite;
        }

        .premium-glow:hover {
            box-shadow: 0 0 30px rgba(233, 191, 128, 0.5), 0 0 60px rgba(233, 191, 128, 0.2);
        }

        @keyframes premium-pulse {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(233, 191, 128, 0.3), 0 0 40px rgba(233, 191, 128, 0.1);
            }

            50% {
                box-shadow: 0 0 25px rgba(233, 191, 128, 0.4), 0 0 50px rgba(233, 191, 128, 0.15);
            }
        }
    </style>
@endpush
