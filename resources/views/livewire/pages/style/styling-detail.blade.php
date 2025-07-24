<div>

    <div class="">
        <div class="relative w-full h-80">
            <div class="absolute inset-0">
                <img src="{{ asset(path: 'assets/images/ImgStyle.png') }}" class="w-full h-full object-cover " />
                <!-- Overlay Filter Warna -->
                <div class="absolute inset-0 bg-Ecru/70 mix-blend-multiply"></div>
            </div>

            <div class="absolute inset-0 flex flex-col gap-4 items-center justify-center z-10">
                <h1 class="text-white text-6xl font-Kuunari">SEE YOUR STYLE</h1>
                <h1 class="text-Ecru text-6xl font-Kuunari">CUT YOUR HAIR</h1>
            </div>
        </div>

        <div class="relative w-full flex flex-col gap-6 mb-16 my-5 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-center w-full">
                <img src="{{ asset(path: 'assets/images/logoS.png') }}" class="w-24 sm:w-28 md:w-32"
                    alt="Logo SEECUT" />
            </div>

            <div class="flex items-center justify-center w-full">
                <h1 class="text-white text-3xl sm:text-4xl md:text-4xl font-Kuunari text-center px-2">
                    REKOMENDASI GAYA RAMBUT TERBAIK
                </h1>
            </div>

            <div class="flex items-center justify-center w-full">
                <p
                    class="text-white text-sm text-justify sm:text-xs md:text-lg font-Poppins font-light md:text-center max-w-xl sm:max-w-2xl md:max-w-3xl mx-auto px-5">
                    Temukan inspirasi gaya rambut dari berbagai model yang telah terkurasi oleh para profesional dan
                    mendapatkan ulasan terbaik dari pelanggan. Jadikan penampilan Anda lebih percaya diri dengan
                    rekomendasi eksklusif langsung dari platform SEECUT.
                </p>
            </div>
        </div>


        <!-- Swiper -->
        <div class="relative w-full h-[500px]">
            <!-- Background Gambar -->
            <img src="{{ asset('assets/images/wave.png') }}"
                class="absolute inset-0 w-full h-full object-cover z-0 opacity-10" alt="Background" />

            <!-- Overlay (Opsional) -->
            <div class="absolute inset-0 z-0"></div>

            <!-- Swiper Content -->
            <div class="swiper styling-detail-swiper relative z-10 flex items-center">
                <div class="swiper-wrapper mb-8">
                    @foreach ($hairStyles as $style)
                        <div class="swiper-slide">
                            <div
                                class="swiper-slide-transform group rounded-md overflow-hidden  bg-[#1A1A1A] text-center">
                                <!-- Garis atas -->
                                <div class="h-1 bg-Ecru w-full group-hover:bg-Satin-Sheen-Yellow"></div>

                                <!-- Gambar -->
                                <img src="{{ asset('assets/images/' . $style['image']) }}" alt="{{ $style['name'] }}"
                                    class="w-full h-72 object-cover">

                                <!-- Konten -->
                                <div class="p-4">
                                    <h3 class="text-Dun font-Kuunari text-4xl mb-2 uppercase">{{ $style['name'] }}</h3>
                                    <p class="text-white text-sm font-light leading-relaxed">
                                        {{ $style['description'] }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="swiper-pagination"></div>
            </div>
        </div>

        <div class="relative w-full flex flex-col gap-6 mb-16 my-5 px-4 sm:px-6 lg:px-8 mt-16 items-center">
            <div class="flex items-center justify-center w-full">
                <h1 class="text-Ecru text-4xl font-Kuunari text-center px-2">
                    MASIH BINGUNG JUGA PILIH GAYA RAMBUT?
                </h1>
            </div>

            <div class="flex items-center justify-center w-full mb-3">
                <p
                    class="text-white text-sm text-justify sm:text-xs md:text-lg font-Poppins font-light md:text-center max-w-xl sm:max-w-2xl md:max-w-3xl mx-auto px-5">
                    Udah lama nyari gaya rambut yang pas buat kamu, tapi kok belum nemu juga yang cocok banget? Jangan
                    khawatir, langsung tanya aja ke AI kami dan dapatkan rekomendasi gaya rambut yang paling sesuai
                    dengan kamu!
                </p>
            </div>

            <a href="{{ route('style.recommendation') }}"
                class="flex items-center justify-center h-[50px] sm:h-[60px] w-[200px] sm:w-[240px] 
          bg-Ecru hover:bg-Field-Drab 
          text-Taupe hover:text-white 
          text-sm sm:text-sm md:text-base lg:text-lg 
          font-Kuunari text-center px-2 
          rounded-sm transition-colors duration-300">
                REKOMENDASI SEKARANG
            </a>

        </div>
    </div>
</div>
