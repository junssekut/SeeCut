@push('styles')
    <style>
        .swiper {
            width: 491px;
            height: 438px;
        }

        .swiper-slide {
            width: 391px;
            height: 438px;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-slide img {
            width: 391px;
            height: 438px;
            object-fit: cover;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        /* Responsive Swiper for mobile */
        @media (max-width: 768px) {
            .swiper {
                width: 280px;
                height: 320px;
            }

            .swiper-slide {
                width: 250px;
                height: 320px;
            }

            .swiper-slide img {
                width: 250px;
                height: 320px;
            }
        }

        @media (max-width: 640px) {
            .swiper {
                width: 240px;
                height: 280px;
            }

            .swiper-slide {
                width: 220px;
                height: 280px;
            }

            .swiper-slide img {
                width: 220px;
                height: 280px;
            }
        }

        .glow-star {
            filter: drop-shadow(0 0 8px rgba(255, 215, 0, 0.8));
            /* Golden glow */
            transition: transform 0.3s ease, filter 0.3s ease;
        }

        .glow-star:hover {
            transform: scale(1.1);
            filter: drop-shadow(0 0 12px rgba(255, 215, 0, 1));
        }

        @keyframes glow-pulse {

            0%,
            100% {
                filter: drop-shadow(0 0 6px rgba(255, 215, 0, 0.6));
            }

            50% {
                filter: drop-shadow(0 0 12px rgba(255, 215, 0, 1));
            }
        }

        .glow-star {
            animation: glow-pulse 2s infinite ease-in-out;
        }

        /* Hide scrollbar for mobile card scrolling */
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
    </style>
@endpush

<div>
    <div
        class="relative flex flex-col items-center justify-center h-[701px] md:h-[600px] sm:h-[500px] bg-landing bg-center bg-cover bg-no-repeat px-4 sm:px-8 md:px-16 lg:px-48 py-8 md:py-16 lg:py-48">

        {{-- <div class="absolute inset-0 bg-[#090909]/60 z-0"></div> --}}
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-[#0C0C0C] z-0"></div>

        <div class="relative z-10 max-w-7xl w-full p-6 flex flex-col items-center justify-center text-center">
            <div class="flex flex-row items-center justify-center gap-1 sm:gap-2">
                @for ($i = 0; $i < 5; $i++)
                    <img data-aos="zoom-in-up" data-aos-duration="500" data-aos-delay="{{ 1000 + ($i + 1) * 250 }}"
                        src="{{ asset('assets/images/home/material-symbols_star.png') }}" alt=""
                        class="w-5 sm:w-6 md:w-8 glow-star" style="animation-delay: {{ $i * 0.5 }}s;">
                @endfor
            </div>
            <h1 data-aos="zoom-in" data-aos-duration="1500"
                class="text-2xl sm:text-3xl md:text-4xl lg:text-6xl font-Kuunari text-Seasalt text-wide mt-4">
                WUJUDKAN GAYA TERBAIK ANDA.
            </h1>
            <p data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-delay="1000" data-aos-duration="500"
                class="tracking-normal text-lg sm:text-xl md:text-2xl lg:text-5xl font-Kuunari font-extrabold text-transparent text-stroke-1 text-stroke-Ecru mt-2 md:mt-4 px-2 mb-8 lg:mb-0">
                TEMUKAN BARBERSHOP TERDEKAT DENGAN LAYANAN TERPERCAYA
            </p>

            <!-- Search bar positioned below text on mobile -->
            <div data-aos="fade-up" data-aos-anchor-placement="center-bottom" data-aos-delay="500"
                data-aos-duration="500" class="w-full lg:hidden mt-6">
                <livewire:components.search-bar />
            </div>
        </div>

        <!-- Search bar positioned absolutely on desktop -->
        <div data-aos="fade-up" data-aos-anchor-placement="center-bottom" data-aos-delay="500" data-aos-duration="500"
            class="hidden lg:flex flex-col items-center justify-center px-4 sm:px-8 md:px-16 lg:px-48 w-full absolute bottom-16 md:bottom-20 lg:top-[631px]">
            <livewire:components.search-bar />
        </div>
    </div>

    <div class="mt-20 relative">
        <div class="absolute inset-0 bg-s-logo bg-no-repeat bg-center bg-contain z-0"></div>

        <div
            class="relative container z-10 mx-auto px-4 sm:px-8 md:px-16 lg:px-48 pt-12 flex flex-col items-center justify-center">
            <div class="flex flex-col items-center justify-center text-center">
                <img src="{{ asset('assets/images/home/s-symbol.png') }}" alt="" class="w-20 sm:w-24 md:w-28">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-Kuunari text-Seasalt mb-4 md:mb-6 px-4">REKOMENDASI
                    TERBAIK UNTUK GAYA TERPERCAYA</h2>
                <p
                    class="text-sm sm:text-base md:text-lg font-Poppins font-light text-Seasalt mb-8 md:mb-12 px-4 max-w-4xl">
                    Barbershop-barbershop pilihan kami yang
                    telah bekerja
                    sama secara
                    resmi dan mendapatkan rating tertinggi dari pelanggan. Nikmati kemudahan layanan booking eksklusif
                    langsung melalui platform SEECUT.</p>
            </div>
        </div>

        <div class="relative z-10 mx-4 sm:mx-8 md:mx-12">
            <!-- Mobile: Horizontal scrolling -->
            <div class="flex md:hidden gap-4 overflow-x-auto pb-4 snap-x snap-mandatory scrollbar-hide"
                style="scrollbar-width: none; -ms-overflow-style: none;">
                @forelse($topVendors as $vendor)
                    <div wire:click="viewVendor({{ $vendor->id }})"
                        class="flex flex-col bg-Eerie-Black cursor-pointer transition-all duration-300 hover:scale-105 hover:shadow-xl w-72 sm:w-80 flex-shrink-0 snap-start">
                        <div class="relative">
                            <div class="absolute inset-0 bg-[#6B592E]/40 bg-no-repeat bg-center bg-contain z-0"></div>
                            @if ($vendor->thumbnail_url)
                                <img src="{{ $vendor->thumbnail_url }}" alt="{{ $vendor->name }}"
                                    class="w-full h-48 sm:h-56 object-cover">
                            @else
                                <img src="{{ asset('assets/images/home/bgtest.png') }}" alt="{{ $vendor->name }}"
                                    class="w-full h-48 sm:h-56 object-cover">
                            @endif
                        </div>

                        <div class="flex flex-col p-4">
                            <p class="font-Poppins font-extralight text-sm text-Ecru">BARBERSHOP</p>
                            <h1 class="font-Kuunari font-bold text-xl sm:text-2xl text-Seasalt truncate">
                                {{ $vendor->name }}</h1>
                            <div class="flex flex-row gap-1 text-center items-center pt-2">
                                <svg viewBox="0 0 37 52" fill="none" class="w-3 h-3"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M0.73587 17.258C0.73587 7.7 7.76387 0 18.3169 0C28.8699 0 35.8979 7.7 35.8979 17.258C35.8979 31.146 18.3169 51.65 18.3169 51.65C18.3169 51.65 0.73587 31.147 0.73587 17.258Z"
                                        fill="#E9BF80" />
                                    <circle cx="18.3169" cy="17.258" r="7.29167" fill="#1A1A1A" />
                                </svg>
                                <p class="font-Poppins font-extralight text-sm text-Ecru truncate">
                                    {{ $vendor->address }}</p>
                            </div>
                        </div>

                        <div class="flex flex-row justify-between items-center border-t-[1px] border-Seasalt py-3 px-4">
                            <div class="flex flex-row gap-1 items-center">
                                <svg viewBox="0 0 15 15" fill="none" class="w-4 h-4"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12.5 1.25H2.5C1.8125 1.25 1.25 1.8125 1.25 2.5V13.75L3.75 11.25H12.5C13.1875 11.25 13.75 10.6875 13.75 10V2.5C13.75 1.8125 13.1875 1.25 12.5 1.25ZM3.75 8.75V7.20625L8.05 2.90625C8.175 2.78125 8.36875 2.78125 8.49375 2.90625L9.6 4.0125C9.725 4.1375 9.725 4.33125 9.6 4.45625L5.29375 8.75H3.75ZM10.625 8.75H6.5625L7.8125 7.5H10.625C10.9688 7.5 11.25 7.78125 11.25 8.125C11.25 8.46875 10.9688 8.75 10.625 8.75Z"
                                        fill="#FAFAFA" />
                                </svg>
                                <p class="font-Poppins font-light text-[10px] text-Ecru">{{ $vendor->reviews_count }}
                                    Orang</p>
                            </div>

                            <div class="flex space-x-1">
                                @for ($i = 0; $i < 5; $i++)
                                    @php
                                        $fillAmount = max(0, min(1, $vendor->rating - $i));
                                    @endphp

                                    @if ($fillAmount === 1)
                                        <x-star-icon fill="#E9BF80" />
                                    @elseif ($fillAmount === 0)
                                        <x-star-icon fill="#E5E7EB" />
                                    @else
                                        <div class="relative w-6 h-6">
                                            <x-star-icon fill="#E5E7EB" class="absolute top-0 left-0" />
                                            <div class="absolute top-0 left-0 h-full overflow-hidden"
                                                style="width: {{ $fillAmount * 100 }}%">
                                                <x-star-icon fill="#E9BF80" />
                                            </div>
                                        </div>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Fallback if no vendors found --}}
                    <div class="flex flex-col bg-Eerie-Black w-72 sm:w-80 flex-shrink-0 snap-start">
                        <div class="relative">
                            <div class="absolute inset-0 bg-[#6B592E]/40 bg-no-repeat bg-center bg-contain z-0"></div>
                            <img src="{{ asset('assets/images/home/bgtest.png') }}" alt=""
                                class="w-full h-48 sm:h-56 object-cover">
                        </div>
                        <div class="flex flex-col p-4">
                            <p class="font-Poppins font-extralight text-sm text-Ecru">BARBERSHOP</p>
                            <h1 class="font-Kuunari font-bold text-xl sm:text-2xl text-Seasalt">CAPTAIN BARBERSHOP</h1>
                            <div class="flex flex-row gap-1 text-center items-center pt-2">
                                <svg viewBox="0 0 37 52" fill="none" class="w-3 h-3"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M0.73587 17.258C0.73587 7.7 7.76387 0 18.3169 0C28.8699 0 35.8979 7.7 35.8979 17.258C35.8979 31.146 18.3169 51.65 18.3169 51.65C18.3169 51.65 0.73587 31.147 0.73587 17.258Z"
                                        fill="#E9BF80" />
                                    <circle cx="18.3169" cy="17.258" r="7.29167" fill="#1A1A1A" />
                                </svg>
                                <p class="font-Poppins font-extralight text-sm text-Ecru truncate">Bogor, Jawa Barat
                                </p>
                            </div>
                        </div>
                        <div
                            class="flex flex-row justify-between items-center border-t-[1px] border-Seasalt py-3 px-4">
                            <div class="flex flex-row gap-1">
                                <svg viewBox="0 0 15 15" fill="none" class="w-4 h-4"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12.5 1.25H2.5C1.8125 1.25 1.25 1.8125 1.25 2.5V13.75L3.75 11.25H12.5C13.1875 11.25 13.75 10.6875 13.75 10V2.5C13.75 1.8125 13.1875 1.25 12.5 1.25ZM3.75 8.75V7.20625L8.05 2.90625C8.175 2.78125 8.36875 2.78125 8.49375 2.90625L9.6 4.0125C9.725 4.1375 9.725 4.33125 9.6 4.45625L5.29375 8.75H3.75ZM10.625 8.75H6.5625L7.8125 7.5H10.625C10.9688 7.5 11.25 7.78125 11.25 8.125C11.25 8.46875 10.9688 8.75 10.625 8.75Z"
                                        fill="#FAFAFA" />
                                </svg>
                                <p class="font-Poppins font-light text-[10px] text-Ecru">169 Orang</p>
                            </div>
                            <div class="flex space-x-1">
                                @for ($i = 0; $i < 5; $i++)
                                    <x-star-icon fill="#E9BF80" />
                                @endfor
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Desktop: Grid layout -->
            <div class="hidden md:flex justify-center gap-8">
                @forelse($topVendors as $vendor)
                    <div wire:click="viewVendor({{ $vendor->id }})"
                        class="flex flex-col bg-Eerie-Black cursor-pointer transition-all duration-300 hover:scale-105 hover:shadow-xl w-80">
                        <div class="relative">
                            <div class="absolute inset-0 bg-[#6B592E]/40 bg-no-repeat bg-center bg-contain z-0"></div>
                            @if ($vendor->thumbnail_url)
                                <img src="{{ $vendor->thumbnail_url }}" alt="{{ $vendor->name }}"
                                    class="w-full h-56 object-cover">
                            @else
                                <img src="{{ asset('assets/images/home/bgtest.png') }}" alt="{{ $vendor->name }}"
                                    class="w-full h-56 object-cover">
                            @endif
                        </div>

                        <div class="flex flex-col p-4">
                            <p class="font-Poppins font-extralight text-sm text-Ecru">BARBERSHOP</p>
                            <h1 class="font-Kuunari font-bold text-2xl text-Seasalt truncate">{{ $vendor->name }}</h1>
                            <div class="flex flex-row gap-1 text-center items-center pt-2">
                                <svg viewBox="0 0 37 52" fill="none" class="w-3 h-3"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M0.73587 17.258C0.73587 7.7 7.76387 0 18.3169 0C28.8699 0 35.8979 7.7 35.8979 17.258C35.8979 31.146 18.3169 51.65 18.3169 51.65C18.3169 51.65 0.73587 31.147 0.73587 17.258Z"
                                        fill="#E9BF80" />
                                    <circle cx="18.3169" cy="17.258" r="7.29167" fill="#1A1A1A" />
                                </svg>
                                <p class="font-Poppins font-extralight text-sm text-Ecru truncate">
                                    {{ $vendor->address }}</p>
                            </div>
                        </div>

                        <div
                            class="flex flex-row justify-between items-center border-t-[1px] border-Seasalt py-3 px-4">
                            <div class="flex flex-row gap-1 items-center">
                                <svg viewBox="0 0 15 15" fill="none" class="w-4 h-4"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12.5 1.25H2.5C1.8125 1.25 1.25 1.8125 1.25 2.5V13.75L3.75 11.25H12.5C13.1875 11.25 13.75 10.6875 13.75 10V2.5C13.75 1.8125 13.1875 1.25 12.5 1.25ZM3.75 8.75V7.20625L8.05 2.90625C8.175 2.78125 8.36875 2.78125 8.49375 2.90625L9.6 4.0125C9.725 4.1375 9.725 4.33125 9.6 4.45625L5.29375 8.75H3.75ZM10.625 8.75H6.5625L7.8125 7.5H10.625C10.9688 7.5 11.25 7.78125 11.25 8.125C11.25 8.46875 10.9688 8.75 10.625 8.75Z"
                                        fill="#FAFAFA" />
                                </svg>
                                <p class="font-Poppins font-light text-[10px] text-Ecru">{{ $vendor->reviews_count }}
                                    Orang</p>
                            </div>

                            <div class="flex space-x-1">
                                @for ($i = 0; $i < 5; $i++)
                                    @php
                                        $fillAmount = max(0, min(1, $vendor->rating - $i));
                                    @endphp

                                    @if ($fillAmount === 1)
                                        <x-star-icon fill="#E9BF80" />
                                    @elseif ($fillAmount === 0)
                                        <x-star-icon fill="#E5E7EB" />
                                    @else
                                        <div class="relative w-6 h-6">
                                            <x-star-icon fill="#E5E7EB" class="absolute top-0 left-0" />
                                            <div class="absolute top-0 left-0 h-full overflow-hidden"
                                                style="width: {{ $fillAmount * 100 }}%">
                                                <x-star-icon fill="#E9BF80" />
                                            </div>
                                        </div>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Fallback if no vendors found --}}
                    <div class="flex flex-col bg-Eerie-Black w-80">
                        <div class="relative">
                            <div class="absolute inset-0 bg-[#6B592E]/40 bg-no-repeat bg-center bg-contain z-0"></div>
                            <img src="{{ asset('assets/images/home/bgtest.png') }}" alt=""
                                class="w-full h-56 object-cover">
                        </div>
                        <div class="flex flex-col p-4">
                            <p class="font-Poppins font-extralight text-sm text-Ecru">BARBERSHOP</p>
                            <h1 class="font-Kuunari font-bold text-2xl text-Seasalt">CAPTAIN BARBERSHOP</h1>
                            <div class="flex flex-row gap-1 text-center items-center pt-2">
                                <svg viewBox="0 0 37 52" fill="none" class="w-3 h-3"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                        d="M0.73587 17.258C0.73587 7.7 7.76387 0 18.3169 0C28.8699 0 35.8979 7.7 35.8979 17.258C35.8979 31.146 18.3169 51.65 18.3169 51.65C18.3169 51.65 0.73587 31.147 0.73587 17.258Z"
                                        fill="#E9BF80" />
                                    <circle cx="18.3169" cy="17.258" r="7.29167" fill="#1A1A1A" />
                                </svg>
                                <p class="font-Poppins font-extralight text-sm text-Ecru truncate">Bogor, Jawa Barat
                                </p>
                            </div>
                        </div>
                        <div
                            class="flex flex-row justify-between items-center border-t-[1px] border-Seasalt py-3 px-4">
                            <div class="flex flex-row gap-1">
                                <svg viewBox="0 0 15 15" fill="none" class="w-4 h-4"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12.5 1.25H2.5C1.8125 1.25 1.25 1.8125 1.25 2.5V13.75L3.75 11.25H12.5C13.1875 11.25 13.75 10.6875 13.75 10V2.5C13.75 1.8125 13.1875 1.25 12.5 1.25ZM3.75 8.75V7.20625L8.05 2.90625C8.175 2.78125 8.36875 2.78125 8.49375 2.90625L9.6 4.0125C9.725 4.1375 9.725 4.33125 9.6 4.45625L5.29375 8.75H3.75ZM10.625 8.75H6.5625L7.8125 7.5H10.625C10.9688 7.5 11.25 7.78125 11.25 8.125C11.25 8.46875 10.9688 8.75 10.625 8.75Z"
                                        fill="#FAFAFA" />
                                </svg>
                                <p class="font-Poppins font-light text-[10px] text-Ecru">169 Orang</p>
                            </div>
                            <div class="flex space-x-1">
                                @for ($i = 0; $i < 5; $i++)
                                    <x-star-icon fill="#E9BF80" />
                                @endfor
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <div
            class="relative z-10 flex flex-col lg:flex-row justify-center items-center gap-6 px-4 sm:px-8 md:px-16 lg:px-48 mt-8 lg:mt-0">
            <div class="swiper swiperCut order-2 lg:order-1">
                <div class="swiper-wrapper">
                    <div class="swiper-slide"><img src="{{ asset('assets/images/home/image 7.png') }}"
                            alt=""></div>
                    <div class="swiper-slide"><img src="{{ asset('assets/images/home/image 10.png') }}"
                            alt=""></div>
                    <div class="swiper-slide"><img src="{{ asset('assets/images/home/image 11.png') }}"
                            alt=""></div>
                </div>
            </div>
            <div
                class="flex flex-col items-start justify-center gap-4 lg:gap-6 w-full lg:w-[600px] px-4 lg:px-12 order-1 lg:order-2">
                <h1 class="font-Kuunari text-Ecru text-2xl sm:text-3xl lg:text-4xl font-bold text-center lg:text-left">
                    NEMUIN GAYA RAMBUT YANG PAS NGGAK PERNAH
                    SEMUDAH
                    INI.</h1>
                <p class="font-Poppins text-Seasalt text-base sm:text-lg lg:text-xl text-center lg:text-left">Gaya
                    rambut bukan cuma soal tren, tapi soal cocok atau
                    nggaknya sama kamu. Scroll inspirasi dari barber terbaik kami, dan kalau masih bingung, langsung
                    tanya ke fitur live chat AI kami. Siap kasih rekomendasi yang pas buat bentuk wajah kamu!</p>

                <a href="{{ route('style.index') }}"
                    class="bg-Ecru rounded-sm font-Kuunari text-base sm:text-lg px-4 sm:px-6 py-3 sm:py-4 text-Eerie-Black self-center lg:self-start">REKOMENDASI
                    GAYA
                    SEKARANG</a>
            </div>
        </div>

        <div class="relative flex flex-col justify-content-center px-4 sm:px-8 md:px-16 lg:px-48 mt-16">
            <div class="absolute inset-0 bg-[#090909]/60 z-0 "></div>


            {{-- <div class="relative"> --}}
            {{-- <div class="absolute inset-0 bg-[#]/60 bg-no-repeat bg-center bg-contain z-0"></div> --}}
            {{-- <img src="{{ asset('assets/images/home/bgtest.png') }}" alt="" class="w-[343px] h-[282px]"> --}}
            {{-- <img src="{{ asset('assets/images/home/background-blur.png') }}" alt="" class="blur-xs"> --}}
            {{-- </div> --}}

            <div
                class="relative flex flex-col justify-content-center items-center py-16 sm:py-24 md:py-32 lg:py-48 border-t-4 sm:border-t-6 md:border-t-8 border-Ecru rounded-lg text-center gap-4 sm:gap-6 md:gap-8 overflow-hidden">
                <div class="absolute inset-0 bg-home-ad bg-cover blur-sm z-0"></div>
                <div class="absolute inset-0 bg-[#090909]/80 z-1"></div>

                <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-Kuunari text-Ecru z-10 px-4">BISNIS
                    BARBERSHOP KAMU, LEVEL-UP SEKARANG.
                </h1>
                <p
                    class="text-sm sm:text-base md:text-lg lg:text-xl font-Poppins text-Seasalt z-10 w-[90%] sm:w-[85%] md:w-[80%] px-4">
                    Kamu punya usaha barbershop dan mau tampil
                    lebih
                    profesional? Pakai fitur Seecut:
                    dari sistem booking
                    otomatis, halaman profil digital, sampai laporan harian—semua langsung dari satu tempat. Kelola
                    bisnismu tanpa ribet!</p>
                <a href="{{ route('subscription') }}"
                    class="bg-Ecru z-10 py-3 sm:py-4 px-6 sm:px-8 rounded-sm font-Kuunari text-base sm:text-lg md:text-xl text-Eerie-Black hover:bg-Satin-Sheen-Yellow transition-colors duration-300 hover:text-Seasalt">COBA
                    FITURNYA
                    SEKARANG</a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        AOS.init();

        const swiper = new Swiper(".swiperCut", {
            effect: "cards",
            grabCursor: true,
            loop: true,
            initialSlide: 1,
        });
    </script>
@endpush
