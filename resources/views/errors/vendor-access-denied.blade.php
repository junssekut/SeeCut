@extends('layouts.app')

@section('title', 'Akses Ditolak')

@section('content')
    <div class="min-h-screen bg-Eerie-Black flex items-center justify-center px-4">
        <div class="max-w-md w-full bg-white rounded-lg shadow-xl p-8 text-center">
            <!-- Error Icon -->
            <div class="mx-auto mb-6 w-20 h-20 bg-red-100 rounded-full flex items-center justify-center">
                <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.35 16.5c-.77.833.192 2.5 1.732 2.5z">
                    </path>
                </svg>
            </div>

            <!-- Error Title -->
            <h1 class="text-2xl font-bold text-gray-900 mb-4 font-Kuunari">
                AKSES DITOLAK
            </h1>

            <!-- Error Message -->
            <p class="text-gray-600 mb-6 font-Poppins">
                Maaf, Anda tidak memiliki izin untuk mengakses bagian vendor.
                Halaman ini khusus untuk akun vendor yang terdaftar.
            </p>

            <!-- Additional Info -->
            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                <p class="text-sm text-gray-700 font-Poppins">
                    <strong>Info:</strong> Jika Anda ingin menjadi vendor, silakan hubungi tim SeeCut untuk mendaftar
                    sebagai mitra barbershop resmi.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <!-- Go Back Button -->
                <button onclick="goBack()"
                    class="w-full bg-Dark-Teal text-white py-3 px-6 rounded-lg font-Kuunari text-lg hover:bg-opacity-90 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-Dark-Teal/30">
                    KEMBALI KE HALAMAN SEBELUMNYA
                </button>

                <!-- Home Button -->
                <a href="{{ route('home') }}"
                    class="w-full bg-gray-200 text-gray-800 py-3 px-6 rounded-lg font-Kuunari text-lg hover:bg-gray-300 transition-all duration-300 inline-block focus:outline-none focus:ring-4 focus:ring-gray-300/30">
                    KEMBALI KE BERANDA
                </a>
            </div>

            <!-- Contact Info -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <p class="text-xs text-gray-500 font-Poppins">
                    Butuh bantuan? Hubungi tim SeeCut untuk informasi lebih lanjut tentang kemitraan vendor.
                </p>
            </div>
        </div>
    </div>

    <script>
        function goBack() {
            // Check if there's a previous URL provided
            @if (isset($previousUrl) && $previousUrl)
                window.location.href = '{{ $previousUrl }}';
            @else
                // Fallback: go back in browser history or to home
                if (window.history.length > 1) {
                    window.history.back();
                } else {
                    window.location.href = '{{ route('home') }}';
                }
            @endif
        }
    </script>
@endsection
