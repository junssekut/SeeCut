@extends('layouts.app')

@section('title', '404 - Halaman Tidak Ditemukan')

@push('styles')
    <style>
        .scissors-animation {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-10px) rotate(5deg);
            }
        }

        .hair-strands {
            animation: fall 2s ease-in-out infinite;
        }

        @keyframes fall {
            0% {
                transform: translateY(-20px) rotate(0deg);
                opacity: 0;
            }

            50% {
                opacity: 1;
            }

            100% {
                transform: translateY(20px) rotate(180deg);
                opacity: 0;
            }
        }
    </style>
@endpush

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-Eerie-Black via-Dark-Charcoal to-Eerie-Black relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5">
            <div class="absolute top-20 left-20 w-32 h-32 border-2 border-Satin-Sheen-Yellow rounded-full"></div>
            <div class="absolute top-40 right-32 w-24 h-24 border-2 border-Ecru rounded-full"></div>
            <div class="absolute bottom-32 left-1/4 w-16 h-16 border-2 border-Dun rounded-full"></div>
            <div class="absolute bottom-20 right-20 w-20 h-20 border-2 border-Satin-Sheen-Yellow rounded-full"></div>
        </div>

        <!-- Floating Hair Strands -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="hair-strands absolute top-32 left-1/4 w-1 h-8 bg-Satin-Sheen-Yellow rounded-full opacity-30"
                style="animation-delay: 0s;"></div>
            <div class="hair-strands absolute top-40 right-1/3 w-1 h-6 bg-Ecru rounded-full opacity-40"
                style="animation-delay: 0.5s;"></div>
            <div class="hair-strands absolute top-28 left-1/2 w-1 h-10 bg-Dun rounded-full opacity-35"
                style="animation-delay: 1s;"></div>
            <div class="hair-strands absolute top-36 right-1/4 w-1 h-7 bg-Satin-Sheen-Yellow rounded-full opacity-30"
                style="animation-delay: 1.5s;"></div>
        </div>

        <div class="flex flex-col items-center justify-center min-h-screen px-4 py-8 relative z-10">
            <div class="max-w-4xl w-full text-center">
                <!-- 404 Number with Barber Pole Style -->
                <div class="relative mb-8">
                    <h1
                        class="text-9xl md:text-[12rem] font-Kuunari font-bold text-transparent bg-gradient-to-r from-Satin-Sheen-Yellow via-Ecru to-Dun bg-clip-text leading-none">
                        404
                    </h1>
                    <!-- Animated Scissors -->
                    <div class="scissors-animation absolute top-4 right-8 md:right-16">
                        <svg class="w-16 h-16 md:w-20 md:h-20 text-Satin-Sheen-Yellow" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M9.64 7.64c.23-.5.36-1.05.36-1.64 0-2.21-1.79-4-4-4S2 3.79 2 6s1.79 4 4 4c.59 0 1.14-.13 1.64-.36L10 12l-2.36 2.36C7.14 14.13 6.59 14 6 14c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4c0-.59-.13-1.14-.36-1.64L12 14l7 7h3v-1L9.64 7.64zM6 8c-1.1 0-2-.89-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm0 12c-1.1 0-2-.89-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm6-7.5c-.28 0-.5-.22-.5-.5s.22-.5.5-.5.5.22.5.5-.22.5-.5.5zM19 3l-6 6 2 2 7-7V3z" />
                        </svg>
                    </div>
                </div>

                <!-- Error Message -->
                <div class="mb-8">
                    <h2 class="text-3xl md:text-4xl font-Kuunari font-bold text-Seasalt mb-4">
                        OOPS! HALAMAN TIDAK DITEMUKAN
                    </h2>
                    <p class="text-lg md:text-xl text-Seasalt/80 font-Poppins leading-relaxed max-w-2xl mx-auto">
                        Sepertinya halaman yang Anda cari sudah "dipotong" dari website kami.
                        Mari kembali ke beranda dan temukan barbershop terbaik untuk gaya rambut impian Anda!
                    </p>
                </div>

                <!-- Barber Character Illustration -->
                <div class="mb-8 relative">
                    <div
                        class="w-48 h-48 mx-auto bg-gradient-to-br from-Satin-Sheen-Yellow/20 to-Ecru/20 rounded-full flex items-center justify-center border-4 border-Satin-Sheen-Yellow/30 relative overflow-hidden">
                        <!-- Person Silhouette -->
                        <svg class="w-32 h-32 text-Seasalt/60" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                        </svg>

                        <!-- Hair on top -->
                        <div
                            class="absolute top-8 left-1/2 transform -translate-x-1/2 w-20 h-8 bg-gradient-to-r from-Satin-Sheen-Yellow to-Ecru rounded-t-full opacity-70">
                        </div>

                        <!-- Floating scissors around -->
                        <div class="scissors-animation absolute -top-4 -right-4">
                            <svg class="w-8 h-8 text-Ecru" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M9.64 7.64c.23-.5.36-1.05.36-1.64 0-2.21-1.79-4-4-4S2 3.79 2 6s1.79 4 4 4c.59 0 1.14-.13 1.64-.36L10 12l-2.36 2.36C7.14 14.13 6.59 14 6 14c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4c0-.59-.13-1.14-.36-1.64L12 14l7 7h3v-1L9.64 7.64zM6 8c-1.1 0-2-.89-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm0 12c-1.1 0-2-.89-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm6-7.5c-.28 0-.5-.22-.5-.5s.22-.5.5-.5.5.22.5.5-.22.5-.5.5zM19 3l-6 6 2 2 7-7V3z" />
                            </svg>
                        </div>

                        <div class="scissors-animation absolute -bottom-2 -left-4" style="animation-delay: 1s;">
                            <svg class="w-6 h-6 text-Dun" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M9.64 7.64c.23-.5.36-1.05.36-1.64 0-2.21-1.79-4-4-4S2 3.79 2 6s1.79 4 4 4c.59 0 1.14-.13 1.64-.36L10 12l-2.36 2.36C7.14 14.13 6.59 14 6 14c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4c0-.59-.13-1.14-.36-1.64L12 14l7 7h3v-1L9.64 7.64zM6 8c-1.1 0-2-.89-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm0 12c-1.1 0-2-.89-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm6-7.5c-.28 0-.5-.22-.5-.5s.22-.5.5-.5.5.22.5.5-.22.5-.5.5zM19 3l-6 6 2 2 7-7V3z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <!-- Home Button -->
                    <a href="{{ route('home') }}"
                        class="group bg-gradient-to-r from-Satin-Sheen-Yellow to-Ecru hover:from-Ecru hover:to-Satin-Sheen-Yellow text-Eerie-Black font-Kuunari font-bold px-8 py-4 rounded-xl transition-all duration-300 transform hover:scale-105 hover:shadow-xl flex items-center gap-3">
                        <svg class="w-5 h-5 group-hover:rotate-12 transition-transform duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        KEMBALI KE BERANDA
                    </a>

                    <!-- Find Barbershop Button -->
                    <a href="{{ route('barbershop.index') }}"
                        class="group bg-transparent border-2 border-Satin-Sheen-Yellow text-Satin-Sheen-Yellow hover:bg-Satin-Sheen-Yellow hover:text-Eerie-Black font-Kuunari font-bold px-8 py-4 rounded-xl transition-all duration-300 transform hover:scale-105 flex items-center gap-3">
                        <svg class="w-5 h-5 group-hover:rotate-12 transition-transform duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        CARI BARBERSHOP
                    </a>
                </div>

                <!-- Additional Help Text -->
                <div class="mt-8 pt-8 border-t border-Seasalt/20">
                    <p class="text-Seasalt/60 font-Poppins text-sm">
                        Butuh bantuan? Hubungi customer service kami atau kembali ke halaman utama untuk menjelajahi layanan
                        SeeCut.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
