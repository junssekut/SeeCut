<footer class="bg-[#1A1A1A] text-white px-6 sm:px-8 md:px-16 lg:px-48 py-10 relative mt-20">
    <!-- Garis atas -->
    <div class="absolute top-0 left-0 w-full h-1 rounded-t bg-[#D6AC69]"></div>

    <!-- Logo -->
    <div class="flex justify-center md:justify-start">
        <a href="{{ route('home') }}">
            <img src="{{ asset('assets/images/logo-text.png') }}" alt="SeeCut" class="w-24 mb-5" />
        </a>
    </div>

    <!-- Konten Tengah: Deskripsi & Navigasi -->
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-start md:items-start gap-8 md:gap-10">
        <!-- Deskripsi -->
        <div class="w-full md:w-1/2">
            <p class="text-sm text-[#EAEAEA] leading-relaxed max-w-md mx-auto md:mx-0 text-center md:text-left">
                Bangun barbershop profesional lebih mudah bersama Seecut. Platform lengkap yang bantu kamu kelola
                reservasi, tampil di pencarian pelanggan, dan tingkatkan layanan dengan fitur canggih.
            </p>
        </div>

        <!-- Navigasi -->
        <div
            class="w-full md:w-1/2 flex flex-col sm:flex-row justify-center md:justify-end items-center gap-2 sm:gap-6 text-lg font-semibold text-[#D6AC69]">
            <a href="#booking" class="hover:underline font-Kuunari">BOOKING</a>
            <a href="#live-chat" class="hover:underline font-Kuunari">LIVE CHAT AI</a>
            <a href="#find-barbershop" class="hover:underline font-Kuunari">FIND BARBERSHOP</a>
        </div>
    </div>

    <!-- Copyright -->
    <div class="mt-12 text-center text-xs text-gray-400">
        © 2025 Seecut. All rights reserved.
    </div>
</footer>
