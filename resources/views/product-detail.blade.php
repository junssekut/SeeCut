<x-app-layout>
    <div class="flex flex-col bg-[#0C0C0C] min-h-screen w-full">
        <!-- Tombol Panah -->
        <div class="pl-9 pt-9 pb-6">
            <a href="#">
                <button
                    class="circle-button w-12 h-12 rounded-full bg-[#E9BF80] text-3xl flex justify-center items-center">
                    <img src="{{ asset('assets/images/panah.svg') }}" alt="panah" class="w-6 h-6">
                </button>
            </a>
        </div>

        <!-- Judul -->
        <div class="flex flex-col items-start font-Kuunari font-bold text-[#E9BF80] text-4xl pl-24">
            <h2>CAPTAIN BARBERSHOP, BOGOR</h2>
        </div>
        <!-- bintang -->
        <div class="flex mt-2 pl-24">
            @for ($i = 0; $i < 5; $i++)
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                    class="w-3 h-3 text-[#E9BF80] mx-0.5">
                    <path
                        d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.853 1.512 8.259L12 18.896l-7.448 4.522L6.064 15.16 0 9.307l8.332-1.151z" />
                </svg>
            @endfor
        </div>
        <!-- Gambar -->
        <div class="mt-4 px-24 py-6 items-center justify-center flex">
            <img src="{{ asset('assets/images/DashboardBarbershop.png') }}" alt="Foto Barbershop"
                class="w-full h-auto  shadow-lg object-cover">
        </div>
        <!-- Deskripsi -->
        <div class="flex flex-col items-start font-Kuunari font-bold text-[#E9BF80] text-4xl pl-24">
            <h2>DESKRIPSI</h2>
        </div>
        <div class="">
            <p class="text-[#FAFAFA] text-lg font-poppins pl-24 pr-24 mt-2">
                Captain Barbershop adalah tempat barbershop modern yang menghadirkan pengalaman grooming pria dengan
                standar pelayanan terbaik. Dengan tim barber profesional dan berpengalaman, kami menyediakan berbagai
                layanan seperti haircut, hair wash, styling, shaving, hingga perawatan rambut dan wajah.
                Mengusung konsep maskulin, nyaman, dan stylish, Captain Barbershop cocok untuk pria dari segala usia
                yang ingin tampil rapi dan percaya diri. Setiap kunjungan dijamin memberikan hasil yang memuaskan,
                dengan suasana yang ramah dan fasilitas yang mendukung kenyamanan pelanggan.
                Kami juga menggunakan produk-produk berkualitas tinggi untuk memastikan kesehatan dan gaya rambut Anda
                tetap terjaga.
            </p>
        </div>
        <!-- Lokasi -->
        <div class="flex flex-col items-start font-Kuunari font-bold text-[#E9BF80] text-4xl pl-24 py-6">
            <h2>LOKASI</h2>
        </div>
        <div class="mt-4 px-24  items-center justify-center flex">
            <img src="{{ asset('assets/images/mapBarber.png') }}" alt="Foto Barbershop"
                class="w-full h-auto  shadow-lg object-cover">
        </div>
        <!-- Alamat -->
        <div class="px-24 py-4">
            <div class="text-white text-center py-3 border border-[#B5964D] rounded mb-4">
                Jl. Pajajaran Indah V, RT.07/RW.14, Baranangsiang, Kec. Bogor Tim., Kota Bogor, Jawa Barat 16143
            </div>
        </div>
        <!-- Jadwal Operasional Tabel -->
        <div class="overflow-x-auto w-full px-24">
            <table class="table-auto w-full text-center text-white border border-[#B5964D]">
                <thead>
                    <tr class="bg-[#B5964D] font-bold">
                        <th class="border border-[#B5964D] px-2 py-2">Senin</th>
                        <th class="border border-[#B5964D] px-2 py-2">Selasa</th>
                        <th class="border border-[#B5964D] px-2 py-2">Rabu</th>
                        <th class="border border-[#B5964D] px-2 py-2">Kamis</th>
                        <th class="border border-[#B5964D] px-2 py-2">Jumat</th>
                        <th class="border border-[#B5964D] px-2 py-2">Sabtu</th>
                        <th class="border border-[#B5964D] px-2 py-2">Minggu</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @for ($i = 0; $i < 7; $i++)
                            <td class="border border-[#B5964D] px-2 py-2">10.00–21.00</td>
                        @endfor
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Kapster -->
        <div class="flex flex-col items-start font-Kuunari font-bold text-[#E9BF80] text-4xl pl-24 py-6">
            <h2>KAPSTER</h2>
        </div>

        <div class="flex flex-wrap items-center justify-center gap-14 px-10">
            @for ($i = 0; $i < 3; $i++)
                <div class="bg-[#1A1A1A] rounded-lg shadow-md w-72 text-center pt-0">
                    <div class="overflow-hidden rounded-md border-t-4 border-[#E9BF80] px-3 pt-3">
                        <img src="{{ asset('assets/images/kapster.png') }}" alt="Kapster Arjuna"
                            class="w-full h-56 object-cover rounded-md" />
                    </div>
                    <div class="text-white font-bold py-4 text-2xl font-kunari">ARJUNA</div>
                </div>
            @endfor
        </div>

        <!-- HARGA DAN LAYANAN -->
        <div class="px-24 mt-16">
            <h2 class="font-Kuunari font-bold text-[#E9BF80] text-4xl pl-4 py-6">HARGA DAN LAYANAN</h2>

            <div class="flex flex-wrap text-center justify-center gap-14">
                <!-- Card Layanan -->
                <div class="bg-[#1A1A1A] rounded-lg shadow-lg w-72 text-center px-4 py-6 border-t-4 border-[#E9BF80]">
                    <h3 class="text-white text-sm font-Poppins font-semibold mb-1">HAIRCUT PREMIUM</h3>
                    <div class="text-[#B5964D] text-6xl font-Kuunari font-bold mb-3">60K</div>
                    <ul class="text-white text-sm mb-4 space-y-4">
                        <li>Cutting & Styling</li>
                        <li>Hair Wash Premium</li>
                        <li>Konsultasi Gaya</li>
                        <li>±30 menit</li>
                    </ul>
                    <button class="bg-[#B5964D] text-black font-semibold py-2 px-4 rounded text-sm hover:bg-[#d5ac5a]">
                        RESERVASI SEKARANG
                    </button>
                </div>

                <!-- Card Layanan 2 -->
                <div class="bg-[#1A1A1A] rounded-lg shadow-lg w-72 text-center px-4 py-6 border-t-4 border-[#E9BF80]">
                    <h3 class="text-white text-sm font-Poppins font-semibold mb-1">HAIR COLOURING</h3>
                    <div class="text-[#B5964D] text-6xl font-Kuunari font-bold mb-3">120K</div>
                    <ul class="text-white text-sm mb-4 space-y-4">
                        <li>Cutting & Colouring</li>
                        <li>Hair Wash Premium</li>
                        <li>Konsultasi Warna</li>
                        <li>±45 menit</li>
                    </ul>
                    <button class="bg-[#B5964D] text-black font-semibold py-2 px-4 rounded text-sm hover:bg-[#d5ac5a]">
                        RESERVASI SEKARANG
                    </button>
                </div>

                <!-- Card Layanan 3 -->
                <div class="bg-[#1A1A1A] rounded-lg shadow-lg w-72 text-center px-4 py-6 border-t-4 border-[#E9BF80]">
                    <h3 class="text-white text-sm font-Poppins font-semibold mb-1">KIDS HAIRCUT</h3>
                    <div class="text-[#B5964D] text-6xl font-Kuunari font-bold mb-3">45K</div>
                    <ul class="text-white text-sm mb-4 space-y-4">
                        <li>Cutting & Styling</li>
                        <li>Hair Wash Premium</li>
                        <li>Konsultasi Gaya</li>
                        <li>±25 menit</li>
                    </ul>
                    <button class="bg-[#B5964D] text-black font-semibold py-2 px-4 rounded text-sm hover:bg-[#d5ac5a]">
                        RESERVASI SEKARANG
                    </button>
                </div>
            </div>
        </div>

        <!-- Penilaian -->
        <div class="flex flex-col items-start font-Kuunari font-bold text-[#E9BF80] text-4xl pl-24 py-6">
            <h2>PENILAIAN BABERSHOP</h2>
        </div>
        <!-- ULASAN -->
        <div class="bg-[#000000] mt-6 px-24">
            <!-- Skor dan Filter -->
            <div class="bg-[#1A1A1A] p-6 rounded-md mb-10">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <!-- Skor -->
                    <div class="text-white text-4xl font-Kuunari flex flex-col items-center md:items-start gap-2">
                        <div class="flex items-end gap-2">
                            <span class="text-[#E9BF80] text-5xl font-bold">4.9</span>
                            <span class="text-white text-xl">dari</span>
                            <span class="text-[#E9BF80] text-5xl font-bold">5</span>
                        </div>

                        <!-- Bintang Kosong -->
                        <div class="flex text-[#E9BF80] text-3xl mt-1">
                            @for ($i = 0; $i < 5; $i++)
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                                    class="w-3 h-3 text-[#E9BF80] mx-0.5">
                                    <path
                                        d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.853 1.512 8.259L12 18.896l-7.448 4.522L6.064 15.16 0 9.307l8.332-1.151z" />
                                </svg>
                            @endfor
                        </div>
                    </div>

                    <!-- Filter -->
                    <div class="flex flex-wrap gap-8 mt-4 md:mt-0 justify-center max-w-4xl mx-auto">
                        <button
                            class="bg-[#0C0C0C] text-white border border-[#B5964D] px-4 py-1 rounded hover:bg-[#B5964D] hover:text-black">
                            Semua
                        </button>
                        <button class="bg-[#0C0C0C] text-white px-4 py-1 rounded">5 Bintang (2RB)</button>
                        <button class="bg-[#0C0C0C] text-white px-4 py-1 rounded">4 Bintang (153)</button>
                        <button class="bg-[#0C0C0C] text-white px-4 py-1 rounded">3 Bintang (20)</button>
                        <button class="bg-[#0C0C0C] text-white px-4 py-1 rounded">2 Bintang (10)</button>
                        <button class="bg-[#0C0C0C] text-white px-4 py-1 rounded">1 Bintang (5)</button>
                        <button class="bg-[#0C0C0C] text-white px-4 py-1 rounded">Dengan Media (1RB)</button>
                    </div>
                </div>
            </div>

            <!-- Daftar Ulasan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @for ($i = 0; $i < 4; $i++)
                    <div
                        class="border border-[#E9BF80] border-b-4 rounded-lg p-5 flex gap-4 shadow-md shadow-[#E9BF80]/30">
                        <!-- Avatar -->
                        <div class="w-14 h-10 rounded-full bg-white border border-[#E9BF80]"></div>

                        <!-- Konten -->
                        <div class="text-white">
                            <h4 class="font-bold">Anonimus Ganteng</h4>
                            <div class="flex items-center gap-1 text-[#E9BF80] text-sm">
                                @for ($j = 0; $j < 5; $j++)
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                                        class="w-3 h-3 text-[#E9BF80] mx-0.5">
                                        <path
                                            d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.853 1.512 8.259L12 18.896l-7.448 4.522L6.064 15.16 0 9.307l8.332-1.151z" />
                                    </svg>
                                @endfor
                            </div>
                            <p class="text-xs text-[#888888] mb-2">2024-05-05 00:06</p>
                            <p class="text-sm">
                                Potongan di sini luar biasa! Hasilnya presisi, barbernya ramah, dan tempatnya nyaman.
                                Pasti balik lagi!
                            </p>
                        </div>
                    </div>
                @endfor

            </div>

            <!-- Tombol Lainnya -->
            <div class="flex justify-center mt-10">
                <button class="text-white font-Kuunari font-bold text-xl hover:underline">
                    LAINNYA →
                </button>
            </div>
        </div>

    </div>
</x-app-layout>
