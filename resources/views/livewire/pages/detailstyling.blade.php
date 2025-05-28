<x-layouts.app>

    <div class="flex flex-col gap-5">
        {{-- Div pertama --}}
        <div class="relative w-full h-80">
            <!-- Layer 1: Gambar -->
            <div class="absolute inset-0">
                <img src="{{ asset(path: 'assets/images/ImgStyle.png') }}" class="w-full h-full object-cover" />
            </div>

            <!-- Layer 2: Tulisan -->
            <div class="absolute inset-0 flex flex-col gap-4 items-center justify-center z-10">
                <h1 class="text-white text-6xl font-Kuunari">SEE YOUR STYLE</h1>
                <h1 class="text-Ecru text-6xl font-Kuunari">CUT YOUR HAIR</h1>
            </div>
        </div>

        {{-- Div kedua --}}
        <div class="relative w-full  flex flex-col gap-6 mb-20">
            <div class="flex items-center justify-center w-full">
                <img src="{{ asset(path: 'assets/images/logoS.png') }}" class="w-30" />
            </div>

            <div class="flex items-center justify-center w-full">
                <h1 class="text-white text-4xl font-Kuunari">REKOMENDASI GAYA RAMBUT TERBAIK</h1>
            </div>

            <div class="flex items-center justify-center w-full">
                <p class="text-white text-l font-Poppins font-light text-center max-w-3xl mx-auto">Temukan inspirasi
                    gaya rambut dari berbagai model yang telah terkurasi oleh para profesional dan mendapatkan ulasan
                    terbaik dari pelanggan. Jadikan penampilan Anda lebih percaya diri dengan rekomendasi eksklusif
                    langsung dari platform SEECUT. </p>
            </div>
        </div>

        {{-- <div class="flex flex-col items-center justify-center">
            <div class="grid grid-cols-3 gap-14 ">
                @foreach ($hairStyles as $style)
                    <div
                        class="group w-64 rounded-md overflow-hidden shadow-lg bg-[#1A1A1A] text-center transition-transform duration-300 transform hover:scale-105">

                        <!-- Garis atas -->
                        <div
                            class="h-1 bg-Ecru w-full transition-colors duration-300 group-hover:bg-Satin-Sheen-Yellow">
                        </div>

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
                @endforeach

            </div>
        </div> --}}
        <div class="w-full flex justify-center items-center mb-5">
            <div class="bg-[#1A1A1A] flex flex-col rounded-md shadow-lg overflow-hidden group max-w-lg">
                <!-- Garis emas di atas -->
                <div class="h-1 w-full bg-yellow-400 transition-colors duration-300 group-hover:bg-yellow-500"></div>

                <!-- Isi card -->
                <div class="flex flex-row">
                    <!-- Gambar -->
                    <div class="p-5 w-60">
                        <img src="{{ asset('assets/images/crewcut.jpg') }}" alt="Taper Cut"
                            class="rounded-md w-full h-auto object-cover">
                    </div>

                    <!-- Deskripsi -->
                    <div class="py-5 pr-5 text-white">
                        <h1 class="text-2xl font-semibold mb-1">Taper Cut</h1>
                        <h2 class="text-yellow-400 font-medium mb-2">Jenis Kepala: Oval</h2>
                        <p class="text-sm leading-relaxed">
                            Gaya potong super pendek yang praktis dan memberikan kesan bersih serta tegas.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-layouts.app>
