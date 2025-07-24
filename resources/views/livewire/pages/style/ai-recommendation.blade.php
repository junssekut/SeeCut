<div>
    <div class="relative min-h-screen">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0 bg-center bg-contain bg-no-repeat opacity-10"
            style="background-image: url('{{ asset('assets/images/wave.png') }}');">
        </div>

        <div class="relative px-6 md:px-16 lg:px-48">
            <!-- Header with Back Button -->
            <div class="py-10 md:py-12">
                <button wire:click="$dispatch('navigate-back')"
                    class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-Ecru hover:bg-white transition-all duration-300 flex items-center justify-center shadow focus:outline-none">
                    <svg width="14" height="28" viewBox="0 0 14 28" fill="none"
                        xmlns="http://www.w3.org/2000/svg" class="w-4 md:w-6 h-6 text-gray-700">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M2.15016 13.1704L8.74999 6.57059L10.3997 8.22026L4.62466 13.9953L10.3997 19.7703L8.74999 21.4199L2.15016 14.8201C1.93144 14.6013 1.80857 14.3046 1.80857 13.9953C1.80857 13.6859 1.93144 13.3892 2.15016 13.1704Z"
                            fill="#6B592E" />
                    </svg>
                </button>
            </div>

            <!-- Main Grid Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 min-h-[700px]">

                <!-- LEFT SIDE: Upload & Preview Section -->
                <div class="lg:col-span-5 space-y-8">
                    <!-- Upload Section -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <h1 class="text-2xl md:text-3xl lg:text-4xl font-Kuunari text-Seasalt">UNGGAH FOTO</h1>
                            <div class="flex-1 h-px bg-gradient-to-r from-Ecru to-transparent"></div>
                        </div>

                        <!-- File Upload Button -->
                        <label for="file-upload"
                            class="group cursor-pointer flex items-center justify-center gap-3 w-full px-6 py-5 
                                   bg-Eerie-Black text-white rounded-lg border-2 border-transparent
                                   hover:bg-Ecru hover:border-Ecru hover:text-Eerie-Black 
                                   transition-all duration-300 transform hover:scale-[1.02]
                                   {{ $processing ? 'opacity-50 cursor-not-allowed' : '' }}">
                            <svg width="39" height="39" viewBox="0 0 39 39" fill="none"
                                class="h-8 w-8 text-Ecru group-hover:text-Eerie-Black transition-colors duration-300"
                                xmlns="http://www.w3.org/2000/svg">
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
                            </svg>
                            <span
                                class="text-base md:text-lg font-Kuunari text-Ecru group-hover:text-Eerie-Black transition-colors duration-300">
                                {{ $processing ? 'MENGANALISIS...' : 'UNGGAH FOTO SEKARANG' }}
                            </span>
                        </label>

                        <input type="file" id="file-upload" class="hidden" accept="image/jpeg,image/jpg,image/png"
                            wire:model="uploadedImage" {{ $processing ? 'disabled' : '' }}
                            onchange="checkFileSize(this)">

                        <!-- File Info -->
                        <div class="flex items-center justify-between text-xs">
                            <div class="text-gray-400">
                                @if ($uploadedImage)
                                    <p class="text-Ecru">✓ {{ $uploadedImage->getClientOriginalName() }}</p>
                                @else
                                    <p>Belum ada file yang dipilih</p>
                                @endif
                            </div>
                            <p class="text-Ecru">Maks 2 MB • JPG, PNG</p>
                        </div>

                        <!-- Loading indicator for file upload -->
                        <div wire:loading wire:target="uploadedImage" class="flex items-center justify-center py-4">
                            <div class="flex items-center text-Ecru">
                                <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-Ecru mr-3"></div>
                                <span class="text-sm font-medium">Mengunggah foto...</span>
                            </div>
                        </div>
                    </div>

                    <!-- Preferred Style Section -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <h2 class="text-xl md:text-2xl font-Kuunari text-Seasalt">GAYA PILIHAN</h2>
                            <div class="flex-1 h-px bg-gradient-to-r from-Ecru to-transparent"></div>
                        </div>

                        <!-- Preferred Style Input -->
                        <div class="space-y-2">
                            <label for="preferred-style" class="block text-sm font-medium text-gray-300">
                                Gaya rambut yang diinginkan (opsional)
                            </label>
                            <input type="text" id="preferred-style" wire:model="preferredStyle"
                                placeholder="Contoh: Blowout Taper, Fade, Undercut..."
                                class="w-full px-4 py-3 bg-[#2A2A2A] border border-gray-700 rounded-lg text-white 
                                       placeholder-gray-500 focus:border-Ecru focus:ring-1 focus:ring-Ecru 
                                       focus:outline-none transition-colors duration-300
                                       {{ $processing ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ $processing ? 'disabled' : '' }}>
                            <p class="text-xs text-gray-500">
                                Masukkan nama gaya rambut yang Anda inginkan untuk mendapatkan rekomendasi yang lebih
                                spesifik
                            </p>
                        </div>
                    </div>

                    <!-- Preview Section -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <h1 class="text-2xl md:text-3xl lg:text-4xl font-Kuunari text-Seasalt">PREVIEW</h1>
                            <div class="flex-1 h-px bg-gradient-to-r from-Ecru to-transparent"></div>
                        </div>

                        <div
                            class="w-full aspect-[4/3] bg-gradient-to-br from-[#1E1E1E] to-[#2A2A2A] rounded-xl flex items-center justify-center overflow-hidden relative border border-gray-800">
                            <!-- SVG Placeholder -->
                            @if (!$previewImage)
                                <div class="text-gray-600 flex flex-col items-center justify-center">
                                    <svg width="80" height="80" viewBox="0 0 80 80" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" class="opacity-40 mb-4">
                                        <path
                                            d="M16.6667 70C14.8333 70 13.2644 69.3478 11.96 68.0433C10.6556 66.7389 10.0022 65.1689 10 63.3333V16.6667C10 14.8333 10.6533 13.2644 11.96 11.96C13.2667 10.6556 14.8356 10.0022 16.6667 10H63.3333C65.1667 10 66.7367 10.6533 68.0433 11.96C69.35 13.2667 70.0022 14.8356 70 16.6667V63.3333C70 65.1667 69.3478 66.7367 68.0433 68.0433C66.7389 69.35 65.1689 70.0022 63.3333 70H16.6667ZM20 56.6667H60L47.5 40L37.5 53.3333L30 43.3333L20 56.6667Z"
                                            fill="currentColor" />
                                    </svg>
                                    <p class="text-center text-sm text-gray-500">Foto akan muncul di sini</p>
                                </div>
                            @endif

                            <!-- Image Preview -->
                            @if ($previewImage)
                                <img src="{{ $previewImage }}" class="w-full h-full object-cover" alt="Preview" />
                            @endif

                            <!-- Animated AI Processing Overlay -->
                            @if ($processing)
                                <div id="processing-overlay"
                                    class="fixed inset-0 bg-black/90 z-50 flex items-center justify-center backdrop-blur-sm"
                                    style="overflow: hidden;">
                                    <div class="text-center max-w-lg mx-auto px-6">

                                        <!-- Progress Status -->
                                        <div class="mb-8 text-center">
                                            <div class="text-Ecru text-lg font-medium mb-2">
                                                <span
                                                    id="current-step-text">{{ $progressStatus ?: 'Memulai analisis...' }}</span>
                                            </div>
                                            <div class="w-full bg-gray-700 rounded-full h-2">
                                                <div class="bg-gradient-to-r from-Ecru via-yellow-400 to-Ecru h-2 rounded-full transition-all duration-500 ease-out"
                                                    style="width: {{ $progressPercentage }}%"></div>
                                            </div>
                                            <div class="text-gray-400 text-sm mt-2">
                                                <span id="progress-text">{{ $progressPercentage }}%</span> selesai
                                            </div>
                                        </div>

                                        <!-- Enhanced Animated Character -->
                                        <div class="relative mb-8">
                                            <div class="relative w-32 h-40 mx-auto">
                                                <!-- Head -->
                                                <div
                                                    class="absolute top-0 left-1/2 transform -translate-x-1/2 w-16 h-16 bg-gray-600 rounded-full">
                                                </div>

                                                <!-- Hair - Changes based on step -->
                                                <div id="animated-hair"
                                                    class="absolute top-0 left-1/2 transform -translate-x-1/2 w-16 h-8 bg-gradient-to-b from-yellow-600 to-yellow-700 rounded-t-full transition-all duration-1000 ease-out">
                                                </div>

                                                <!-- Body -->
                                                <div
                                                    class="absolute top-14 left-1/2 transform -translate-x-1/2 w-12 h-20 bg-gray-700 rounded-lg">
                                                </div>

                                                <!-- Arms/Hands - Added back -->
                                                <div class="absolute top-16 left-3 w-3 h-12 bg-gray-700 rounded-full">
                                                </div>
                                                <div class="absolute top-16 right-3 w-3 h-12 bg-gray-700 rounded-full">
                                                </div>

                                                <!-- Bigger Scissors - Floating animation -->
                                                <div id="animated-scissors"
                                                    class="absolute top-8 -right-8 transform animate-bounce">
                                                    <svg width="32" height="32" viewBox="0 0 24 24"
                                                        fill="none" class="text-Ecru">
                                                        <path
                                                            d="M9.5 12c0 .8-.7 1.5-1.5 1.5S6.5 12.8 6.5 12s.7-1.5 1.5-1.5S9.5 11.2 9.5 12zm8.5 0c0 .8-.7 1.5-1.5 1.5S15 12.8 15 12s.7-1.5 1.5-1.5S18 11.2 18 12zM7.1 8.2l5.4 5.4m-5.4 2.4l5.4-5.4"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round" />
                                                        <circle cx="8" cy="12" r="1.5"
                                                            fill="currentColor" />
                                                        <circle cx="16.5" cy="12" r="1.5"
                                                            fill="currentColor" />
                                                    </svg>
                                                </div>

                                                <!-- Sparkles -->
                                                <div
                                                    class="absolute -top-1 -left-1 w-2 h-2 bg-Ecru rounded-full animate-ping">
                                                </div>
                                                <div class="absolute -top-1 -right-1 w-2 h-2 bg-Ecru rounded-full animate-ping"
                                                    style="animation-delay: 0.5s"></div>
                                                <div
                                                    class="absolute top-4 -left-3 w-1 h-1 bg-white rounded-full animate-pulse">
                                                </div>
                                                <div class="absolute top-4 -right-3 w-1 h-1 bg-white rounded-full animate-pulse"
                                                    style="animation-delay: 0.3s"></div>
                                            </div>
                                        </div>

                                        <!-- Real-time Progress Message -->
                                        <div class="mb-6 text-center min-h-[80px] flex flex-col justify-center">
                                            <p class="text-white text-lg font-medium">
                                                {{ $progressStatus ?: 'Memulai proses analisis...' }}
                                            </p>
                                            <p class="text-gray-400 text-sm mt-2">
                                                Mohon tunggu sebentar...
                                            </p>
                                        </div>

                                        <!-- Progress Steps - Livewire Component -->
                                        <livewire:components.progress-steps :currentStep="$currentStep" :progressPercentage="$progressPercentage"
                                            :progressStatus="$progressStatus" :key="$currentStep . '-' . $progressPercentage" />

                                        <!-- Preferred Style Info -->
                                        @if (!empty($preferredStyle))
                                            <div
                                                class="mt-6 p-4 bg-gradient-to-r from-Ecru/20 to-yellow-500/20 rounded-lg border border-Ecru/30">
                                                <p class="text-Ecru text-sm font-medium mb-1">Gaya yang diinginkan:</p>
                                                <p class="text-white text-lg font-semibold">{{ $preferredStyle }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>


                            @endif
                        </div>
                    </div>

                    <!-- Analysis Results Card -->
                    @if ($analysisResult && isset($analysisResult['face_analysis']))
                        <div
                            class="bg-gradient-to-r from-[#1A1A1A] to-[#2A2A2A] rounded-xl p-6 border border-gray-800">
                            <h3 class="text-lg font-Kuunari text-Ecru mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                HASIL ANALISIS WAJAH
                            </h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-center p-3 bg-black/30 rounded-lg">
                                    <p class="text-Ecru text-xs font-Kuunari mb-1">BENTUK WAJAH</p>
                                    <p class="text-white text-lg font-bold capitalize">
                                        {{ $analysisResult['face_analysis']['face_shape'] ?? '-' }}
                                    </p>
                                </div>
                                <div class="text-center p-3 bg-black/30 rounded-lg">
                                    <p class="text-Ecru text-xs font-Kuunari mb-1">JENIS KELAMIN</p>
                                    <p class="text-white text-lg font-bold">
                                        {{ $analysisResult['face_analysis']['gender'] ?? '-' }}
                                    </p>
                                </div>
                                <div class="text-center p-3 bg-black/30 rounded-lg">
                                    <p class="text-Ecru text-xs font-Kuunari mb-1">PERKIRAAN USIA</p>
                                    <p class="text-white text-lg font-bold">
                                        @if (isset($analysisResult['face_analysis']['age_range']))
                                            {{ $analysisResult['face_analysis']['age_range']['Low'] }}-{{ $analysisResult['face_analysis']['age_range']['High'] }}
                                        @else
                                            -
                                        @endif
                                    </p>
                                </div>
                                <div class="text-center p-3 bg-black/30 rounded-lg">
                                    <p class="text-Ecru text-xs font-Kuunari mb-1">AKURASI</p>
                                    <p class="text-white text-lg font-bold">
                                        @if (isset($analysisResult['face_analysis']['confidence']))
                                            {{ round($analysisResult['face_analysis']['confidence']) }}%
                                        @else
                                            -
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- RIGHT SIDE: Recommendations Section -->
                <div class="lg:col-span-7 space-y-8">
                    <!-- Haircut Recommendations -->
                    <div class="space-y-6">
                        <div class="flex items-center gap-4">
                            <h1 class="text-2xl md:text-3xl lg:text-4xl font-Kuunari text-Seasalt">REKOMENDASI GAYA
                                RAMBUT</h1>
                            <div class="flex-1 h-px bg-gradient-to-l from-Ecru to-transparent"></div>
                        </div>

                        <!-- Haircut Recommendations Grid (Desktop) - 4 Cards Only -->
                        <div class="hidden md:grid md:grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-4">
                            @if ($analysisResult && isset($analysisResult['generated_images']))
                                @foreach ($analysisResult['generated_images'] as $index => $image)
                                    @if ($index < 4)
                                        <div class="group relative bg-gradient-to-br from-[#1A1A1A] to-[#2A2A2A] rounded-lg border border-gray-800 overflow-hidden hover:border-Ecru/50 transition-all duration-300 cursor-pointer"
                                            wire:click="selectHaircut({{ $index }})">

                                            <!-- Image Container - Smaller aspect ratio -->
                                            <div class="aspect-[4/5] relative overflow-hidden">
                                                <img src="{{ $image['image'] ?? asset('assets/images/crewcut.jpg') }}"
                                                    alt="{{ $image['style'] ?? 'Style' }}"
                                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />

                                                <!-- Hover Overlay -->
                                                <div
                                                    class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                                    <div class="text-center text-white">
                                                        <svg class="w-8 h-8 mx-auto mb-1 text-Ecru" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                        <p class="text-xs font-Kuunari">DETAIL</p>
                                                    </div>
                                                </div>

                                                <!-- Status Indicator -->
                                                @if ($image['is_fallback'] ?? false)
                                                    <div class="absolute top-2 right-2">
                                                        <div class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"
                                                            title="Preview tidak tersedia"></div>
                                                    </div>
                                                @else
                                                    <div class="absolute top-2 right-2">
                                                        <div class="w-2 h-2 bg-green-500 rounded-full"
                                                            title="AI Generated"></div>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Card Footer - Smaller -->
                                            <div class="p-3">
                                                <h3
                                                    class="text-Ecru font-Kuunari text-xs lg:text-sm font-bold tracking-wider mb-1 text-center">
                                                    {{ strtoupper($image['style'] ?? 'STYLE ' . ($index + 1)) }}
                                                </h3>

                                                @if (isset($image['description']))
                                                    <p class="text-gray-400 text-xs text-center line-clamp-2">
                                                        {{ Str::limit($image['description'], 40) }}
                                                    </p>
                                                @endif

                                                <!-- Action Button - Smaller -->
                                                <div class="mt-2 text-center">
                                                    <button
                                                        class="inline-flex items-center gap-1 px-3 py-1.5 bg-Ecru/10 text-Ecru border border-Ecru/30 rounded-md hover:bg-Ecru hover:text-Eerie-Black transition-all duration-300 text-xs font-Kuunari">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                                        </svg>
                                                        PILIH
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <!-- Placeholder Grid - Only 4 Cards -->
                                @for ($i = 0; $i < 4; $i++)
                                    <div
                                        class="relative bg-gradient-to-br from-[#1A1A1A]/50 to-[#2A2A2A]/50 rounded-lg border border-gray-800/50 overflow-hidden opacity-50">
                                        <div class="aspect-[4/5] bg-gray-800 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div class="p-3 text-center">
                                            <h3 class="text-gray-500 font-Kuunari text-xs">STYLE {{ $i + 1 }}
                                            </h3>
                                            <p class="text-gray-600 text-xs mt-1">Unggah foto</p>
                                        </div>
                                    </div>
                                @endfor
                            @endif
                        </div>
                        <!-- Mobile Swiper -->
                        <div class="md:hidden my-6">
                            <div class="swiper w-full">
                                <div class="swiper-wrapper mb-9">
                                    @if ($analysisResult && isset($analysisResult['generated_images']))
                                        @foreach ($analysisResult['generated_images'] as $index => $image)
                                            <div class="swiper-slide w-32">
                                                <div class="relative w-full bg-gradient-to-br from-[#1A1A1A] to-[#2A2A2A] rounded-xl border border-gray-800 overflow-hidden cursor-pointer"
                                                    wire:click="selectHaircut({{ $index }})">
                                                    <!-- Top accent bar -->
                                                    <div class="absolute top-0 left-0 w-full h-1 bg-Ecru rounded-t-xl">
                                                    </div>

                                                    <!-- Image -->
                                                    <div class="aspect-[3/4] p-2 pt-3">
                                                        <img src="{{ $image['image'] ?? asset('assets/images/crewcut.jpg') }}"
                                                            alt="{{ $image['style'] ?? 'Style' }}"
                                                            class="w-full h-full object-cover rounded-lg" />
                                                    </div>

                                                    <!-- Title -->
                                                    <div class="p-3 pt-2 text-center">
                                                        <p class="text-Ecru font-Kuunari text-xs tracking-wide">
                                                            {{ strtoupper($image['style'] ?? 'STYLE ' . ($index + 1)) }}
                                                        </p>
                                                    </div>

                                                    <!-- Status indicator -->
                                                    @if ($image['is_fallback'] ?? false)
                                                        <div class="absolute top-2 right-2 w-2 h-2 bg-yellow-500 rounded-full animate-pulse"
                                                            title="Preview tidak tersedia"></div>
                                                    @else
                                                        <div class="absolute top-2 right-2 w-2 h-2 bg-green-500 rounded-full"
                                                            title="AI Generated"></div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        @for ($i = 0; $i < 4; $i++)
                                            <div class="swiper-slide w-32">
                                                <div
                                                    class="relative w-full bg-gradient-to-br from-[#1A1A1A]/50 to-[#2A2A2A]/50 rounded-xl border border-gray-800/50 overflow-hidden opacity-50">
                                                    <div
                                                        class="absolute top-0 left-0 w-full h-1 bg-Ecru/50 rounded-t-xl">
                                                    </div>
                                                    <div
                                                        class="aspect-[3/4] p-2 pt-3 bg-gray-800 flex items-center justify-center rounded-lg m-2 mt-3">
                                                        <svg class="w-12 h-12 text-gray-600" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                    </div>
                                                    <div class="p-3 pt-2 text-center">
                                                        <p class="text-gray-500 font-Kuunari text-xs">STYLE
                                                            {{ $i + 1 }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endfor
                                    @endif
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>
                        </div>

                        <!-- Selected Haircut Description (Mobile/All) -->
                        @if ($selectedHaircut)
                            <div
                                class="bg-gradient-to-r from-[#1A1A1A] to-[#2A2A2A] rounded-xl p-6 border border-gray-800 mb-6">
                                <h3 class="text-xl font-Kuunari text-Ecru mb-3 text-center md:text-left">
                                    {{ strtoupper($selectedHaircut['style'] ?? 'GAYA TERPILIH') }}</h3>
                                <p class="text-gray-300 font-Poppins text-sm text-justify leading-relaxed">
                                    {{ $selectedHaircut['description'] ?? $this->getHaircutDescription($selectedHaircut['style'] ?? null) }}
                                </p>

                                <!-- Action buttons for mobile -->
                                <div class="flex gap-3 mt-4 md:hidden">
                                    <button
                                        onclick="copyImageToClipboard('{{ $selectedHaircut['image'] ?? asset('assets/images/crewcut.jpg') }}', '{{ $selectedHaircut['style'] ?? 'Style' }}')"
                                        class="flex-1 flex items-center justify-center gap-2 px-4 py-3 bg-Ecru text-Eerie-Black rounded-lg hover:bg-Ecru/90 transition-all duration-300 font-Kuunari text-sm font-bold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                        SALIN
                                    </button>
                                    <button
                                        onclick="downloadImage('{{ $selectedHaircut['image'] ?? asset('assets/images/crewcut.jpg') }}', '{{ $selectedHaircut['style'] ?? 'Style' }}')"
                                        class="flex-1 flex items-center justify-center gap-2 px-4 py-3 bg-transparent text-Ecru border-2 border-Ecru rounded-lg hover:bg-Ecru hover:text-Eerie-Black transition-all duration-300 font-Kuunari text-sm font-bold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        UNDUH
                                    </button>
                                </div>
                            </div>
                        @else
                            <!-- Default description when no selection -->
                            <div
                                class="bg-gradient-to-r from-[#1A1A1A]/50 to-[#2A2A2A]/50 rounded-xl p-6 border border-gray-800/50 mb-6">
                                <p class="text-gray-400 font-Poppins text-sm text-center leading-relaxed opacity-75">
                                    Unggah foto selfie Anda untuk mendapatkan rekomendasi gaya rambut yang sesuai dengan
                                    bentuk wajah dan karakteristik Anda. AI kami akan menganalisis wajah Anda dan
                                    memberikan saran gaya rambut terbaik.
                                </p>
                            </div>
                        @endif

                    </div>

                    <!-- Color Palette Recommendations -->
                    @if ($analysisResult && isset($analysisResult['color_recommendations']))
                        <div class="space-y-6">
                            <div class="flex items-center gap-4">
                                <h2 class="text-xl md:text-2xl lg:text-3xl font-Kuunari text-Seasalt">REKOMENDASI WARNA
                                </h2>
                                <div class="flex-1 h-px bg-gradient-to-l from-Ecru to-transparent"></div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach ($analysisResult['color_recommendations'] as $colorGroup)
                                    <div
                                        class="bg-gradient-to-br from-[#1A1A1A] to-[#2A2A2A] rounded-xl p-6 border border-gray-800">
                                        <h3 class="text-Ecru font-Kuunari text-lg mb-4 text-center">
                                            {{ strtoupper($colorGroup['category'] ?? 'KATEGORI WARNA') }}
                                        </h3>

                                        <div class="grid grid-cols-3 gap-3 mb-4">
                                            @foreach ($colorGroup['colors'] ?? [] as $color)
                                                <div class="text-center">
                                                    <div class="w-full h-16 rounded-lg mb-2 border-2 border-gray-700"
                                                        style="background-color: {{ $color['hex'] ?? '#888888' }}">
                                                    </div>
                                                    <p class="text-white text-xs font-medium">
                                                        {{ $color['name'] ?? 'Warna' }}</p>
                                                    <p class="text-gray-400 text-xs">{{ $color['hex'] ?? '#888888' }}
                                                    </p>
                                                </div>
                                            @endforeach
                                        </div>

                                        @if (isset($colorGroup['description']))
                                            <p class="text-gray-400 text-sm text-center">
                                                {{ $colorGroup['description'] }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <!-- Default Color Recommendations -->
                        <div class="space-y-6">
                            <div class="flex items-center gap-4">
                                <h2 class="text-xl md:text-2xl lg:text-3xl font-Kuunari text-Seasalt">REKOMENDASI WARNA
                                </h2>
                                <div class="flex-1 h-px bg-gradient-to-l from-Ecru to-transparent"></div>
                            </div>

                            <!-- Hair Color Palette -->
                            <div class="flex flex-wrap justify-center md:justify-start gap-4">
                                @foreach ($this->getRecommendedColors() as $color)
                                    <div class="group cursor-pointer"
                                        wire:click="selectColor({{ json_encode($color) }})"
                                        title="{{ $color['name'] }}">
                                        <div class="w-20 h-16 rounded-lg transition-all duration-300 hover:scale-110 hover:shadow-lg border-2 border-gray-700
                                                {{ $selectedColor && $selectedColor['name'] === $color['name'] ? 'ring-2 ring-Ecru ring-offset-2 ring-offset-black' : '' }}"
                                            style="background-color: {{ $color['hex'] }}">
                                        </div>
                                        <p class="text-xs text-center mt-2 text-Ecru font-Poppins">
                                            {{ $color['name'] }}</p>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Selected Color Description -->
                            @if ($selectedColor)
                                <div
                                    class="bg-gradient-to-r from-[#1A1A1A] to-[#2A2A2A] rounded-xl p-6 border border-gray-800">
                                    <h4 class="text-Ecru font-Kuunari text-lg mb-3 text-center">
                                        WARNA: {{ strtoupper($selectedColor['name'] ?? '') }}
                                    </h4>
                                    <p class="text-gray-300 text-sm text-center">
                                        {{ $selectedColor['description'] ?? '' }}</p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <!-- Enhanced Modal for Selected Haircut -->
            @if ($selectedHaircut && $showModal)
                <div class="fixed inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center z-50 p-4"
                    wire:click="closeModal">
                    <div class="bg-gradient-to-br from-[#1A1A1A] to-[#2A2A2A] rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto border border-gray-700"
                        wire:click.stop>

                        <!-- Modal Header -->
                        <div
                            class="sticky top-0 bg-gradient-to-r from-[#1A1A1A] to-[#2A2A2A] p-6 border-b border-gray-700 rounded-t-2xl">
                            <div class="flex items-center justify-between">
                                <h2 class="text-2xl font-Kuunari text-Ecru">
                                    {{ strtoupper($selectedHaircut['style'] ?? 'DETAIL GAYA RAMBUT') }}
                                </h2>
                                <button wire:click="closeModal"
                                    class="text-gray-400 hover:text-white transition-colors duration-300 p-2 hover:bg-gray-800 rounded-lg">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Modal Content -->
                        <div class="p-6">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                                <!-- Image Section -->
                                <div class="space-y-4">
                                    <div class="aspect-[3/4] bg-gray-900 rounded-xl overflow-hidden">
                                        <img src="{{ $selectedHaircut['image'] ?? asset('assets/images/crewcut.jpg') }}"
                                            alt="{{ $selectedHaircut['style'] ?? 'Style' }}"
                                            class="w-full h-full object-cover" />
                                    </div>

                                    <!-- Status Badge -->
                                    <div class="flex justify-center">
                                        @if ($selectedHaircut['is_fallback'] ?? false)
                                            <span
                                                class="inline-flex items-center gap-2 px-4 py-2 bg-yellow-500/20 text-yellow-400 border border-yellow-500/30 rounded-lg text-sm font-Kuunari">
                                                <div class="w-2 h-2 bg-yellow-500 rounded-full animate-pulse"></div>
                                                PREVIEW TIDAK TERSEDIA
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-2 px-4 py-2 bg-green-500/20 text-green-400 border border-green-500/30 rounded-lg text-sm font-Kuunari">
                                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                                AI GENERATED
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Details Section -->
                                <div class="space-y-6">

                                    <!-- Description -->
                                    @if (isset($selectedHaircut['description']))
                                        <div>
                                            <h3 class="text-Ecru font-Kuunari text-lg mb-3">DESKRIPSI</h3>
                                            <p class="text-gray-300 leading-relaxed">
                                                {{ $selectedHaircut['description'] ?? $this->getHaircutDescription($selectedHaircut['style'] ?? null) }}
                                            </p>
                                        </div>
                                    @endif

                                    <!-- Style Details -->
                                    @if (isset($selectedHaircut['details']))
                                        <div>
                                            <h3 class="text-Ecru font-Kuunari text-lg mb-3">DETAIL GAYA</h3>
                                            <div class="space-y-3">
                                                @foreach ($selectedHaircut['details'] as $key => $detail)
                                                    <div
                                                        class="flex justify-between py-2 border-b border-gray-700 last:border-b-0">
                                                        <span
                                                            class="text-gray-400 capitalize">{{ str_replace('_', ' ', $key) }}</span>
                                                        <span
                                                            class="text-white font-medium">{{ $detail }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Action Buttons -->
                                    <div class="space-y-3 pt-4">
                                        <button
                                            onclick="copyImageToClipboard('{{ $selectedHaircut['image'] ?? asset('assets/images/crewcut.jpg') }}', '{{ $selectedHaircut['style'] ?? 'Style' }}')"
                                            class="w-full flex items-center justify-center gap-3 px-6 py-4 bg-Ecru text-Eerie-Black rounded-lg hover:bg-Ecru/90 transition-all duration-300 transform hover:scale-[1.02] font-Kuunari font-bold">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                            SALIN GAMBAR
                                        </button>

                                        <button
                                            onclick="downloadImage('{{ $selectedHaircut['image'] ?? asset('assets/images/crewcut.jpg') }}', '{{ $selectedHaircut['style'] ?? 'Style' }}')"
                                            class="w-full flex items-center justify-center gap-3 px-6 py-4 bg-transparent text-Ecru border-2 border-Ecru rounded-lg hover:bg-Ecru hover:text-Eerie-Black transition-all duration-300 font-Kuunari font-bold">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            UNDUH GAMBAR
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!-- Enhanced Swiper JS for mobile carousel and modal interactions -->
    @push('scripts')
        <style>
            /* Button transition states for copy/download actions */
            .btn-loading {
                pointer-events: none;
                opacity: 0.7;
            }

            .btn-success {
                background-color: #10b981 !important;
                color: white !important;
            }

            .btn-warning {
                background-color: #f59e0b !important;
                color: white !important;
            }

            .btn-error {
                background-color: #ef4444 !important;
                color: white !important;
            }

            /* Smooth transitions for button states */
            button {
                transition: all 0.3s ease;
            }
        </style>
        <script>
            document.addEventListener('livewire:init', () => {
                function initSwiper() {
                    // Only initialize on mobile and if Swiper is available
                    if (window.innerWidth < 768 && typeof Swiper !== 'undefined') {
                        // Destroy existing swiper if any
                        if (window.hairSwiper) {
                            window.hairSwiper.destroy(true, true);
                        }

                        setTimeout(() => {
                            window.hairSwiper = new Swiper('.swiper', {
                                slidesPerView: "auto",
                                effect: "coverflow",
                                grabCursor: true,
                                centeredSlides: true,
                                spaceBetween: 15,
                                coverflowEffect: {
                                    rotate: 15,
                                    stretch: 0,
                                    depth: 120,
                                    modifier: 1,
                                    slideShadows: true,
                                },
                                loop: true,
                                pagination: {
                                    el: ".swiper-pagination",
                                    clickable: true,
                                },
                                // Add breakpoints for better responsiveness
                                breakpoints: {
                                    320: {
                                        spaceBetween: 10,
                                        coverflowEffect: {
                                            rotate: 10,
                                            depth: 100,
                                        }
                                    },
                                    480: {
                                        spaceBetween: 15,
                                        coverflowEffect: {
                                            rotate: 15,
                                            depth: 120,
                                        }
                                    }
                                }
                            });
                        }, 200);
                    }
                }

                // Modal backdrop click handler
                function handleModalBackdrop() {
                    document.addEventListener('click', function(event) {
                        // Close modal when clicking backdrop
                        if (event.target.classList.contains('modal-backdrop')) {
                            @this.call('closeModal');
                        }
                    });
                }

                // Image actions (copy, download)
                function handleImageActions() {
                    // Copy image to clipboard
                    window.copyImageToClipboard = async function(imageSrc, styleName) {
                        try {
                            const button = event.target.closest('button');
                            const originalText = button.innerHTML;

                            // Show loading state
                            button.innerHTML = `
                                <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-current mr-2"></div>
                                MENYALIN...
                            `;
                            button.disabled = true;

                            // Handle data URLs (base64 images)
                            if (imageSrc.startsWith('data:image/')) {
                                // Convert data URL to blob
                                const response = await fetch(imageSrc);
                                const blob = await response.blob();

                                if (navigator.clipboard && window.ClipboardItem) {
                                    const item = new ClipboardItem({
                                        [blob.type]: blob
                                    });
                                    await navigator.clipboard.write([item]);

                                    // Success feedback
                                    button.innerHTML = `
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        TERSALIN!
                                    `;
                                    button.classList.add('bg-green-500');

                                    setTimeout(() => {
                                        button.innerHTML = originalText;
                                        button.classList.remove('bg-green-500');
                                        button.disabled = false;
                                    }, 2000);
                                } else {
                                    throw new Error('Clipboard API not supported');
                                }
                            } else {
                                // Handle regular URLs
                                const response = await fetch(imageSrc);
                                const blob = await response.blob();

                                if (navigator.clipboard && window.ClipboardItem) {
                                    const item = new ClipboardItem({
                                        [blob.type]: blob
                                    });
                                    await navigator.clipboard.write([item]);

                                    button.innerHTML = `
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        TERSALIN!
                                    `;
                                    button.classList.add('bg-green-500');

                                    setTimeout(() => {
                                        button.innerHTML = originalText;
                                        button.classList.remove('bg-green-500');
                                        button.disabled = false;
                                    }, 2000);
                                } else {
                                    throw new Error('Clipboard API not supported');
                                }
                            }
                        } catch (error) {
                            console.error('Failed to copy image:', error);

                            // Fallback: try to copy image URL
                            try {
                                await navigator.clipboard.writeText(imageSrc);
                                button.innerHTML = `
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    URL TERSALIN!
                                `;
                                button.classList.add('bg-yellow-500');

                                setTimeout(() => {
                                    button.innerHTML = originalText;
                                    button.classList.remove('bg-yellow-500');
                                    button.disabled = false;
                                }, 2000);
                            } catch (fallbackError) {
                                button.innerHTML = `
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    GAGAL MENYALIN
                                `;
                                button.classList.add('bg-red-500');

                                setTimeout(() => {
                                    button.innerHTML = originalText;
                                    button.classList.remove('bg-red-500');
                                    button.disabled = false;
                                }, 2000);
                            }
                        }
                    };

                    // Download image
                    window.downloadImage = async function(imageSrc, styleName) {
                        try {
                            const button = event.target.closest('button');
                            const originalText = button.innerHTML;

                            // Show loading state
                            button.innerHTML = `
                                <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-current mr-2"></div>
                                MENGUNDUH...
                            `;
                            button.disabled = true;

                            let blob;
                            let filename =
                                `haircut-${styleName.toLowerCase().replace(/\s+/g, '-')}-recommendation.jpg`;

                            // Handle data URLs (base64 images)
                            if (imageSrc.startsWith('data:image/')) {
                                const response = await fetch(imageSrc);
                                blob = await response.blob();
                            } else {
                                // Handle regular URLs
                                const response = await fetch(imageSrc);
                                if (!response.ok) throw new Error('Failed to fetch image');
                                blob = await response.blob();
                            }

                            // Create download link
                            const url = window.URL.createObjectURL(blob);
                            const link = document.createElement('a');
                            link.href = url;
                            link.download = filename;
                            link.style.display = 'none';

                            // Trigger download
                            document.body.appendChild(link);
                            link.click();
                            document.body.removeChild(link);

                            // Clean up
                            window.URL.revokeObjectURL(url);

                            // Success feedback
                            button.innerHTML = `
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                BERHASIL DIUNDUH!
                            `;
                            button.classList.add('bg-green-500');

                            setTimeout(() => {
                                button.innerHTML = originalText;
                                button.classList.remove('bg-green-500');
                                button.disabled = false;
                            }, 2000);

                        } catch (error) {
                            console.error('Failed to download image:', error);

                            const button = event.target.closest('button');
                            const originalText = button.innerHTML;

                            button.innerHTML = `
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                GAGAL MENGUNDUH
                            `;
                            button.classList.add('bg-red-500');

                            setTimeout(() => {
                                button.innerHTML = originalText;
                                button.classList.remove('bg-red-500');
                                button.disabled = false;
                            }, 2000);
                        }
                    };
                }

                // Touch and gesture improvements for mobile
                function initTouchHandlers() {
                    let touchStartY = 0;

                    document.addEventListener('touchstart', function(e) {
                        touchStartY = e.touches[0].clientY;
                    }, {
                        passive: true
                    });

                    document.addEventListener('touchmove', function(e) {
                        // Prevent body scroll when modal is open
                        if (document.querySelector('.modal-backdrop')) {
                            e.preventDefault();
                        }
                    }, {
                        passive: false
                    });
                }

                // Initialize all functions
                initSwiper();
                handleModalBackdrop();
                handleImageActions();
                initTouchHandlers();

                // File size checking function
                window.checkFileSize = function(input) {
                    console.log('checkFileSize called');

                    const file = input.files[0];
                    if (!file) {
                        console.log('No file selected');
                        return true;
                    }

                    const maxSize = 2 * 1024 * 1024; // 2MB in bytes
                    const sizeMB = (file.size / (1024 * 1024)).toFixed(1);

                    console.log(`File: ${file.name}, Size: ${sizeMB}MB, Limit: 2MB`);

                    if (file.size > maxSize) {
                        console.log('File too large, showing notification');

                        // Clear the input immediately
                        input.value = '';

                        // Show Notyf notification using the global instance
                        if (typeof window.notyf !== 'undefined') {
                            window.notyf.error(`File "${file.name}" terlalu besar (${sizeMB} MB). Maksimal 2MB.`);
                        } else {
                            // Fallback to alert if notyf is not available
                            alert(`File "${file.name}" terlalu besar (${sizeMB} MB). Maksimal 2MB.`);
                        }

                        // Trigger Livewire to reset the model
                        if (typeof @this !== 'undefined') {
                            @this.call('resetUpload');
                        }

                        return false;
                    } else {
                        console.log('File size OK');
                        return true;
                    }
                };

                // Reinitialize swiper when analysis results update
                Livewire.on('analysis-updated', () => {
                    setTimeout(initSwiper, 100);
                });

                // Handle window resize
                window.addEventListener('resize', () => {
                    setTimeout(initSwiper, 100);
                });

                // Smooth scroll behavior for mobile
                if (window.innerWidth < 768) {
                    document.documentElement.style.scrollBehavior = 'smooth';
                }
            });

            // Utility functions for image handling
            function handleImageLoad(img) {
                img.classList.add('loaded');
                img.style.opacity = '1';
            }

            function handleImageError(img) {
                img.src = '/assets/images/crewcut.jpg'; // Fallback image
                img.classList.add('error');
            }

            // Lazy loading for images (optional performance enhancement)
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            if (img.dataset.src) {
                                img.src = img.dataset.src;
                                img.removeAttribute('data-src');
                                observer.unobserve(img);
                            }
                        }
                    });
                });

                // Observe all images with data-src attribute
                document.querySelectorAll('img[data-src]').forEach(img => {
                    imageObserver.observe(img);
                });
            }

            // Listen for Livewire processing events
            document.addEventListener('livewire:initialized', () => {
                console.log('🚀 Livewire initialized - setting up event listeners');

                // Main processing started event
                Livewire.on('processing-started', (event) => {
                    console.log('🚀 Processing started event fired!', event);
                    const overlay = document.getElementById('processing-overlay');
                    if (overlay) {
                        overlay.style.display = 'flex';
                        console.log('✅ Processing overlay shown');

                        // Initialize progress overlay when processing starts
                        if (typeof initProgressOverlay === 'function') {
                            initProgressOverlay();
                        } else {
                            console.warn('initProgressOverlay function not found');
                        }
                    }
                });

                // Start AI processing with delay to allow DOM update
                Livewire.on('start-ai-processing', () => {
                    console.log('🧠 Start AI processing event fired!');
                    // Use setTimeout to defer processing and allow DOM to update
                    setTimeout(() => {
                        console.log('🚀 Triggering AI processing...');
                        Livewire.dispatch('trigger-ai-processing');
                    }, 100); // Small delay to ensure overlay is shown
                });

                // Handle processing completed
                Livewire.on('processing-completed', () => {
                    console.log('✅ Processing completed event fired!');
                    const overlay = document.getElementById('processing-overlay');
                    if (overlay) {
                        setTimeout(() => {
                            overlay.style.display = 'none';
                            // Restore scroll when overlay is hidden
                            if (typeof restoreScroll === 'function') {
                                restoreScroll();
                            }
                        }, 2000);
                    }
                });

                // Handle analysis updated
                Livewire.on('analysis-updated', () => {
                    console.log('📊 Analysis results updated');
                    // Use setTimeout to ensure DOM is updated
                    setTimeout(() => {
                        if (typeof initSwiper === 'function') {
                            initSwiper();
                        } else {
                            console.warn('initSwiper function not found');
                        }
                    }, 100);
                });

                // Handle processing error
                Livewire.on('processing-error', (event) => {
                    console.log('❌ Processing error event fired!', event);
                    const overlay = document.getElementById('processing-overlay');
                    if (overlay) {
                        setTimeout(() => {
                            overlay.style.display = 'none';
                            // Restore scroll when overlay is hidden after error
                            if (typeof restoreScroll === 'function') {
                                restoreScroll();
                            }
                        }, 3000);
                    }
                });

                // Ensure scroll is restored on navigation
                document.addEventListener('livewire:navigating', () => {
                    if (typeof restoreScroll === 'function') {
                        restoreScroll();
                    }
                });
            });

            // Enhanced Progress Overlay Script with Step Highlighting
            let overlayInitialized = false;

            function initProgressOverlay() {
                if (overlayInitialized) {
                    console.log('⚠️ Progress overlay already initialized, skipping...');
                    return;
                }

                overlayInitialized = true;
                console.log('🎬 Initializing progress overlay...');

                // Prevent scrolling when overlay is visible
                document.body.style.overflow = 'hidden';
                document.documentElement.style.overflow = 'hidden';
                console.log('🔒 Scroll disabled for overlay');

                // Step display mapping - synchronized with PHP backend
                const stepDisplayMap = {
                    'error': 0,
                    'validation': 1,
                    'started': 1,
                    'upload': 1,
                    'analysis': 2,
                    'face_analysis': 2,
                    'generating_recommendations': 3,
                    'recommendations': 3,
                    'image_generation_1': 4,
                    'generation': 4,
                    'image_generation': 4,
                    'image_generation_2': 4,
                    'image_generation_3': 4,
                    'image_generation_4': 4,
                    'finalizing': 5,
                    'complete': 5
                };

                // Hair styles for visual feedback only
                const hairStyles = {
                    1: 'w-16 h-8 bg-gradient-to-b from-yellow-600 to-yellow-700 rounded-t-full',
                    2: 'w-18 h-6 bg-gradient-to-b from-red-600 to-red-700 rounded-t-full',
                    3: 'w-20 h-10 bg-gradient-to-b from-green-600 to-green-700',
                    4: 'w-16 h-12 bg-gradient-to-b from-blue-600 to-blue-700',
                    5: 'w-16 h-12 bg-gradient-to-b from-purple-600 to-purple-700 rounded-t-full'
                };

                let lastDisplayStep = 0;

                // Enhanced display function - simplified for Livewire components
                window.displayProgress = function(stepName, percentage, statusMessage) {
                    console.log(`🎨 Display: ${stepName} | ${percentage}% | ${statusMessage}`);

                    // Update progress bar (use exact values from PHP)
                    const progressBar = document.querySelector('.bg-gradient-to-r.from-Ecru');
                    if (progressBar) {
                        progressBar.style.width = `${percentage}%`;
                    }

                    // Update text displays
                    const stepText = document.getElementById('current-step-text');
                    const progressText = document.getElementById('progress-text');

                    if (stepText) stepText.textContent = statusMessage || stepName;
                    if (progressText) progressText.textContent = `${percentage}%`;

                    // Update hair style for visual feedback
                    const displayStep = stepDisplayMap[stepName] || 1;
                    const hair = document.getElementById('animated-hair');
                    if (hair && displayStep !== lastDisplayStep) {
                        const newHairStyle = hairStyles[displayStep] || hairStyles[1];
                        hair.className =
                            `absolute top-0 left-1/2 transform -translate-x-1/2 transition-all duration-1000 ease-out ${newHairStyle}`;

                        if (displayStep >= 3 && displayStep <= 4) {
                            hair.style.borderRadius = '50% 50% 20% 20%';
                        } else {
                            hair.style.borderRadius = '';
                        }

                        lastDisplayStep = displayStep;
                    }

                    // The step highlighting is now handled by the Livewire component
                    // No need to manually update DOM elements
                };
                window.restoreScroll = function() {
                    document.body.style.overflow = '';
                    document.documentElement.style.overflow = '';
                    overlayInitialized = false; // Reset for next time
                    lastDisplayStep = 0; // Reset step counter
                    console.log('✅ Scroll restored and overlay reset');
                };

                // Initialize display
                setTimeout(() => displayProgress('started', 5, 'Memulai analisis...'), 100);

                // Listen for Livewire updates and just display what we get
                Livewire.hook('morph.updated', ({
                    component
                }) => {
                    const currentStep = component.get('currentStep');
                    const progressPercentage = component.get('progressPercentage') || 0;
                    const progressStatus = component.get('progressStatus') || '';

                    console.log('🔄 Livewire morph updated:', {
                        currentStep,
                        progressPercentage,
                        progressStatus
                    });

                    // Always update display if we have step information
                    if (currentStep) {
                        displayProgress(currentStep, progressPercentage, progressStatus);

                        // Handle completion state specially - no auto-close
                        if (currentStep === 'complete') {
                            console.log('🎉 Complete! Showing finished message...');

                            // Update the status text to show "Selesai!"
                            const stepText = document.getElementById('current-step-text');
                            if (stepText) {
                                stepText.textContent = 'Selesai!';
                            }

                            // Show success notification
                            if (typeof window.notyf !== 'undefined') {
                                window.notyf.success({
                                    message: 'Analisis AI berhasil diselesaikan!',
                                    duration: 4000,
                                    ripple: true
                                });
                            }

                            // Wait 3 seconds before allowing closure
                            setTimeout(() => {
                                console.log('🎉 Now closing overlay...');
                                restoreScroll();
                                component.call('completeProcessing');
                            }, 3000); // Wait 3 seconds to show completion
                        }
                    }
                });
            }

            // Simple step animation helper (for visual feedback)
            function updateStepAnimation(step, percentage) {
                console.log('🎨 Updating step animation:', step, percentage + '%');

                // This is now handled by Livewire data binding
                // The progress bar and text are automatically updated via wire:poll
            }
        </script>
    @endpush

    <!-- Hidden polling element - responsive polling -->
    @if ($enablePolling)
        <div wire:poll.750ms="pollProgress" style="display: none;"></div>
    @endif
</div>
