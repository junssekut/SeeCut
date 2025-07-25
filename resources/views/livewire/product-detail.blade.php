<div class="flex flex-col min-h-screen w-full px-48 relative bg-[#0A0A0A]">

    <!-- Main Content -->
    <div class="relative">
        <!-- Tombol Panah -->
        <div class="pl-9 pt-9 pb-6">
            <a href="{{ route('barbershop.index') }}">
                <button
                    class="circle-button w-12 h-12 rounded-full bg-[#E9BF80] text-3xl flex justify-center items-center">
                    <img src="{{ asset('assets/images/panah.svg') }}" alt="panah" class="w-6 h-6">
                </button>
            </a>
        </div>

        <!-- Judul -->
        <div class="flex flex-col items-start font-Kuunari font-bold text-[#E9BF80] text-4xl pl-24">
            <h2>{{ strtoupper($vendor->name) }}</h2>
        </div>
        <!-- bintang -->
        <div class="flex mt-2 pl-24">
            @php
                $rating = $this->getAverageRating();
                $fullStars = floor($rating);
                $hasHalfStar = $rating - $fullStars >= 0.5;
                $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
            @endphp

            {{-- Full Stars --}}
            @for ($i = 0; $i < $fullStars; $i++)
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                    class="w-3 h-3 text-[#E9BF80] mx-0.5">
                    <path
                        d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.853 1.512 8.259L12 18.896l-7.448 4.522L6.064 15.16 0 9.307l8.332-1.151z" />
                </svg>
            @endfor

            {{-- Half Star --}}
            @if ($hasHalfStar)
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                    class="w-3 h-3 text-[#E9BF80] mx-0.5">
                    <defs>
                        <linearGradient id="half-star">
                            <stop offset="50%" stop-color="currentColor" />
                            <stop offset="50%" stop-color="transparent" />
                        </linearGradient>
                    </defs>
                    <path fill="url(#half-star)"
                        d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.853 1.512 8.259L12 18.896l-7.448 4.522L6.064 15.16 0 9.307l8.332-1.151z" />
                </svg>
            @endif

            {{-- Empty Stars --}}
            @for ($i = 0; $i < $emptyStars; $i++)
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    class="w-3 h-3 text-[#E9BF80] mx-0.5">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.853 1.512 8.259L12 18.896l-7.448 4.522L6.064 15.16 0 9.307l8.332-1.151z" />
                </svg>
            @endfor

            <span class="text-[#E9BF80] text-sm ml-2">({{ number_format($rating, 1) }})</span>
        </div>
        <!-- Gambar -->
        <div class="mt-4 px-24 py-6">
            @if ($vendor->hasActiveSubscription())
                <!-- Premium Interactive Gallery -->
                @php
                    $galleryImages = [];
                    // Add main thumbnail
                    if ($vendor->thumbnail_url) {
                        $galleryImages[] = $vendor->thumbnail_url;
                    }

                    // Add vendor photos (skip first one since it's used as thumbnail, get next 3)
// Use the actual photos relationship method to avoid accessor conflict
$vendorPhotos = $vendor->photos()->get();
if ($vendorPhotos->count() > 1) {
    // Skip the first photo and take the next 3 (photos 2, 3, 4)
    foreach ($vendorPhotos->skip(1)->take(3) as $photo) {
        // All photos should be 'link' type with external URLs
        $galleryImages[] = $photo->source;
    }
}

