<div>

    <div class="relative min-h-screen">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0 bg-center bg-contain bg-no-repeat opacity-10"
            style="background-image: url('{{ asset('assets/images/wave.png') }}');">
        </div>

        <div class="relative flex flex-col px-6 md:px-16 lg:px-48">
            <div class="py-10 md:py-12">
                <button
                    class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-Ecru hover:bg-white transition-all duration-300 flex items-center justify-center shadow">
                    <svg width="14" height="28" viewBox="0 0 14 28" fill="none" xmlns="http://www.w3.org/2000/svg"
                        class="w-4 md:w-6 h-6 text-gray-700">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M2.15016 13.1704L8.74999 6.57059L10.3997 8.22026L4.62466 13.9953L10.3997 19.7703L8.74999 21.4199L2.15016 14.8201C1.93144 14.6013 1.80857 14.3046 1.80857 13.9953C1.80857 13.6859 1.93144 13.3892 2.15016 13.1704Z"
                            fill="#6B592E" />
                    </svg>
                </button>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-stretch gap-y-8">
                <!-- Kiri -->
                <div class="flex flex-col basis-full md:basis-[30%] flex-shrink-0">
                    <div class="mb-6">
                        <h1 class="text-2xl md:text-3xl lg:text-4xl font-Kuunari text-Seasalt">UNGGAH FOTO</h1>
                        <label for="file-upload"
                            class="group cursor-pointer flex items-center justify-center gap-2 w-full px-4 py-4 my-3 
                                   bg-Eerie-Black text-white rounded-sm 
                                   hover:bg-Ecru transition-all duration-300">
                            <svg width="39" height="39" viewBox="0 0 39 39" fill="none"
                                class="h-7 w-7 text-Ecru group-hover:text-Eerie-Black transition-colors duration-300"
                                xmlns="http://www.w3.org/2000/svg">
                                <!-- path SVG -->
                                <path
                                    d="M23.0522 4.47363V10.3171C23.0522 11.1085 23.3675 11.869 23.9297 12.4296C24.4934 12.9909 25.2566 13.3058 26.052 13.3055H32.7551"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path
                                    d="M32.9062 13.9227V27.8457C32.874 28.7564 32.6618 29.6517 32.282 30.48C31.9021 31.3083 31.3621 32.0533 30.693 32.6719C30.0234 33.2935 29.2378 33.777 28.3813 34.0948C27.5248 34.4127 26.614 34.5587 25.701 34.5244H13.3672C12.4487 34.5664 11.5309 34.4267 10.6665 34.1132C9.80202 33.7998 9.00794 33.3189 8.32975 32.6979C7.65419 32.0776 7.10863 31.3292 6.72478 30.4962C6.34093 29.6632 6.12643 28.7623 6.09375 27.8457V11.1504C6.12601 10.2397 6.33819 9.34443 6.71804 8.51611C7.0979 7.68779 7.63792 6.94284 8.307 6.32418C8.97663 5.70265 9.76216 5.21915 10.6187 4.90129C11.4752 4.58343 12.386 4.43745 13.299 4.47168H22.5842C24.0017 4.46667 25.3699 4.99114 26.4209 5.94231L31.2309 10.3656C31.7441 10.8077 32.1586 11.3529 32.4472 11.9658C32.7359 12.5786 32.8923 13.2454 32.9062 13.9227Z"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M19.5 17.0605V28.0683" stroke="currentColor" stroke-width="2"
                                    stroke-miterlimit="10" stroke-linecap="round" />
                                <path
                                    d="M24.5473 21.6934L20.2166 17.3628C20.1229 17.268 20.0113 17.1927 19.8883 17.1413C19.7653 17.0899 19.6333 17.0635 19.5 17.0635C19.3667 17.0635 19.2347 17.0899 19.1117 17.1413C18.9887 17.1927 18.8771 17.268 18.7834 17.3628L14.4528 21.6951"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <!-- ...path lainnya -->
                            </svg>
                            <span
                                class="text-sm md:text-base lg:text-lg font-Kuunari text-Ecru group-hover:text-Eerie-Black transition-colors duration-300">
                                UNGGAH FOTO SEKARANG
                            </span>
                        </label>
                        <input type="file" id="file-upload" class="hidden">
                        <p class="text-Ecru text-[10px] mt-2">Pastikan foto yang diunggah terlihat jelas (Maks ±5 Mb)
                        </p>
                    </div>

                    <div>
                        <h1 class="text-2xl md:text-3xl lg:text-4xl font-Kuunari text-Seasalt">PREVIEW</h1>
                        <div
                            class="w-full h-60 md:h-72 lg:h-80 mt-2 bg-[#1E1E1E] rounded flex items-center justify-center overflow-hidden relative">
                            <div id="svg-placeholder" class="absolute w-20 h-20">
                                <svg width="80" height="80" viewBox="0 0 80 80" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M16.6667 70C14.8333 70 13.2644 69.3478 11.96 68.0433C10.6556 66.7389 10.0022 65.1689 10 63.3333V16.6667C10 14.8333 10.6533 13.2644 11.96 11.96C13.2667 10.6556 14.8356 10.0022 16.6667 10H63.3333C65.1667 10 66.7367 10.6533 68.0433 11.96C69.35 13.2667 70.0022 14.8356 70 16.6667V63.3333C70 65.1667 69.3478 66.7367 68.0433 68.0433C66.7389 69.35 65.1689 70.0022 63.3333 70H16.6667ZM20 56.6667H60L47.5 40L37.5 53.3333L30 43.3333L20 56.6667Z"
                                        fill="black" />
                                </svg>
                            </div>
                            <img id="image-preview" class="max-w-full max-h-full hidden" />
                        </div>
                    </div>
                </div>

                <!-- Garis Vertikal -->
                <div class="hidden md:flex gap-[2px] mx-8 md:mx-16">
                    <div class="w-[1px] bg-Ecru"></div>
                    <div class="w-[1px] bg-Ecru"></div>
                </div>

                <!-- Kanan -->
                <div class="flex flex-col basis-full md:basis-[70%]">
                    <h1 class="text-center md:text-left text-3xl md:text-3xl lg:text-4xl font-Kuunari text-Seasalt">
                        REKOMENDASI GAYA
                        RAMBUT</h1>

                    <!-- Kartu (Desktop) -->
                    <div class="hidden md:flex flex-row my-3 flex-wrap gap-4 md:gap-5">
                        @for ($i = 0; $i < 4; $i++)
                            <div class="relative w-24 md:w-28 bg-[#1A1A1A] rounded-sm overflow-hidden">
                                <div class="absolute top-0 left-0 w-full h-[3px] bg-Ecru rounded-t-sm"></div>
                                <img src="{{ asset('assets/images/crewcut.jpg') }}" alt="Side Cut"
                                    class="w-full h-24 md:h-28 px-2 pt-2 object-cover" />
                                <div class="py-2 text-center text-Ecru font-Kuunari text-2xl tracking-wide">SIDE CUT
                                </div>
                            </div>
                        @endfor
                    </div>

                    <!-- Swiper (Mobile) -->
                    <div class="md:hidden my-3">
                        <div class="swiper w-full">
                            <div class="swiper-wrapper mb-9">
                                @for ($i = 0; $i < 4; $i++)
                                    <div class="swiper-slide w-20 h-56">
                                        <div class="relative w-full bg-[#1A1A1A] rounded-sm overflow-hidden">
                                            <div class="absolute top-0 left-0 w-full h-[3px] bg-Ecru rounded-t-sm">
                                            </div>
                                            <img src="{{ asset('assets/images/crewcut.jpg') }}" alt="Side Cut"
                                                class="w-full h-[80%] px-2 pt-2 object-cover" />
                                            <div class="py-2 text-center text-Ecru font-Kuunari text-4xl tracking-wide">
                                                SIDE CUT
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>

                            <div class="swiper-pagination"></div>
                        </div>
                    </div>

                    <p class="text-justify text-white font-Poppins font-light text-sm mb-6">
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nam nostrum, nulla itaque dignissimos
                        reprehenderit modi ducimus dolorem incidunt animi, deserunt dolore. Molestiae voluptatum
                        provident magni saepe id exercitationem. Sed, corrupti.
                    </p>

                    <h1
                        class="text-center md:text-left text-3xl md:text-3xl lg:text-4xl font-Kuunari mb-4 text-Seasalt">
                        REKOMENDASI
                        WARNA RAMBUT</h1>
                    <div class="flex flex-row justify-center md:justify-start gap-x-4">
                        <div class="h-5 w-20 bg-white"></div>
                        <div class="h-5 w-20 bg-white"></div>
                        <div class="h-5 w-20 bg-white"></div>
                        <div class="h-5 w-20 bg-white"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SwiperJS Script -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper('.swiper', {
                slidesPerView: "auto",
                effect: "coverflow",
                grabCursor: true,
                centeredSlides: true,
                spaceBetween: '10',
                coverflowEffect: {
                    rotate: 10,
                    stretch: 0,
                    depth: 100,
                    modifier: 1,
                    slideShadows: true,
                },
                loop: true,
                pagination: {
                    el: ".swiper-pagination", // elemen pagination
                    clickable: true, // bisa klik pagination bullet
                },
            });
        });
    </script>
</div>
