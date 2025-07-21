<div class="flex flex-col bg-[#0C0C0C] min-h-screen w-full px-48">
    <!-- Back Button -->
    <div class="px-6 sm:px-8 md:px-12 pt-8 pb-6 animate-fade-in">
        <a href="#" class="inline-block">
            <button
                class="circle-button w-12 h-12 rounded-full bg-[#E9BF80] text-3xl flex justify-center items-center transition-all duration-300 hover:bg-[#d5ac5a] hover:scale-110 hover:shadow-lg hover:shadow-[#E9BF80]/30">
                <img src="{{ asset('assets/images/panah.svg') }}" alt="Back"
                    class="w-6 h-6 transition-transform duration-200">
            </button>
        </a>
    </div>

    <!-- Title -->
    <div class="px-6 sm:px-8 md:px-12 lg:px-16 xl:px-24 animate-slide-in-left">
        <h1
            class="font-Kuunari font-bold text-[#E9BF80] text-2xl sm:text-3xl md:text-4xl transition-all duration-300 hover:text-[#d5ac5a]">
            CAPTAIN BARBERSHOP, BOGOR
        </h1>
    </div>

    <!-- Star Rating -->
    <div class="flex mt-3 px-6 sm:px-8 md:px-12 lg:px-16 xl:px-24 animate-fade-in-delay">
        @for ($i = 0; $i < 5; $i++)
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                class="w-4 h-4 text-[#E9BF80] mx-0.5 transition-all duration-200 hover:scale-125 hover:text-[#d5ac5a] animate-bounce-subtle"
                style="animation-delay: {{ $i * 0.1 }}s">
                <path
                    d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.853 1.512 8.259L12 18.896l-7.448 4.522L6.064 15.16 0 9.307l8.332-1.151z" />
            </svg>
        @endfor
    </div>
    <!-- Hero Image -->
    <div class="mt-6 px-6 sm:px-8 md:px-12 lg:px-16 xl:px-24 py-6 flex justify-center animate-zoom-in">
        <img src="{{ asset('assets/images/DashboardBarbershop.png') }}" alt="Captain Barbershop"
            class="w-full max-w-4xl h-auto shadow-2xl object-cover rounded-xl transition-all duration-500 hover:scale-105 hover:shadow-[#E9BF80]/30">
    </div>
    <!-- Description Section -->
    <section class="px-6 sm:px-8 md:px-12 lg:px-16 xl:px-24 py-8">
        <h2
            class="font-Kuunari font-bold text-[#E9BF80] text-2xl sm:text-3xl md:text-4xl mb-6 animate-slide-in-left transition-all duration-300 hover:text-[#d5ac5a]">
            DESKRIPSI
        </h2>
        <div class="animate-fade-in-delay">
            <p
                class="text-[#FAFAFA] text-base sm:text-lg font-poppins leading-relaxed max-w-4xl transition-all duration-300 hover:text-white">
                Captain Barbershop adalah tempat barbershop modern yang menghadirkan pengalaman grooming pria dengan
                standar pelayanan terbaik. Dengan tim barber profesional dan berpengalaman, kami menyediakan berbagai
                layanan seperti haircut, hair wash, styling, shaving, hingga perawatan rambut dan wajah.
                <br><br>
                Mengusung konsep maskulin, nyaman, dan stylish, Captain Barbershop cocok untuk pria dari segala usia
                yang ingin tampil rapi dan percaya diri. Setiap kunjungan dijamin memberikan hasil yang memuaskan,
                dengan suasana yang ramah dan fasilitas yang mendukung kenyamanan pelanggan.
                <br><br>
                Kami juga menggunakan produk-produk berkualitas tinggi untuk memastikan kesehatan dan gaya rambut Anda
                tetap terjaga.
            </p>
        </div>
    </section>
    <!-- Location Section -->
    <section class="px-6 sm:px-8 md:px-12 lg:px-16 xl:px-24 py-8">
        <h2
            class="font-Kuunari font-bold text-[#E9BF80] text-2xl sm:text-3xl md:text-4xl mb-6 animate-slide-in-left transition-all duration-300 hover:text-[#d5ac5a]">
            LOKASI
        </h2>
        <div class="flex justify-center animate-zoom-in">
            <img src="{{ asset('assets/images/mapBarber.png') }}" alt="Map Captain Barbershop"
                class="w-full max-w-4xl h-auto shadow-2xl object-cover rounded-xl transition-all duration-500 hover:scale-105 hover:shadow-[#E9BF80]/30">
        </div>

        <!-- Address -->
        <div class="mt-6 animate-fade-in-delay">
            <div
                class="bg-[#1A1A1A] text-white text-center py-4 px-6 border border-[#B5964D] rounded-xl mb-6 max-w-4xl mx-auto transition-all duration-300 hover:bg-[#B5964D]/10 hover:border-[#E9BF80] hover:shadow-lg hover:shadow-[#B5964D]/20">
                <p class="font-medium text-sm sm:text-base">
                    Jl. Pajajaran Indah V, RT.07/RW.14, Baranangsiang, Kec. Bogor Tim., Kota Bogor, Jawa Barat 16143
                </p>
            </div>
        </div>
    </section>
    <!-- Schedule Section -->
    <section class="px-6 sm:px-8 md:px-12 lg:px-16 xl:px-24 py-8">
        <div class="overflow-x-auto animate-slide-in-up">
            <table
                class="table-auto w-full text-center text-white border border-[#B5964D] rounded-xl overflow-hidden shadow-2xl max-w-4xl mx-auto">
                <thead>
                    <tr class="bg-[#B5964D] font-bold text-black">
                        <th class="px-3 py-4 text-xs sm:text-sm transition-colors duration-200 hover:bg-[#d5ac5a]">Senin
                        </th>
                        <th class="px-3 py-4 text-xs sm:text-sm transition-colors duration-200 hover:bg-[#d5ac5a]">
                            Selasa</th>
                        <th class="px-3 py-4 text-xs sm:text-sm transition-colors duration-200 hover:bg-[#d5ac5a]">Rabu
                        </th>
                        <th class="px-3 py-4 text-xs sm:text-sm transition-colors duration-200 hover:bg-[#d5ac5a]">Kamis
                        </th>
                        <th class="px-3 py-4 text-xs sm:text-sm transition-colors duration-200 hover:bg-[#d5ac5a]">Jumat
                        </th>
                        <th class="px-3 py-4 text-xs sm:text-sm transition-colors duration-200 hover:bg-[#d5ac5a]">Sabtu
                        </th>
                        <th class="px-3 py-4 text-xs sm:text-sm transition-colors duration-200 hover:bg-[#d5ac5a]">
                            Minggu</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-[#1A1A1A]/80">
                        @for ($i = 0; $i < 7; $i++)
                            <td
                                class="px-3 py-4 text-xs sm:text-sm font-medium transition-colors duration-200 hover:bg-[#B5964D]/20">
                                10.00–21.00
                            </td>
                        @endfor
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
    <!-- Staff Section -->
    <section class="px-6 sm:px-8 md:px-12 lg:px-16 xl:px-24 py-8">
        <h2
            class="font-Kuunari font-bold text-[#E9BF80] text-2xl sm:text-3xl md:text-4xl mb-8 animate-slide-in-left transition-all duration-300 hover:text-[#d5ac5a]">
            KAPSTER
        </h2>

        <div class="flex flex-wrap justify-center gap-6 sm:gap-8 md:gap-12 animate-cards-up">
            @for ($i = 0; $i < 3; $i++)
                <div class="bg-[#1A1A1A] rounded-xl shadow-xl w-full max-w-xs text-center pt-0 transition-all duration-500 hover:scale-105 hover:shadow-2xl hover:shadow-[#E9BF80]/30 hover:-translate-y-3 group"
                    style="animation-delay: {{ $i * 0.2 }}s">
                    <div
                        class="overflow-hidden rounded-t-xl border-t-4 border-[#E9BF80] p-4 group-hover:border-[#d5ac5a] transition-colors duration-300">
                        <img src="{{ asset('assets/images/kapster.png') }}" alt="Kapster Arjuna"
                            class="w-full h-48 sm:h-56 object-cover rounded-lg transition-transform duration-500 group-hover:scale-110" />
                    </div>
                    <div
                        class="text-white font-bold py-6 text-xl sm:text-2xl font-kunari transition-colors duration-300 group-hover:text-[#E9BF80]">
                        ARJUNA
                    </div>
                </div>
            @endfor
        </div>
    </section>

    <!-- Services Section -->
    <section class="px-6 sm:px-8 md:px-12 lg:px-16 xl:px-24 py-8">
        <h2
            class="font-Kuunari font-bold text-[#E9BF80] text-2xl sm:text-3xl md:text-4xl mb-8 animate-slide-in-left transition-all duration-300 hover:text-[#d5ac5a]">
            HARGA DAN LAYANAN
        </h2>

        <div class="flex flex-wrap justify-center gap-6 sm:gap-8 md:gap-12 animate-cards-up">
            <!-- Haircut Premium Card -->
            <div class="bg-[#1A1A1A] rounded-xl shadow-xl w-full max-w-xs text-center px-6 py-8 border-t-4 border-[#E9BF80] transition-all duration-500 hover:scale-105 hover:shadow-2xl hover:shadow-[#E9BF80]/30 hover:-translate-y-3 group cursor-pointer"
                onclick="openServiceModal('haircut')" style="animation-delay: 0.1s">
                <h3
                    class="text-white text-sm font-Poppins font-semibold mb-3 transition-colors duration-300 group-hover:text-[#E9BF80]">
                    HAIRCUT PREMIUM
                </h3>
                <div
                    class="text-[#B5964D] text-5xl sm:text-6xl font-Kuunari font-bold mb-4 transition-colors duration-300 group-hover:text-[#E9BF80]">
                    60K
                </div>
                <ul class="text-white text-sm mb-6 space-y-3 transition-colors duration-300 group-hover:text-gray-200">
                    <li>Cutting & Styling</li>
                    <li>Hair Wash Premium</li>
                    <li>Konsultasi Gaya</li>
                    <li>±30 menit</li>
                </ul>
                <button
                    class="bg-[#B5964D] text-black font-semibold py-3 px-6 rounded-lg text-sm transition-all duration-300 hover:bg-[#E9BF80] hover:shadow-lg transform hover:scale-105 active:scale-95 w-full">
                    LIHAT DETAIL
                </button>
            </div>

            <!-- Hair Colouring Card -->
            <div class="bg-[#1A1A1A] rounded-xl shadow-xl w-full max-w-xs text-center px-6 py-8 border-t-4 border-[#E9BF80] transition-all duration-500 hover:scale-105 hover:shadow-2xl hover:shadow-[#E9BF80]/30 hover:-translate-y-3 group cursor-pointer"
                onclick="openServiceModal('colouring')" style="animation-delay: 0.3s">
                <h3
                    class="text-white text-sm font-Poppins font-semibold mb-3 transition-colors duration-300 group-hover:text-[#E9BF80]">
                    HAIR COLOURING
                </h3>
                <div
                    class="text-[#B5964D] text-5xl sm:text-6xl font-Kuunari font-bold mb-4 transition-colors duration-300 group-hover:text-[#E9BF80]">
                    120K
                </div>
                <ul class="text-white text-sm mb-6 space-y-3 transition-colors duration-300 group-hover:text-gray-200">
                    <li>Cutting & Colouring</li>
                    <li>Hair Wash Premium</li>
                    <li>Konsultasi Warna</li>
                    <li>±45 menit</li>
                </ul>
                <button
                    class="bg-[#B5964D] text-black font-semibold py-3 px-6 rounded-lg text-sm transition-all duration-300 hover:bg-[#E9BF80] hover:shadow-lg transform hover:scale-105 active:scale-95 w-full">
                    LIHAT DETAIL
                </button>
            </div>

            <!-- Kids Haircut Card -->
            <div class="bg-[#1A1A1A] rounded-xl shadow-xl w-full max-w-xs text-center px-6 py-8 border-t-4 border-[#E9BF80] transition-all duration-500 hover:scale-105 hover:shadow-2xl hover:shadow-[#E9BF80]/30 hover:-translate-y-3 group cursor-pointer"
                onclick="openServiceModal('kids')" style="animation-delay: 0.5s">
                <h3
                    class="text-white text-sm font-Poppins font-semibold mb-3 transition-colors duration-300 group-hover:text-[#E9BF80]">
                    KIDS HAIRCUT
                </h3>
                <div
                    class="text-[#B5964D] text-5xl sm:text-6xl font-Kuunari font-bold mb-4 transition-colors duration-300 group-hover:text-[#E9BF80]">
                    45K
                </div>
                <ul class="text-white text-sm mb-6 space-y-3 transition-colors duration-300 group-hover:text-gray-200">
                    <li>Cutting & Styling</li>
                    <li>Hair Wash Premium</li>
                    <li>Konsultasi Gaya</li>
                    <li>±25 menit</li>
                </ul>
                <button
                    class="bg-[#B5964D] text-black font-semibold py-3 px-6 rounded-lg text-sm transition-all duration-300 hover:bg-[#E9BF80] hover:shadow-lg transform hover:scale-105 active:scale-95 w-full">
                    LIHAT DETAIL
                </button>
            </div>
        </div>
    </section>

    <!-- Reviews Section -->
    <section class="px-6 sm:px-8 md:px-12 lg:px-16 xl:px-24 py-8">
        <h2
            class="font-Kuunari font-bold text-[#E9BF80] text-2xl sm:text-3xl md:text-4xl mb-8 animate-slide-in-left transition-all duration-300 hover:text-[#d5ac5a]">
            PENILAIAN BARBERSHOP
        </h2>

        <!-- Rating Overview -->
        <div
            class="bg-[#1A1A1A] p-6 sm:p-8 rounded-xl mb-8 transition-all duration-300 hover:bg-[#1F1F1F] animate-fade-in-delay max-w-6xl mx-auto">
            <div class="flex flex-col lg:flex-row justify-between items-center gap-6">
                <!-- Rating Score -->
                <div class="text-white text-center lg:text-left">
                    <div class="flex items-end justify-center lg:justify-start gap-2 animate-number-bounce mb-3">
                        <span
                            class="text-[#E9BF80] text-4xl sm:text-5xl font-bold font-Kuunari transition-all duration-300 hover:scale-110">4.9</span>
                        <span class="text-white text-lg sm:text-xl">dari</span>
                        <span
                            class="text-[#E9BF80] text-4xl sm:text-5xl font-bold font-Kuunari transition-all duration-300 hover:scale-110">5</span>
                    </div>

                    <!-- Star Rating -->
                    <div class="flex justify-center lg:justify-start text-[#E9BF80]">
                        @for ($i = 0; $i < 5; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                                class="w-5 h-5 mx-0.5 transition-all duration-200 hover:scale-125 hover:text-[#d5ac5a] animate-bounce-subtle"
                                style="animation-delay: {{ $i * 0.1 }}s">
                                <path
                                    d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.853 1.512 8.259L12 18.896l-7.448 4.522L6.064 15.16 0 9.307l8.332-1.151z" />
                            </svg>
                        @endfor
                    </div>
                </div>

                <!-- Filter Buttons -->
                <div class="flex flex-wrap justify-center lg:justify-end gap-2 sm:gap-3">
                    <button
                        class="bg-[#B5964D] text-black border border-[#B5964D] px-3 sm:px-4 py-2 rounded-lg text-xs sm:text-sm font-medium transition-all duration-300 hover:bg-[#E9BF80] hover:scale-105 hover:shadow-lg">
                        Semua
                    </button>
                    <button
                        class="bg-[#0C0C0C] text-white px-3 sm:px-4 py-2 rounded-lg border border-transparent text-xs sm:text-sm transition-all duration-300 hover:border-[#B5964D] hover:bg-[#1A1A1A]">
                        5★ (2RB)
                    </button>
                    <button
                        class="bg-[#0C0C0C] text-white px-3 sm:px-4 py-2 rounded-lg border border-transparent text-xs sm:text-sm transition-all duration-300 hover:border-[#B5964D] hover:bg-[#1A1A1A]">
                        4★ (153)
                    </button>
                    <button
                        class="bg-[#0C0C0C] text-white px-3 sm:px-4 py-2 rounded-lg border border-transparent text-xs sm:text-sm transition-all duration-300 hover:border-[#B5964D] hover:bg-[#1A1A1A]">
                        3★ (20)
                    </button>
                </div>
            </div>
        </div>

        <!-- Review Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 animate-reviews-fade-in max-w-6xl mx-auto mb-8">
            @for ($i = 0; $i < 4; $i++)
                <div class="border border-[#E9BF80] border-b-4 rounded-xl p-6 flex gap-4 shadow-lg shadow-[#E9BF80]/20 transition-all duration-300 hover:shadow-xl hover:shadow-[#E9BF80]/40 hover:-translate-y-2 hover:border-[#d5ac5a] group"
                    style="animation-delay: {{ $i * 0.1 }}s">
                    <!-- Avatar -->
                    <div
                        class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-gradient-to-br from-[#E9BF80] to-[#B5964D] border-2 border-[#E9BF80] flex items-center justify-center transition-transform duration-300 group-hover:scale-110">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-white"></div>
                    </div>

                    <!-- Review Content -->
                    <div class="text-white flex-1">
                        <h4
                            class="font-bold text-sm sm:text-base transition-colors duration-300 group-hover:text-[#E9BF80] mb-2">
                            Anonimus Ganteng
                        </h4>
                        <div class="flex items-center gap-1 text-[#E9BF80] text-sm mb-2">
                            @for ($j = 0; $j < 5; $j++)
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                                    class="w-3 h-3 transition-all duration-200 hover:scale-125"
                                    style="animation-delay: {{ $j * 0.05 }}s">
                                    <path
                                        d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.853 1.512 8.259L12 18.896l-7.448 4.522L6.064 15.16 0 9.307l8.332-1.151z" />
                                </svg>
                            @endfor
                        </div>
                        <p class="text-xs text-[#888888] mb-3 transition-colors duration-300 group-hover:text-[#aaa]">
                            2024-05-05 00:06
                        </p>
                        <p class="text-sm leading-relaxed transition-colors duration-300 group-hover:text-gray-200">
                            Potongan di sini luar biasa! Hasilnya presisi, barbernya ramah, dan tempatnya nyaman. Pasti
                            balik lagi!
                        </p>
                    </div>
                </div>
            @endfor
        </div>

        <!-- Load More Button -->
        <div class="flex justify-center animate-fade-in-delay">
            <button
                class="text-white font-Kuunari font-bold text-lg sm:text-xl transition-all duration-300 hover:text-[#E9BF80] hover:scale-105 group">
                <span class="flex items-center gap-2">
                    LAINNYA
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1"
                        fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </span>
            </button>
        </div>
    </section>

    <!-- Service Modals -->
    <!-- Haircut Premium Modal -->
    <div id="haircutModal"
        class="fixed inset-0 bg-black bg-opacity-75 backdrop-blur-sm flex items-center justify-center z-50 opacity-0 pointer-events-none transition-all duration-300">
        <div
            class="bg-[#1A1A1A] rounded-2xl p-8 max-w-lg w-full mx-4 border-2 border-[#E9BF80] transform scale-95 transition-all duration-300 shadow-2xl shadow-[#E9BF80]/20">
            <div class="flex justify-between items-start mb-6">
                <h3 class="text-[#E9BF80] text-2xl font-Kuunari font-bold">HAIRCUT PREMIUM</h3>
                <button onclick="closeServiceModal('haircut')"
                    class="text-white hover:text-[#E9BF80] transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="text-center mb-6">
                <div class="text-[#B5964D] text-6xl font-Kuunari font-bold mb-4">60K</div>
                <div class="text-white text-lg mb-6">Durasi: ±30 menit</div>
            </div>

            <div class="mb-8">
                <h4 class="text-[#E9BF80] text-lg font-semibold mb-4">Layanan Termasuk:</h4>
                <ul class="text-white space-y-3">
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-[#E9BF80] rounded-full mr-3"></span>
                        Konsultasi gaya rambut sesuai bentuk wajah
                    </li>
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-[#E9BF80] rounded-full mr-3"></span>
                        Potong rambut dengan teknik profesional
                    </li>
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-[#E9BF80] rounded-full mr-3"></span>
                        Hair wash dengan shampo premium
                    </li>
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-[#E9BF80] rounded-full mr-3"></span>
                        Styling rambut sesuai keinginan
                    </li>
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-[#E9BF80] rounded-full mr-3"></span>
                        Hair tonic dan finishing treatment
                    </li>
                </ul>
            </div>

            <button
                class="w-full bg-[#B5964D] text-black font-semibold py-4 rounded-xl text-lg transition-all duration-300 hover:bg-[#E9BF80] hover:shadow-lg transform hover:scale-105 active:scale-95">
                RESERVASI SEKARANG
            </button>
        </div>
    </div>

    <!-- Hair Colouring Modal -->
    <div id="colouringModal"
        class="fixed inset-0 bg-black bg-opacity-75 backdrop-blur-sm flex items-center justify-center z-50 opacity-0 pointer-events-none transition-all duration-300">
        <div
            class="bg-[#1A1A1A] rounded-2xl p-8 max-w-lg w-full mx-4 border-2 border-[#E9BF80] transform scale-95 transition-all duration-300 shadow-2xl shadow-[#E9BF80]/20">
            <div class="flex justify-between items-start mb-6">
                <h3 class="text-[#E9BF80] text-2xl font-Kuunari font-bold">HAIR COLOURING</h3>
                <button onclick="closeServiceModal('colouring')"
                    class="text-white hover:text-[#E9BF80] transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="text-center mb-6">
                <div class="text-[#B5964D] text-6xl font-Kuunari font-bold mb-4">120K</div>
                <div class="text-white text-lg mb-6">Durasi: ±45 menit</div>
            </div>

            <div class="mb-8">
                <h4 class="text-[#E9BF80] text-lg font-semibold mb-4">Layanan Termasuk:</h4>
                <ul class="text-white space-y-3">
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-[#E9BF80] rounded-full mr-3"></span>
                        Konsultasi warna yang cocok dengan kulit
                    </li>
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-[#E9BF80] rounded-full mr-3"></span>
                        Hair cutting sesuai gaya yang diinginkan
                    </li>
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-[#E9BF80] rounded-full mr-3"></span>
                        Hair colouring dengan produk berkualitas
                    </li>
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-[#E9BF80] rounded-full mr-3"></span>
                        Hair wash dengan shampo premium
                    </li>
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-[#E9BF80] rounded-full mr-3"></span>
                        Hair treatment untuk kesehatan rambut
                    </li>
                </ul>
            </div>

            <button
                class="w-full bg-[#B5964D] text-black font-semibold py-4 rounded-xl text-lg transition-all duration-300 hover:bg-[#E9BF80] hover:shadow-lg transform hover:scale-105 active:scale-95">
                RESERVASI SEKARANG
            </button>
        </div>
    </div>

    <!-- Kids Haircut Modal -->
    <div id="kidsModal"
        class="fixed inset-0 bg-black bg-opacity-75 backdrop-blur-sm flex items-center justify-center z-50 opacity-0 pointer-events-none transition-all duration-300">
        <div
            class="bg-[#1A1A1A] rounded-2xl p-8 max-w-lg w-full mx-4 border-2 border-[#E9BF80] transform scale-95 transition-all duration-300 shadow-2xl shadow-[#E9BF80]/20">
            <div class="flex justify-between items-start mb-6">
                <h3 class="text-[#E9BF80] text-2xl font-Kuunari font-bold">KIDS HAIRCUT</h3>
                <button onclick="closeServiceModal('kids')"
                    class="text-white hover:text-[#E9BF80] transition-colors duration-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="text-center mb-6">
                <div class="text-[#B5964D] text-6xl font-Kuunari font-bold mb-4">45K</div>
                <div class="text-white text-lg mb-6">Durasi: ±25 menit</div>
            </div>

            <div class="mb-8">
                <h4 class="text-[#E9BF80] text-lg font-semibold mb-4">Layanan Termasuk:</h4>
                <ul class="text-white space-y-3">
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-[#E9BF80] rounded-full mr-3"></span>
                        Potong rambut khusus anak dengan sabar
                    </li>
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-[#E9BF80] rounded-full mr-3"></span>
                        Hair wash lembut untuk anak-anak
                    </li>
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-[#E9BF80] rounded-full mr-3"></span>
                        Styling rambut yang fun dan rapi
                    </li>
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-[#E9BF80] rounded-full mr-3"></span>
                        Lingkungan yang ramah anak
                    </li>
                    <li class="flex items-center">
                        <span class="w-2 h-2 bg-[#E9BF80] rounded-full mr-3"></span>
                        Barber berpengalaman dengan anak
                    </li>
                </ul>
            </div>

            <button
                class="w-full bg-[#B5964D] text-black font-semibold py-4 rounded-xl text-lg transition-all duration-300 hover:bg-[#E9BF80] hover:shadow-lg transform hover:scale-105 active:scale-95">
                RESERVASI SEKARANG
            </button>
        </div>
    </div>

</div>

<script>
    function openServiceModal(service) {
        const modal = document.getElementById(service + 'Modal');
        const modalContent = modal.querySelector('.bg-\\[\\#1A1A1A\\]');

        modal.classList.remove('pointer-events-none');

        // Animate modal in
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
        }, 10);

        // Prevent body scroll
        document.body.classList.add('overflow-hidden');
    }

    function closeServiceModal(service) {
        const modal = document.getElementById(service + 'Modal');
        const modalContent = modal.querySelector('.bg-\\[\\#1A1A1A\\]');

        // Animate modal out
        modal.classList.add('opacity-0');
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');

        // Remove pointer events and body scroll lock
        setTimeout(() => {
            modal.classList.add('pointer-events-none');
            document.body.classList.remove('overflow-hidden');
        }, 300);
    }

    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('bg-black') && e.target.classList.contains('bg-opacity-75')) {
            const modalId = e.target.id;
            const service = modalId.replace('Modal', '');
            closeServiceModal(service);
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            ['haircut', 'colouring', 'kids'].forEach(service => {
                const modal = document.getElementById(service + 'Modal');
                if (!modal.classList.contains('opacity-0')) {
                    closeServiceModal(service);
                }
            });
        }
    });
</script>
