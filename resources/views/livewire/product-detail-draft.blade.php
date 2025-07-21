@push('styles')
    <style>
        /* Enhanced elegant animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.95) translateY(20px);
            }

            to {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        @keyframes gradientText {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        /* Animation classes with enhanced timing */
        .animate-fade-in {
            animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .animate-slide-up {
            animation: slideUp 0.9s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .animate-slide-left {
            animation: slideInLeft 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .animate-slide-right {
            animation: slideInRight 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .animate-scale-in {
            animation: scaleIn 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* Staggered animations */
        .animate-delay-100 {
            animation-delay: 0.1s;
            animation-fill-mode: both;
        }

        .animate-delay-200 {
            animation-delay: 0.2s;
            animation-fill-mode: both;
        }

        .animate-delay-300 {
            animation-delay: 0.3s;
            animation-fill-mode: both;
        }

        .animate-delay-400 {
            animation-delay: 0.4s;
            animation-fill-mode: both;
        }

        .animate-delay-500 {
            animation-delay: 0.5s;
            animation-fill-mode: both;
        }

        .animate-delay-600 {
            animation-delay: 0.6s;
            animation-fill-mode: both;
        }

        /* Enhanced hover effects */
        .card-hover {
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            overflow: hidden;
        }

        .card-hover::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(233, 191, 128, 0.1), transparent);
            transition: left 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .card-hover:hover::before {
            left: 100%;
        }

        .card-hover:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px rgba(233, 191, 128, 0.2), 0 0 0 1px rgba(233, 191, 128, 0.1);
            border-color: rgba(233, 191, 128, 0.4);
        }

        /* Enhanced button animations */
        .btn-elegant {
            position: relative;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .btn-elegant::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .btn-elegant:hover::before {
            left: 100%;
        }

        .btn-elegant:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(233, 191, 128, 0.3);
        }

        /* Enhanced gradient text effect */
        .gradient-text {
            background: linear-gradient(-45deg, #E9BF80, #FFD700, #E9BF80, #B5964D);
            background-size: 300% 300%;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradientText 3s ease infinite;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #1a1a1a;
        }

        ::-webkit-scrollbar-thumb {
            background: #E9BF80;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #B5964D;
        }

        /* Grid responsiveness enhancements */
        @media (max-width: 768px) {
            .grid {
                gap: 1rem;
            }
        }

        /* Enhanced card equal heights */
        .card-hover {
            display: flex;
            flex-direction: column;
        }

        .card-hover>div {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
    </style>
@endpush

<div class="min-h-screen bg-[#0C0C0C] text-white">
    <!-- Header -->
    <header class="sticky top-0 z-50 bg-[#0C0C0C]/95 backdrop-blur-md border-b border-[#E9BF80]/10">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
            <button
                class="w-10 h-10 rounded-full bg-[#E9BF80] flex items-center justify-center hover:scale-105 transition-transform">
                <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <h1 class="text-[#E9BF80] font-Kuunari text-lg font-bold">Detail Barbershop</h1>
            <div class="w-10"></div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-6 py-8 space-y-8">
        <!-- Hero Section -->
        <section class="animate-fade-in">
            <div class="text-center mb-8">
                <h2 class="font-Kuunari font-bold text-4xl text-[#E9BF80] mb-2">CAPTAIN BARBERSHOP</h2>
                <p class="text-[#B5964D] text-lg mb-4">Bogor, Jawa Barat</p>
                <div class="flex items-center justify-center gap-2 mb-6">
                    <div class="flex">
                        @for ($i = 0; $i < 5; $i++)
                            <svg class="w-5 h-5 text-[#E9BF80]" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.853 1.512 8.259L12 18.896l-7.448 4.522L6.064 15.16 0 9.307l8.332-1.151z" />
                            </svg>
                        @endfor
                    </div>
                    <span class="text-[#E9BF80] font-semibold">4.9</span>
                    <span class="text-gray-400">(2.1k ulasan)</span>
                </div>
            </div>

            <div class="rounded-2xl overflow-hidden shadow-2xl mb-8">
                <img src="{{ asset('assets/images/DashboardBarbershop.png') }}" alt="Captain Barbershop"
                    class="w-full h-80 object-cover">
            </div>
        </section>

        <!-- Description -->
        <section class="animate-slide-up bg-[#1A1A1A] rounded-2xl p-8 card-hover">
            <h3 class="font-Kuunari text-2xl text-[#E9BF80] mb-6">TENTANG KAMI</h3>
            <p class="text-gray-300 leading-relaxed text-lg">
                Captain Barbershop adalah tempat barbershop modern yang menghadirkan pengalaman grooming pria dengan
                standar pelayanan terbaik.
                Dengan tim barber profesional dan berpengalaman, kami menyediakan berbagai layanan seperti haircut, hair
                wash, styling, shaving,
                hingga perawatan rambut dan wajah.
            </p>
        </section>

        <!-- Location & Hours -->
        <section class="animate-slide-up bg-[#1A1A1A] rounded-2xl p-8 card-hover">
            <h3 class="font-Kuunari text-2xl text-[#E9BF80] mb-6">LOKASI & JAM BUKA</h3>

            <!-- Map -->
            <div class="rounded-xl overflow-hidden mb-6">
                <img src="{{ asset('assets/images/mapBarber.png') }}" alt="Lokasi" class="w-full h-48 object-cover">
            </div>

            <!-- Address -->
            <div class="bg-[#2A2A2A] rounded-xl p-4 mb-6">
                <p class="text-gray-300">Jl. Pajajaran Indah V, RT.07/RW.14, Baranangsiang, Kec. Bogor Tim., Kota Bogor,
                    Jawa Barat 16143</p>
            </div>

            <!-- Hours -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                @php $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu']; @endphp
                @foreach ($days as $day)
                    <div class="bg-[#2A2A2A] rounded-lg p-3 text-center">
                        <div class="text-gray-400 text-sm">{{ $day }}</div>
                        <div class="text-[#E9BF80] font-semibold">10.00-21.00</div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Services -->
        <section class="animate-slide-up bg-[#1A1A1A] rounded-2xl p-8 card-hover">
            <h3 class="font-Kuunari text-2xl text-[#E9BF80] mb-8">LAYANAN & HARGA</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Service 1 -->
                <div
                    class="bg-[#2A2A2A] rounded-xl p-6 card-hover border border-[#E9BF80]/20 animate-scale-in animate-delay-100">
                    <div class="text-center h-full flex flex-col">
                        <h4 class="text-white font-bold text-lg mb-2">HAIRCUT PREMIUM</h4>
                        <div class="text-[#E9BF80] font-Kuunari text-4xl font-bold mb-4 gradient-text">60K</div>
                        <p class="text-gray-400 text-sm mb-6 flex-grow">Cutting & Styling, Hair Wash Premium, Konsultasi
                            Gaya<br>±30 menit</p>
                        <button
                            class="w-full bg-[#E9BF80] text-black font-bold py-3 rounded-lg btn-elegant hover:bg-[#B5964D] transition-all">
                            RESERVASI SEKARANG
                        </button>
                    </div>
                </div>

                <!-- Service 2 -->
                <div
                    class="bg-[#2A2A2A] rounded-xl p-6 card-hover border border-[#E9BF80]/20 animate-scale-in animate-delay-200">
                    <div class="text-center h-full flex flex-col">
                        <h4 class="text-white font-bold text-lg mb-2">HAIR COLOURING</h4>
                        <div class="text-[#E9BF80] font-Kuunari text-4xl font-bold mb-4 gradient-text">120K</div>
                        <p class="text-gray-400 text-sm mb-6 flex-grow">Cutting & Colouring, Hair Wash Premium,
                            Konsultasi Warna<br>±45 menit</p>
                        <button
                            class="w-full bg-[#E9BF80] text-black font-bold py-3 rounded-lg btn-elegant hover:bg-[#B5964D] transition-all">
                            RESERVASI SEKARANG
                        </button>
                    </div>
                </div>

                <!-- Service 3 -->
                <div
                    class="bg-[#2A2A2A] rounded-xl p-6 card-hover border border-[#E9BF80]/20 animate-scale-in animate-delay-300">
                    <div class="text-center h-full flex flex-col">
                        <h4 class="text-white font-bold text-lg mb-2">KIDS HAIRCUT</h4>
                        <div class="text-[#E9BF80] font-Kuunari text-4xl font-bold mb-4 gradient-text">45K</div>
                        <p class="text-gray-400 text-sm mb-6 flex-grow">Cutting & Styling khusus anak, Hair Wash
                            Premium<br>±25 menit</p>
                        <button
                            class="w-full bg-[#E9BF80] text-black font-bold py-3 rounded-lg btn-elegant hover:bg-[#B5964D] transition-all">
                            RESERVASI SEKARANG
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Team -->
        <section class="animate-slide-up bg-[#1A1A1A] rounded-2xl p-8 card-hover">
            <h3 class="font-Kuunari text-2xl text-[#E9BF80] mb-8">TIM BARBER</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @for ($i = 0; $i < 3; $i++)
                    <div
                        class="bg-[#2A2A2A] rounded-xl p-6 card-hover border border-[#E9BF80]/20 animate-scale-in animate-delay-{{ ($i + 1) * 100 }}">
                        <div class="text-center h-full flex flex-col">
                            <div class="w-24 h-24 mx-auto mb-4">
                                <img src="{{ asset('assets/images/kapster.png') }}" alt="Barber ARJUNA"
                                    class="w-full h-full rounded-full object-cover border-2 border-[#E9BF80]">
                            </div>
                            <h4 class="text-white font-bold text-xl mb-2">ARJUNA</h4>
                            <p class="text-gray-400 text-sm mb-4 flex-grow">Senior Barber - 5 tahun pengalaman</p>
                            <div class="flex justify-center">
                                @for ($j = 0; $j < 5; $j++)
                                    <svg class="w-4 h-4 text-[#E9BF80]" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.853 1.512 8.259L12 18.896l-7.448 4.522L6.064 15.16 0 9.307l8.332-1.151z" />
                                    </svg>
                                @endfor
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </section>

        <!-- Reviews -->
        <section class="animate-slide-up bg-[#1A1A1A] rounded-2xl p-8 card-hover">
            <h3 class="font-Kuunari text-2xl text-[#E9BF80] mb-8">PENILAIAN BARBERSHOP</h3>

            <!-- Rating Summary -->
            <div class="bg-[#2A2A2A] rounded-xl p-6 mb-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <!-- Rating Score -->
                    <div class="text-center md:text-left">
                        <div class="flex items-end gap-2 justify-center md:justify-start mb-4">
                            <span class="text-[#E9BF80] text-5xl font-Kuunari font-bold">4.9</span>
                            <span class="text-gray-400 text-xl mb-2">dari</span>
                            <span class="text-[#E9BF80] text-4xl font-Kuunari font-bold mb-2">5</span>
                        </div>
                        <div class="flex justify-center md:justify-start mb-2">
                            @for ($i = 0; $i < 5; $i++)
                                <svg class="w-5 h-5 text-[#E9BF80] mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.853 1.512 8.259L12 18.896l-7.448 4.522L6.064 15.16 0 9.307l8.332-1.151z" />
                                </svg>
                            @endfor
                        </div>
                    </div>

                    <!-- Filter Buttons -->
                    <div class="flex flex-wrap gap-3 justify-center">
                        <button
                            class="bg-[#E9BF80] text-black px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                            Semua
                        </button>
                        <button
                            class="bg-[#0C0C0C] text-white border border-[#E9BF80]/30 px-4 py-2 rounded-lg text-sm hover:border-[#E9BF80] transition-colors">
                            5 Bintang (2RB)
                        </button>
                        <button
                            class="bg-[#0C0C0C] text-white border border-[#E9BF80]/30 px-4 py-2 rounded-lg text-sm hover:border-[#E9BF80] transition-colors">
                            4 Bintang (153)
                        </button>
                        <button
                            class="bg-[#0C0C0C] text-white border border-[#E9BF80]/30 px-4 py-2 rounded-lg text-sm hover:border-[#E9BF80] transition-colors">
                            3 Bintang (20)
                        </button>
                        <button
                            class="bg-[#0C0C0C] text-white border border-[#E9BF80]/30 px-4 py-2 rounded-lg text-sm hover:border-[#E9BF80] transition-colors">
                            2 Bintang (10)
                        </button>
                        <button
                            class="bg-[#0C0C0C] text-white border border-[#E9BF80]/30 px-4 py-2 rounded-lg text-sm hover:border-[#E9BF80] transition-colors">
                            1 Bintang (5)
                        </button>
                        <button
                            class="bg-[#0C0C0C] text-white border border-[#E9BF80]/30 px-4 py-2 rounded-lg text-sm hover:border-[#E9BF80] transition-colors">
                            Dengan Media (1RB)
                        </button>
                    </div>
                </div>
            </div>

            <!-- Reviews List -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @for ($i = 0; $i < 4; $i++)
                    <div
                        class="bg-[#2A2A2A] rounded-xl p-6 border border-[#E9BF80]/30 card-hover animate-scale-in animate-delay-{{ ($i + 1) * 100 }}">
                        <div class="flex items-start gap-4 h-full">
                            <div
                                class="w-12 h-12 bg-white rounded-full flex items-center justify-center border-2 border-[#E9BF80] flex-shrink-0">
                                <!-- Empty avatar placeholder -->
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-2">
                                    <h5 class="font-bold text-white truncate">Anonimus Ganteng</h5>
                                    <div class="flex flex-shrink-0 ml-2">
                                        @for ($j = 0; $j < 5; $j++)
                                            <svg class="w-4 h-4 text-[#E9BF80]" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path
                                                    d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.853 1.512 8.259L12 18.896l-7.448 4.522L6.064 15.16 0 9.307l8.332-1.151z" />
                                            </svg>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-gray-500 text-xs mb-2">2024-05-05 00:06</p>
                                <p class="text-gray-300 text-sm leading-relaxed">
                                    Potongan di sini luar biasa! Hasilnya presisi, barbernya ramah, dan tempatnya
                                    nyaman. Pasti balik lagi!
                                </p>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            <div class="text-center mt-8">
                <button class="text-[#E9BF80] font-Kuunari font-bold text-xl hover:text-white transition-colors">
                    LAINNYA →
                </button>
            </div>
        </section>
    </main>
</div>