// Fill remaining slots with default image if needed
while (count($galleryImages) < 4) {
    $galleryImages[] = asset('assets/images/DashboardBarbershop.png');
                    }
                @endphp

                <div class="flex gap-6">
                    <!-- Main Image -->
                    <div class="flex-1">
                        <img id="mainImage"
                            src="{{ $vendor->thumbnail_url ?: asset('assets/images/DashboardBarbershop.png') }}"
                            alt="{{ $vendor->name }}"
                            class="w-full h-[640px] shadow-lg object-cover rounded-lg cursor-pointer hover:scale-[1.02] transition-transform duration-300">
                    </div>

                    <!-- Thumbnail Gallery -->
                    <div class="w-32 flex flex-col gap-4 h-[640px]">

                        @foreach ($galleryImages as $index => $image)
                            <div class="gallery-thumb {{ $index === 0 ? 'active' : '' }} flex-1 overflow-hidden"
                                data-image="{{ $image }}" data-index="{{ $index }}">
                                <img src="{{ $image }}" alt="Gallery image {{ $index + 1 }}"
                                    class="w-full h-full object-cover rounded-lg border-2 border-transparent cursor-pointer transition-all duration-300">
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <!-- Standard Single Image -->
                <div class="items-center justify-center flex">
                    @if ($vendor->thumbnail_url)
                        <img src="{{ $vendor->thumbnail_url }}" alt="{{ $vendor->name }}"
                            class="w-full h-[640px] shadow-lg object-cover rounded-lg">
                    @else
                        <img src="{{ asset('assets/images/DashboardBarbershop.png') }}"
                            alt="{{ $vendor->name ?? 'Barbershop' }}"
                            class="w-full h-[640px] shadow-lg object-cover rounded-lg">
                    @endif
                </div>
            @endif
        </div>
        @if ($vendor->hasActiveSubscription())
            <!-- Deskripsi -->
            <div class="flex flex-col items-start font-Kuunari font-bold text-[#E9BF80] text-4xl pl-24">
                <h2>DESKRIPSI</h2>
            </div>
            <div class="">
                <p class="text-[#FAFAFA] text-lg font-poppins pl-24 pr-24 mt-2">
                    {{ $vendor->description ?? 'Tidak ada deskripsi tersedia.' }}
                </p>
            </div>
        @endif
        <!-- Lokasi -->
        <div class="flex flex-col items-start font-Kuunari font-bold text-[#E9BF80] text-4xl pl-24 py-6">
            <h2>LOKASI</h2>
        </div>
        <div class="mt-4 px-24 items-center justify-center flex">
            <div class="w-full h-96 rounded-lg overflow-hidden shadow-lg border-2 border-[#B5964D]"
                id="vendor-location-map" wire:ignore>
            </div>
        </div>
        <!-- Alamat -->
        <div class="px-24 py-4">
            <div class="text-white text-center py-3 border border-[#B5964D] rounded mb-4">
                {{ $vendor->address ?? 'Alamat tidak tersedia' }}
            </div>
        </div>
        <!-- Jadwal Operasional Tabel -->
        <div class="overflow-x-auto w-full px-24">
            <table class="table-auto w-full text-center text-white border border-[#B5964D]">
                <thead>
                    <tr class="bg-[#B5964D] font-bold">
                        @php
                            $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
                        @endphp
                        @foreach ($days as $day)
                            <th class="border border-[#B5964D] px-2 py-2">{{ $day }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach ($days as $day)
                            <td class="border border-[#B5964D] px-2 py-2">{{ $this->getOperatingHours($day) }}</td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Kapster -->
        <div class="flex flex-col items-start font-Kuunari font-bold text-[#E9BF80] text-4xl pl-24 py-6">
            <h2>KAPSTER</h2>
        </div>

        @if ($this->hasHairstylists())
            <div class="flex flex-wrap items-center justify-center gap-14 px-10">
                @foreach ($vendor->hairstylists as $hairstylist)
                    <div
                        class="service-card-premium bg-[#1A1A1A] rounded-lg shadow-lg w-72 text-center px-4 py-6 border-t-4 border-[#E9BF80]">
                        <div class="overflow-hidden rounded-md mb-4">
                            @if ($hairstylist->vendorPhoto && $hairstylist->vendorPhoto->source)
                                <img src="{{ asset('storage/' . $hairstylist->vendorPhoto->source) }}"
                                    alt="{{ $hairstylist->name }}" class="w-full h-48 object-cover rounded-md" />
                            @else
                                <div class="w-full h-48 bg-[#2A2A2A] rounded-md flex items-center justify-center">
                                    <span class="text-[#888888] text-sm">No Image Available</span>
                                </div>
                            @endif
                        </div>
                        <h3 class="text-white text-lg font-Kuunari font-bold mb-2">
                            {{ strtoupper($hairstylist->name) }}
                        </h3>
                        <ul class="text-white text-sm mb-4 space-y-2">
                            <li>Hair Stylist Professional</li>
                            <li>Konsultasi Gaya & Trend</li>
                            <li>Pengalaman {{ rand(2, 8) }}+ Tahun</li>
                            <li>Spesialisasi Modern & Klasik</li>
                        </ul>
                        <button
                            class="premium-badge text-black font-semibold py-2 px-4 rounded text-sm hover:scale-105 transition-transform duration-200">
                            PILIH KAPSTER
                        </button>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Message when no hairstylists are listed --}}
            <div class="flex flex-col items-center justify-center py-16">
                <div class="bg-[#1A1A1A] rounded-lg shadow-lg p-8 text-center border border-[#E9BF80]/30 max-w-md">
                    <div class="mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-16 h-16 mx-auto text-[#E9BF80]">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v12.75A2.25 2.25 0 004.5 19.5zm6-10.125a1.875 1.875 0 11-3.75 0 1.875 1.875 0 013.75 0z" />
                        </svg>
                    </div>
                    <h3 class="text-white text-xl font-Kuunari font-bold mb-3">KAPSTER BELUM TERDAFTAR</h3>
                    <p class="text-[#B5B5B5] text-sm font-Poppins leading-relaxed mb-4">
                        Barbershop ini belum mencantumkan daftar kapster secara online.
                        Silakan hubungi barbershop secara langsung untuk informasi mengenai kapster yang tersedia.
                    </p>
                    <div class="bg-[#E9BF80]/10 border border-[#E9BF80]/30 rounded p-3">
                        <p class="text-[#E9BF80] text-xs font-Poppins">
                            💡 Tip: Anda tetap dapat melakukan reservasi melalui kontak yang tersedia di halaman ini.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- HARGA DAN LAYANAN -->
        <div class="px-24 mt-16">
            <h2 class="font-Kuunari font-bold text-[#E9BF80] text-4xl pl-4 py-6">HARGA DAN LAYANAN</h2>

            @if ($vendor->hasActiveSubscription())
                <div class="flex flex-wrap text-center justify-center gap-14">
                    @if ($vendor->services && $vendor->services->count() > 0)
                        @foreach ($vendor->services as $service)
                            <div
                                class="service-card-premium bg-[#1A1A1A] rounded-lg shadow-lg w-72 text-center px-4 py-6 border-t-4 border-[#E9BF80]">
                                <h3 class="text-white text-sm font-Poppins font-semibold mb-1">
                                    {{ strtoupper($service->service_name) }}</h3>
                                <div class="text-[#B5964D] text-6xl font-Kuunari font-bold mb-3">
                                    RP{{ number_format($service->price, 0, ',', '.') }}</div>
                                <ul class="text-white text-sm mb-4 space-y-4">
                                    <li>{{ $service->service_name }}</li>
                                    @if ($service->service_name != 'Kids Haircut')
                                        <li>Hair Wash Premium</li>
                                        <li>Konsultasi
                                            {{ $service->service_name == 'Hair Colouring' ? 'Warna' : 'Gaya' }}
                                        </li>
                                    @else
                                        <li>Hair Wash Premium</li>
                                        <li>Konsultasi Gaya</li>
                                    @endif
                                    <li>±{{ $service->price > 100000 ? '45' : ($service->price > 50000 ? '30' : '25') }}
                                        menit
                                    </li>
                                </ul>
                                <a href="{{ route('barbershop.book', ['vendor' => $vendor->id, 'service' => $service->id]) }}"
                                    class="premium-badge text-black font-semibold py-2 px-4 rounded text-sm hover:scale-105 transition-transform duration-200 inline-block text-center">
                                    RESERVASI SEKARANG
                                </a>
                            </div>
                        @endforeach
                    @else
                        {{-- Message when vendor has subscription but no services listed --}}
                        <div class="flex flex-col items-center justify-center py-16">
                            <div
                                class="bg-[#1A1A1A] rounded-lg shadow-lg p-8 text-center border border-[#E9BF80]/30 max-w-md">
                                <div class="mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="w-16 h-16 mx-auto text-[#E9BF80]">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0.621 0 1.125-.504 1.125-1.125V9.375c0-.621.504-1.125 1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                    </svg>
                                </div>
                                <h3 class="text-white text-xl font-Kuunari font-bold mb-3">LAYANAN BELUM TERDAFTAR</h3>
                                <p class="text-[#B5B5B5] text-sm font-Poppins leading-relaxed mb-4">
                                    Barbershop ini belum mencantumkan daftar layanan dan harga secara online.
                                    Silakan hubungi barbershop secara langsung untuk informasi lengkap mengenai layanan
                                    dan harga.
                                </p>
                                <div class="bg-[#E9BF80]/10 border border-[#E9BF80]/30 rounded p-3">
                                    <p class="text-[#E9BF80] text-xs font-Poppins">
                                        💡 Tip: Anda dapat melihat lokasi, jam operasional, dan ulasan barbershop ini di
                                        halaman ini.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @else
                {{-- Message when vendor has no active subscription --}}
                <div class="flex flex-col items-center justify-center py-16">
                    <div
                        class="disabled-status bg-[#1A1A1A] rounded-lg shadow-lg p-8 text-center border border-[#E9BF80]/30 max-w-md">
                        <div class="mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto text-[#E9BF80]">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                        </div>
                        <h3 class="text-white text-xl font-Kuunari font-bold mb-3">LAYANAN TIDAK TERSEDIA</h3>
                        <p class="text-[#B5B5B5] text-sm font-Poppins leading-relaxed mb-4">
                            Maaf, layanan reservasi online tidak tersedia untuk barbershop ini.
                            Silakan hubungi barbershop secara langsung untuk informasi layanan dan harga.
                        </p>
                        <div class="bg-[#E9BF80]/10 border border-[#E9BF80]/30 rounded p-3">
                            <p class="text-[#E9BF80] text-xs font-Poppins">
                                💡 Tip: Anda masih dapat melihat lokasi, jam operasional, dan ulasan barbershop ini di
                                halaman ini.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Penilaian -->
        <div class="flex flex-col items-start font-Kuunari font-bold text-[#E9BF80] text-4xl pl-24 py-6">
            <h2>PENILAIAN BABERSHOP</h2>
        </div>
        <!-- ULASAN -->
        <div class=" mt-6 px-24">
            <!-- Skor dan Filter -->
            <div class="bg-[#1A1A1A] p-6 rounded-md mb-10">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <!-- Skor -->
                    <div class="text-white text-4xl font-Kuunari flex flex-col items-center md:items-start gap-2">
                        <div class="flex items-end gap-2">
                            <span
                                class="text-[#E9BF80] text-5xl font-bold">{{ number_format($this->getAverageRating(), 1) }}</span>
                            <span class="text-white text-xl">dari</span>
                            <span class="text-[#E9BF80] text-5xl font-bold">5</span>
                        </div>

                        <!-- Bintang Rating -->
                        <div class="flex text-[#E9BF80] text-3xl mt-1">
                            @php
                                $rating = $this->getAverageRating();
                                $fullStars = floor($rating);
                                $hasHalfStar = $rating - $fullStars >= 0.5;
                                $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                            @endphp

                            {{-- Full Stars --}}
                            @for ($i = 0; $i < $fullStars; $i++)
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                                    class="w-4 h-4 text-[#E9BF80] mx-0.5">
                                    <path
                                        d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.853 1.512 8.259L12 18.896l-7.448 4.522L6.064 15.16 0 9.307l8.332-1.151z" />
                                </svg>
                            @endfor

                            {{-- Half Star --}}
                            @if ($hasHalfStar)
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                                    class="w-4 h-4 text-[#E9BF80] mx-0.5">
                                    <defs>
                                        <linearGradient id="half-star-large">
                                            <stop offset="50%" stop-color="currentColor" />
                                            <stop offset="50%" stop-color="transparent" />
                                        </linearGradient>
                                    </defs>
                                    <path fill="url(#half-star-large)"
                                        d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.853 1.512 8.259L12 18.896l-7.448 4.522L6.064 15.16 0 9.307l8.332-1.151z" />
                                </svg>
                            @endif

                            {{-- Empty Stars --}}
                            @for ($i = 0; $i < $emptyStars; $i++)
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" class="w-4 h-4 text-[#E9BF80] mx-0.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.853 1.512 8.259L12 18.896l-7.448 4.522L6.064 15.16 0 9.307l8.332-1.151z" />
                                </svg>
                            @endfor
                        </div>
                    </div>

                    <!-- Filter -->
                    <div class="flex flex-wrap gap-4 mt-4 md:mt-0 ml-12 justify-left max-w-4xl mx-auto">
                        <button wire:click="setReviewFilter('all')"
                            class="bg-[#0C0C0C] text-white border {{ $reviewFilter === 'all' ? 'border-[#E9BF80] bg-[#E9BF80]/20' : 'border-[#B5964D]' }} px-3 py-2 rounded text-sm hover:bg-[#B5964D] hover:text-black transition-all duration-200">
                            Semua ({{ $this->getTotalReviews() }})
                        </button>
                        <button wire:click="setReviewFilter('5')"
                            class="bg-[#0C0C0C] text-white border {{ $reviewFilter === '5' ? 'border-[#E9BF80] bg-[#E9BF80]/20' : 'border-[#B5964D]' }} px-3 py-2 rounded text-sm hover:bg-[#B5964D] hover:text-black transition-all duration-200">
                            5 Bintang ({{ $this->getReviewCountByRating(5) }})
                        </button>
                        <button wire:click="setReviewFilter('4')"
                            class="bg-[#0C0C0C] text-white border {{ $reviewFilter === '4' ? 'border-[#E9BF80] bg-[#E9BF80]/20' : 'border-[#B5964D]' }} px-3 py-2 rounded text-sm hover:bg-[#B5964D] hover:text-black transition-all duration-200">
                            4 Bintang ({{ $this->getReviewCountByRating(4) }})
                        </button>
                        <button wire:click="setReviewFilter('3')"
                            class="bg-[#0C0C0C] text-white border {{ $reviewFilter === '3' ? 'border-[#E9BF80] bg-[#E9BF80]/20' : 'border-[#B5964D]' }} px-3 py-2 rounded text-sm hover:bg-[#B5964D] hover:text-black transition-all duration-200">
                            3 Bintang ({{ $this->getReviewCountByRating(3) }})
                        </button>
                        <button wire:click="setReviewFilter('2')"
                            class="bg-[#0C0C0C] text-white border {{ $reviewFilter === '2' ? 'border-[#E9BF80] bg-[#E9BF80]/20' : 'border-[#B5964D]' }} px-3 py-2 rounded text-sm hover:bg-[#B5964D] hover:text-black transition-all duration-200">
                            2 Bintang ({{ $this->getReviewCountByRating(2) }})
                        </button>
                        <button wire:click="setReviewFilter('1')"
                            class="bg-[#0C0C0C] text-white border {{ $reviewFilter === '1' ? 'border-[#E9BF80] bg-[#E9BF80]/20' : 'border-[#B5964D]' }} px-3 py-2 rounded text-sm hover:bg-[#B5964D] hover:text-black transition-all duration-200">
                            1 Bintang ({{ $this->getReviewCountByRating(1) }})
                        </button>
                        <button wire:click="setReviewFilter('with_media')"
                            class="bg-[#0C0C0C] text-white border {{ $reviewFilter === 'with_media' ? 'border-[#E9BF80] bg-[#E9BF80]/20' : 'border-[#B5964D]' }} px-3 py-2 rounded text-sm hover:bg-[#B5964D] hover:text-black transition-all duration-200">
                            Dengan Media ({{ $this->getReviewCountByRating('with_media') }})
                        </button>
                    </div>
                </div>
            </div>

            <!-- Daftar Ulasan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if ($vendor->reviews && $vendor->reviews->count() > 0)
                    @php
                        // Filter reviews based on selected filter
                        $filteredReviews = $vendor->reviews;
                        if ($reviewFilter !== 'all') {
                            if ($reviewFilter === 'with_media') {
                                $filteredReviews = $vendor->reviews->filter(function ($review) {
                                    return $review->photos && $review->photos->count() > 0;
                                });
                            } else {
                                $filteredReviews = $vendor->reviews->filter(function ($review) use ($reviewFilter) {
                                    return $review->rating == $reviewFilter;
                                });
                            }
                        }
                        // Apply pagination
                        $paginatedReviews = $filteredReviews->take($currentReviewsCount);
                        $hasMoreReviews = $filteredReviews->count() > $currentReviewsCount;
                    @endphp

                    @forelse ($paginatedReviews as $review)
                        <div
                            class="border border-[#E9BF80] border-b-4 rounded-lg p-5 shadow-md shadow-[#E9BF80]/30 min-h-[180px] flex flex-col">
                            <div class="flex gap-4 mb-4">
                                <!-- Avatar with Initials -->
                                <div
                                    class="w-12 h-12 rounded-full bg-[#E9BF80] border-2 border-[#B5964D] flex items-center justify-center flex-shrink-0">
                                    <span
                                        class="text-black font-bold text-sm">{{ $this->getUserInitials($review->user_name ?? 'Anonymous') }}</span>
                                </div>

                                <!-- User Info -->
                                <div class="flex-grow">
                                    <h4 class="font-bold text-white text-sm mb-1">
                                        {{ $review->user_name ?? 'Anonymous' }}
                                    </h4>
                                    <div class="flex items-center gap-1 text-[#E9BF80] text-xs mb-1">
                                        @for ($j = 0; $j < 5; $j++)
                                            @if ($j < $review->rating)
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                    viewBox="0 0 24 24" class="w-3 h-3 text-[#E9BF80]">
                                                    <path
                                                        d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.853 1.512 8.259L12 18.896l-7.448 4.522L6.064 15.16 0 9.307l8.332-1.151z" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24"
                                                    class="w-3 h-3 text-[#E9BF80]">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.853 1.512 8.259L12 18.896l-7.448 4.522L6.064 15.16 0 9.307l8.332-1.151z" />
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                    <p class="text-xs text-[#888888]">
                                        {{ $review->iso_date ? date('d M Y, H:i', strtotime($review->iso_date)) : 'Tanggal tidak tersedia' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Review Content -->
                            <div class="flex-grow">
                                @if (!empty(trim($review->snippet ?? '')))
                                    <p class="text-sm text-white leading-relaxed mb-3">
                                        {{ $review->snippet }}
                                    </p>
                                @else
                                    <div class="flex items-center justify-center mb-3 py-2">
                                        <p class="text-sm text-[#888888] italic text-center">
                                            no text provided for this review
                                        </p>
                                    </div>
                                @endif

                                {{-- Show review photos if available --}}
                                @if ($review->photos && $review->photos->count() > 0)
                                    <div class="flex gap-2 flex-wrap">
                                        @foreach ($review->photos->take(4) as $photoIndex => $photo)
                                            <div class="relative">
                                                <img wire:click="openPhotoOverlay({{ json_encode($review->photos->map(function ($p) {return $p->type === 'link' ? $p->source : asset('storage/' . $p->source);})) }}, {{ $photoIndex }})"
                                                    src="{{ $photo->type === 'link' ? $photo->source : asset('storage/' . $photo->source) }}"
                                                    alt="Review photo"
                                                    class="w-16 h-16 object-cover rounded border border-[#E9BF80]/50 cursor-pointer hover:border-[#E9BF80] hover:opacity-90 transition-all duration-200">

                                                @if ($photoIndex === 3 && $review->photos->count() > 4)
                                                    <div class="absolute inset-0 bg-black/60 rounded flex items-center justify-center cursor-pointer"
                                                        wire:click="openPhotoOverlay({{ json_encode($review->photos->map(function ($p) {return $p->type === 'link' ? $p->source : asset('storage/' . $p->source);})) }}, {{ $photoIndex }})">
                                                        <span
                                                            class="text-white text-xs font-bold">+{{ $review->photos->count() - 4 }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-span-1 md:col-span-2">
                            <div class="bg-[#1A1A1A] rounded-lg p-8 text-center border border-[#E9BF80]/30">
                                <div class="mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor"
                                        class="w-12 h-12 mx-auto text-[#E9BF80]">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.691 1.342 3.058 3.004 3.058 1.04 0 1.95-.542 2.466-1.36l.469-.744a.75.75 0 01.45-.324l3.355-.838c.75-.187 1.49-.187 2.24 0l3.355.838c.177.044.338.13.45.324l.469.744c.516.818 1.426 1.36 2.466 1.36 1.662 0 3.004-1.367 3.004-3.058V8.724c0-1.69-1.342-3.057-3.004-3.057-1.04 0-1.95.542-2.466 1.36l-.469.744a.75.75 0 01-.45.324l-3.355.838c-.75.187-1.49.187-2.24 0l-3.355-.838a.75.75 0 01-.45-.324l-.469-.744C10.95 6.266 10.04 5.724 9 5.724c-1.662 0-3.004 1.367-3.004 3.057v3.515z" />
                                    </svg>
                                </div>
                                <h3 class="text-white text-lg font-Kuunari font-bold mb-2">Tidak Ada Ulasan</h3>
                                <p class="text-[#B5B5B5] text-sm">
                                    {{ $reviewFilter === 'with_media' ? 'Belum ada ulasan dengan media untuk filter ini.' : 'Belum ada ulasan dengan rating ' . $reviewFilter . ' bintang.' }}
                                </p>
                            </div>
                        </div>
                    @endforelse
                @else
                    {{-- Default reviews when none are available --}}
                    @php
                        $defaultReviews = [
                            [
                                'name' => 'Ahmad Rahman',
                                'rating' => 5,
                                'date' => '15 Jan 2025, 14:30',
                                'review' =>
                                    'Potongan di sini luar biasa! Hasilnya presisi, barbernya ramah, dan tempatnya nyaman. Pasti balik lagi!',
                            ],
                            [
                                'name' => 'Budi Santoso',
                                'rating' => 5,
                                'date' => '12 Jan 2025, 16:45',
                                'review' =>
                                    'Pelayanan sangat memuaskan! Kapster profesional dan hasil potongannya sesuai harapan. Highly recommended!',
                            ],
                            ['name' => 'Citra Dewi', 'rating' => 4, 'date' => '08 Jan 2025, 10:15', 'review' => ''],
                            [
                                'name' => 'Doni Pratama',
                                'rating' => 5,
                                'date' => '05 Jan 2025, 18:20',
                                'review' =>
                                    'Best barbershop in town! Skill kapsternya top notch, tempat cozy, dan harga reasonable. Mantap!',
                            ],
                        ];

                        // Sort default reviews the same way: with text first, then by date
                        $sortedDefaultReviews = collect($defaultReviews)
                            ->sort(function ($a, $b) {
                                // Priority: Reviews with text first
                                $aHasText = !empty(trim($a['review'] ?? ''));
                                $bHasText = !empty(trim($b['review'] ?? ''));

                                if ($aHasText && !$bHasText) {
                                    return -1; // a comes first
                                } elseif (!$aHasText && $bHasText) {
                                    return 1; // b comes first
                                }

                                // Then by date (most recent first)
                                return strtotime($b['date']) <=> strtotime($a['date']);
                            })
                            ->values()
                            ->toArray();
                    @endphp

                    @foreach ($sortedDefaultReviews as $review)
                        <div
                            class="border border-[#E9BF80] border-b-4 rounded-lg p-5 shadow-md shadow-[#E9BF80]/30 min-h-[180px] flex flex-col">
                            <div class="flex gap-4 mb-4">
                                <!-- Avatar with Initials -->
                                <div
                                    class="w-12 h-12 rounded-full bg-[#E9BF80] border-2 border-[#B5964D] flex items-center justify-center flex-shrink-0">
                                    <span
                                        class="text-black font-bold text-sm">{{ $this->getUserInitials($review['name']) }}</span>
                                </div>

                                <!-- User Info -->
                                <div class="flex-grow">
                                    <h4 class="font-bold text-white text-sm mb-1">{{ $review['name'] }}</h4>
                                    <div class="flex items-center gap-1 text-[#E9BF80] text-xs mb-1">
                                        @for ($j = 0; $j < 5; $j++)
                                            @if ($j < $review['rating'])
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                    viewBox="0 0 24 24" class="w-3 h-3 text-[#E9BF80]">
                                                    <path
                                                        d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.853 1.512 8.259L12 18.896l-7.448 4.522L6.064 15.16 0 9.307l8.332-1.151z" />
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24"
                                                    class="w-3 h-3 text-[#E9BF80]">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.853 1.512 8.259L12 18.896l-7.448 4.522L6.064 15.16 0 9.307l8.332-1.151z" />
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                    <p class="text-xs text-[#888888]">{{ $review['date'] }}</p>
                                </div>
                            </div>

                            <!-- Review Content -->
                            <div class="flex-grow">
                                @if (!empty(trim($review['review'] ?? '')))
                                    <p class="text-sm text-white leading-relaxed">{{ $review['review'] }}</p>
                                @else
                                    <div class="flex items-center justify-center py-2">
                                        <p class="text-sm text-[#888888] italic text-center">
                                            no text provided for this review
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Tombol Lainnya -->
            @if ($vendor->reviews && $vendor->reviews->count() > 0)
                @php
                    // Calculate if there are more reviews to show
                    $filteredReviews = $vendor->reviews;
                    if ($reviewFilter !== 'all') {
                        if ($reviewFilter === 'with_media') {
                            $filteredReviews = $vendor->reviews->filter(function ($review) {
                                return $review->photos && $review->photos->count() > 0;
                            });
                        } else {
                            $filteredReviews = $vendor->reviews->filter(function ($review) use ($reviewFilter) {
                                return $review->rating == $reviewFilter;
                            });
                        }
                    }
                    $hasMoreReviews = $filteredReviews->count() > $currentReviewsCount;
                @endphp

                @if ($hasMoreReviews)
                    <div class="flex justify-center mt-10">
                        <button wire:click="loadMoreReviews"
                            class="text-white font-Kuunari font-bold text-xl hover:underline hover:text-[#E9BF80] transition-colors duration-200">
                            LAINNYA →
                        </button>
                    </div>
                @endif
            @endif
        </div>

    </div> <!-- Close main content div -->
</div> <!-- Close main container -->

<!-- Photo Overlay Modal (outside main container) -->
@if ($showPhotoOverlay)
    <div class="fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center"
        wire:click="closePhotoOverlay">
        <div class="relative max-w-4xl max-h-full p-4" wire:click.stop>
            <!-- Close Button -->
            <button wire:click="closePhotoOverlay"
                class="absolute -top-12 right-0 text-white hover:text-[#E9BF80] transition-colors duration-200 z-10">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Photo Counter -->
            @if (count($overlayPhotos) > 1)
                <div class="absolute -top-12 left-0 text-white text-sm">
                    {{ $currentPhotoIndex + 1 }} / {{ count($overlayPhotos) }}
                </div>
            @endif

            <!-- Navigation Buttons -->
            @if (count($overlayPhotos) > 1)
                <!-- Previous Button -->
                @if ($currentPhotoIndex > 0)
                    <button wire:click="prevPhoto"
                        class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white rounded-full p-2 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </button>
                @endif

                <!-- Next Button -->
                @if ($currentPhotoIndex < count($overlayPhotos) - 1)
                    <button wire:click="nextPhoto"
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white rounded-full p-2 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>
                @endif
            @endif

            <!-- Photo -->
            @if (isset($overlayPhotos[$currentPhotoIndex]))
                <img src="{{ $overlayPhotos[$currentPhotoIndex] }}" alt="Review photo"
                    class="max-w-full max-h-[80vh] object-contain rounded-lg shadow-2xl">
            @endif
        </div>
    </div>
@endif

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #vendor-location-map.leaflet-container {
            border-radius: 0.5rem;
            box-shadow: 0 10px 25px 0 rgba(233, 191, 128, 0.2);
        }

        .leaflet-popup-content-wrapper {
            background: #1A1A1A;
            color: #FAFAFA;
            border-radius: 0.5rem;
            border: 1px solid #E9BF80;
        }

        .leaflet-popup-tip {
            background: #1A1A1A;
            border: 1px solid #E9BF80;
        }

        .custom-marker {
            background: #E9BF80;
            border: 3px solid #B5964D;
            border-radius: 50%;
            width: 20px;
            height: 20px;
        }

        /* Enhanced Service card animations for premium vendors */
        .service-card-premium {
            transition: all 0.5s ease;
            position: relative;
            overflow: hidden;
        }

        .service-card-premium::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(233, 191, 128, 0.04), transparent, rgba(181, 150, 77, 0.03), transparent);
            transition: all 1.2s ease;
            transform: translateX(-100%) translateY(-100%) rotate(-45deg);
        }

        .service-card-premium:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(233, 191, 128, 0.18), 0 4px 15px rgba(181, 150, 77, 0.12);
        }

        .service-card-premium:hover::before {
            transform: translateX(100%) translateY(100%) rotate(45deg);
        }

        /* Enhanced premium badge with sophisticated shimmer */
        @keyframes sophisticated-shimmer {
            0% {
                background-position: -300% center;
                transform: scale(1);
            }

            50% {
                transform: scale(1.02);
            }

            100% {
                background-position: 300% center;
                transform: scale(1);
            }
        }

        .premium-badge {
            background: linear-gradient(90deg, #E9BF80, #B5964D, #E9BF80, #B5964D, #E9BF80);
            background-size: 300% 100%;
            animation: sophisticated-shimmer 5s ease-in-out infinite;
            position: relative;
            overflow: hidden;
        }

        .premium-badge::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.6s ease;
        }

        .premium-badge:hover::after {
            left: 100%;
        }

        /* Gentle fade in animation for service cards */
        @keyframes gentle-fade-in {
            0% {
                opacity: 0;
                transform: translateY(10px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-gentle-fade-in {
            animation: gentle-fade-in 1.2s ease-out forwards;
        }

        /* Premium Gallery Styles */
        .gallery-thumb {
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .gallery-thumb img {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .gallery-thumb.active img {
            border-color: #E9BF80 !important;
            box-shadow: 0 0 15px rgba(233, 191, 128, 0.3);
        }

        .gallery-thumb:hover img {
            border-color: #E9BF80;
            opacity: 0.9;
        }

        .gallery-thumb.active:hover img {
            opacity: 1;
        }

        #mainImage:hover {
            box-shadow: 0 15px 40px rgba(233, 191, 128, 0.1);
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initializeVendorLocationMap();
            initializeServiceAnimations();
            initializeGallery();
        });

        function initializeServiceAnimations() {
            // Add gentle stagger animation to service cards and enhance all interactions
            const serviceCards = document.querySelectorAll('.service-card-premium');
            serviceCards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.2}s`;
                card.classList.add('animate-gentle-fade-in');

                // Enhanced hover effects for premium cards
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-3px)';
                    this.style.boxShadow = '0 12px 30px rgba(233, 191, 128, 0.12)';
                    this.style.transition = 'all 0.5s cubic-bezier(0.4, 0.0, 0.2, 1)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 4px 15px rgba(0, 0, 0, 0.1)';
                });
            });

            // Enhanced premium badge effects with sophisticated interactions
            const premiumBadges = document.querySelectorAll('.premium-badge');
            premiumBadges.forEach(badge => {
                badge.addEventListener('mouseenter', function() {
                    this.style.boxShadow =
                        '0 0 20px rgba(233, 191, 128, 0.4), 0 0 35px rgba(181, 150, 77, 0.2)';
                    this.style.transform = 'scale(1.03) translateY(-1px)';
                    this.style.transition = 'all 0.4s cubic-bezier(0.4, 0.0, 0.2, 1)';
                    this.style.filter = 'brightness(1.1) saturate(1.1)';
                });

                badge.addEventListener('mouseleave', function() {
                    this.style.boxShadow = 'none';
                    this.style.transform = 'scale(1) translateY(0)';
                    this.style.filter = 'brightness(1) saturate(1)';
                });
            });
        }

        function initializeGallery() {
            // Check if gallery exists (premium vendor only)
            const galleryThumbs = document.querySelectorAll('.gallery-thumb');
            const mainImage = document.getElementById('mainImage');

            if (!galleryThumbs.length || !mainImage) {
                return;
            }

            // Add click handlers to thumbnails
            galleryThumbs.forEach(thumb => {
                thumb.addEventListener('click', function() {
                    const newImageSrc = this.dataset.image;

                    // Remove active class from all thumbnails
                    galleryThumbs.forEach(t => t.classList.remove('active'));

                    // Add active class to clicked thumbnail
                    this.classList.add('active');

                    // Change main image with fade effect
                    mainImage.style.opacity = '0.5';
                    mainImage.style.transform = 'scale(0.98)';

                    setTimeout(() => {
                        mainImage.src = newImageSrc;
                        mainImage.style.opacity = '1';
                        mainImage.style.transform = 'scale(1)';
                    }, 200);
                });

                // Add hover effects
                thumb.addEventListener('mouseenter', function() {
                    if (!this.classList.contains('active')) {
                        this.querySelector('img').style.borderColor = '#E9BF80';
                        this.querySelector('img').style.opacity = '0.8';
                    }
                });

                thumb.addEventListener('mouseleave', function() {
                    if (!this.classList.contains('active')) {
                        this.querySelector('img').style.borderColor = 'transparent';
                        this.querySelector('img').style.opacity = '1';
                    }
                });
            });

            // Add keyboard navigation
            document.addEventListener('keydown', function(e) {
                const currentActive = document.querySelector('.gallery-thumb.active');
                if (!currentActive) return;

                const currentIndex = parseInt(currentActive.dataset.index);
                let nextIndex = currentIndex;

                if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') {
                    nextIndex = currentIndex > 0 ? currentIndex - 1 : galleryThumbs.length - 1;
                } else if (e.key === 'ArrowRight' || e.key === 'ArrowDown') {
                    nextIndex = currentIndex < galleryThumbs.length - 1 ? currentIndex + 1 : 0;
                }

                if (nextIndex !== currentIndex) {
                    galleryThumbs[nextIndex].click();
                }
            });
        }

        function initializeVendorLocationMap() {
            // Get vendor coordinates
            let vendorLat = {{ $vendor->latitude ?? -6.2 }};
            let vendorLng = {{ $vendor->longitude ?? 106.816666 }};
            let vendorName = @json($vendor->name ?? 'Barbershop');
            let vendorAddress = @json($vendor->address ?? 'Alamat tidak tersedia');

            // Wait for the DOM element to be available
            const mapElement = document.getElementById('vendor-location-map');
            if (!mapElement) {
                console.log('Map element not found, retrying...');
                setTimeout(initializeVendorLocationMap, 100);
                return;
            }

            // Initialize map
            const map = L.map('vendor-location-map', {
                zoomControl: false,
                scrollWheelZoom: false,
            }).setView([vendorLat, vendorLng], 15);

            // Add zoom control to top right
            L.control.zoom({
                position: 'topright'
            }).addTo(map);

            // Add tile layer with custom styling
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Create custom marker
            const customIcon = L.divIcon({
                className: 'custom-marker',
                iconSize: [20, 20],
                iconAnchor: [10, 10],
                popupAnchor: [0, -10]
            });

            // Add marker with popup
            const marker = L.marker([vendorLat, vendorLng], {
                icon: customIcon
            }).addTo(map);

            // Create popup content
            const popupContent = `
                <div style='min-width:200px; padding: 8px;'>
                    <div style='font-weight: bold; font-size: 16px; margin-bottom: 8px; color: #E9BF80;'>
                        ${vendorName}
                    </div>
                    <div style='font-size: 14px; line-height: 1.4; margin-bottom: 8px;'>
                        ${vendorAddress}
                    </div>
                    <div style='font-size: 12px; color: #B5964D;'>
                        Lat: ${vendorLat.toFixed(6)}, Lng: ${vendorLng.toFixed(6)}
                    </div>
                    <div style='margin-top: 8px;'>
                        <a href='https://www.google.com/maps/dir/?api=1&destination=${vendorLat},${vendorLng}' 
                           target='_blank' 
                           style='color: #E9BF80; text-decoration: underline; font-size: 12px;'>
                            Buka di Google Maps →
                        </a>
                    </div>
                </div>
            `;

            marker.bindPopup(popupContent);
            marker.openPopup();

            // Force map to recalculate size
            setTimeout(() => {
                map.invalidateSize();
            }, 100);

            // Add click handler to enable scroll zoom when clicked
            map.on('click', function() {
                map.scrollWheelZoom.enable();
                const notification = L.popup()
                    .setLatLng([vendorLat + 0.001, vendorLng])
                    .setContent('<div style="color: #E9BF80; font-size: 12px;">Scroll to zoom enabled</div>')
                    .openOn(map);

                setTimeout(() => {
                    map.closePopup(notification);
                }, 2000);
            });

            // Disable scroll zoom when mouse leaves the map
            mapElement.addEventListener('mouseleave', function() {
                map.scrollWheelZoom.disable();
            });
        }
    </script>
@endpush
