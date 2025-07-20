<div class="flex flex-col bg-[#0C0C0C] min-h-screen w-full px-48">
    <!-- Tombol Panah -->
    <div class="pl-9 pt-9 pb-6">
        <a href="#">
            <button class="circle-button w-12 h-12 rounded-full bg-[#E9BF80] text-3xl flex justify-center items-center">
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
    <div class="mt-4 px-24 py-6 items-center justify-center flex">
        @if ($vendor->thumbnail)
            <img src="{{ $vendor->thumbnail->source }}" alt="{{ $vendor->name }}"
                class="w-full h-auto shadow-lg object-cover rounded-lg">
        @else
            <img src="{{ asset('assets/images/DashboardBarbershop.png') }}" alt="{{ $vendor->name ?? 'Barbershop' }}"
                class="w-full h-auto shadow-lg object-cover rounded-lg">
        @endif
    </div>
    <!-- Deskripsi -->
    <div class="flex flex-col items-start font-Kuunari font-bold text-[#E9BF80] text-4xl pl-24">
        <h2>DESKRIPSI</h2>
    </div>
    <div class="">
        <p class="text-[#FAFAFA] text-lg font-poppins pl-24 pr-24 mt-2">
            {{ $vendor->description ?? 'Tidak ada deskripsi tersedia.' }}
        </p>
    </div>
    <!-- Lokasi -->
    <div class="flex flex-col items-start font-Kuunari font-bold text-[#E9BF80] text-4xl pl-24 py-6">
        <h2>LOKASI</h2>
    </div>
    <div class="mt-4 px-24 items-center justify-center flex">
        <div class="w-full h-96 rounded-lg overflow-hidden shadow-lg border-2 border-[#B5964D]" id="vendor-location-map"
            wire:ignore>
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

    <div class="flex flex-wrap items-center justify-center gap-14 px-10">
        @if ($vendor->hairstylists && $vendor->hairstylists->count() > 0)
            @foreach ($vendor->hairstylists as $hairstylist)
                <div class="bg-[#1A1A1A] rounded-lg shadow-md w-72 text-center pt-0">
                    <div class="overflow-hidden rounded-md border-t-4 border-[#E9BF80] px-3 pt-3">
                        @if ($hairstylist->vendorPhoto && $hairstylist->vendorPhoto->source)
                            <img src="{{ asset('storage/' . $hairstylist->vendorPhoto->source) }}" alt="{{ $hairstylist->name }}"
                                class="w-full h-56 object-cover rounded-md" />
                        @else
                            <div class="w-full h-56 bg-[#2A2A2A] rounded-md flex items-center justify-center">
                                <span class="text-[#888888] text-sm">No Image Available</span>
                            </div>
                        @endif
                    </div>
                    <div class="text-white font-bold py-4 text-2xl font-kunari">{{ strtoupper($hairstylist->name) }}
                    </div>
                </div>
            @endforeach
        @else
            {{-- Default data when no hairstylists are available --}}
            @for ($i = 0; $i < 3; $i++)
                <div class="bg-[#1A1A1A] rounded-lg shadow-md w-72 text-center pt-0">
                    <div class="overflow-hidden rounded-md border-t-4 border-[#E9BF80] px-3 pt-3">
                        <img src="{{ asset('assets/images/kapster.png') }}" alt="Kapster"
                            class="w-full h-56 object-cover rounded-md" />
                    </div>
                    <div class="text-white font-bold py-4 text-2xl font-kunari">ARJUNA</div>
                </div>
            @endfor
        @endif
    </div>

    <!-- HARGA DAN LAYANAN -->
    <div class="px-24 mt-16">
        <h2 class="font-Kuunari font-bold text-[#E9BF80] text-4xl pl-4 py-6">HARGA DAN LAYANAN</h2>

        @if ($vendor->subscription && $vendor->subscription->is_active)
            <div class="flex flex-wrap text-center justify-center gap-14">
                @if ($vendor->services && $vendor->services->count() > 0)
                    @foreach ($vendor->services as $service)
                    <div
                        class="bg-[#1A1A1A] rounded-lg shadow-lg w-72 text-center px-4 py-6 border-t-4 border-[#E9BF80]">
                        <h3 class="text-white text-sm font-Poppins font-semibold mb-1">
                            {{ strtoupper($service->service_name) }}</h3>
                        <div class="text-[#B5964D] text-6xl font-Kuunari font-bold mb-3">
                            {{ number_format($service->price, 0, ',', '.') }}K</div>
                        <ul class="text-white text-sm mb-4 space-y-4">
                            <li>{{ $service->service_name }}</li>
                            @if ($service->service_name != 'Kids Haircut')
                                <li>Hair Wash Premium</li>
                                <li>Konsultasi {{ $service->service_name == 'Hair Colouring' ? 'Warna' : 'Gaya' }}</li>
                            @else
                                <li>Hair Wash Premium</li>
                                <li>Konsultasi Gaya</li>
                            @endif
                            <li>±{{ $service->price > 100000 ? '45' : ($service->price > 50000 ? '30' : '25') }} menit
                            </li>
                        </ul>
                        <button
                            class="bg-[#B5964D] text-black font-semibold py-2 px-4 rounded text-sm hover:bg-[#d5ac5a]">
                            RESERVASI SEKARANG
                        </button>
                    </div>
                @endforeach
            @else
                {{-- Default services data when none are available but vendor has subscription --}}
                @php
                    $defaultServices = [
                        ['name' => 'HAIRCUT PREMIUM', 'price' => '60K', 'duration' => '30'],
                        ['name' => 'HAIR COLOURING', 'price' => '120K', 'duration' => '45'],
                        ['name' => 'KIDS HAIRCUT', 'price' => '45K', 'duration' => '25'],
                    ];
                @endphp

                @foreach ($defaultServices as $service)
                    <div
                        class="bg-[#1A1A1A] rounded-lg shadow-lg w-72 text-center px-4 py-6 border-t-4 border-[#E9BF80]">
                        <h3 class="text-white text-sm font-Poppins font-semibold mb-1">{{ $service['name'] }}</h3>
                        <div class="text-[#B5964D] text-6xl font-Kuunari font-bold mb-3">{{ $service['price'] }}</div>
                        <ul class="text-white text-sm mb-4 space-y-4">
                            <li>Cutting & {{ $service['name'] == 'HAIR COLOURING' ? 'Colouring' : 'Styling' }}</li>
                            <li>Hair Wash Premium</li>
                            <li>Konsultasi {{ $service['name'] == 'HAIR COLOURING' ? 'Warna' : 'Gaya' }}</li>
                            <li>±{{ $service['duration'] }} menit</li>
                        </ul>
                        <button
                            class="bg-[#B5964D] text-black font-semibold py-2 px-4 rounded text-sm hover:bg-[#d5ac5a]">
                            RESERVASI SEKARANG
                        </button>
                    </div>
                @endforeach
            @endif
            </div>
        @else
            {{-- Message when vendor has no active subscription --}}
            <div class="flex flex-col items-center justify-center py-16">
                <div class="bg-[#1A1A1A] rounded-lg shadow-lg p-8 text-center border border-[#E9BF80]/30 max-w-md">
                    <div class="mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-16 h-16 mx-auto text-[#E9BF80]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    </div>
                    <h3 class="text-white text-xl font-Kuunari font-bold mb-3">LAYANAN TIDAK TERSEDIA</h3>
                    <p class="text-[#B5B5B5] text-sm font-Poppins leading-relaxed mb-4">
                        Maaf, layanan reservasi online tidak tersedia untuk barbershop ini. 
                        Silakan hubungi barbershop secara langsung untuk informasi layanan dan harga.
                    </p>
                    <div class="bg-[#E9BF80]/10 border border-[#E9BF80]/30 rounded p-3">
                        <p class="text-[#E9BF80] text-xs font-Poppins">
                            💡 Tip: Anda masih dapat melihat lokasi, jam operasional, dan ulasan barbershop ini di halaman ini.
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
    <div class="bg-[#000000] mt-6 px-24">
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
                <div class="flex flex-wrap gap-8 mt-4 md:mt-0 justify-center max-w-4xl mx-auto">
                    <button wire:click="setReviewFilter('all')"
                        class="bg-[#0C0C0C] text-white border {{ $reviewFilter === 'all' ? 'border-[#E9BF80] bg-[#E9BF80]/20' : 'border-[#B5964D]' }} px-4 py-1 rounded hover:bg-[#B5964D] hover:text-black transition-colors">
                        Semua ({{ $this->getTotalReviews() }})
                    </button>
                    <button wire:click="setReviewFilter('5')"
                        class="bg-[#0C0C0C] text-white {{ $reviewFilter === '5' ? 'border-[#E9BF80] bg-[#E9BF80]/20' : '' }} px-4 py-1 rounded hover:bg-[#B5964D] hover:text-black transition-colors">
                        5 Bintang ({{ $this->getReviewCountByRating(5) }})
                    </button>
                    <button wire:click="setReviewFilter('4')"
                        class="bg-[#0C0C0C] text-white {{ $reviewFilter === '4' ? 'border-[#E9BF80] bg-[#E9BF80]/20' : '' }} px-4 py-1 rounded hover:bg-[#B5964D] hover:text-black transition-colors">
                        4 Bintang ({{ $this->getReviewCountByRating(4) }})
                    </button>
                    <button wire:click="setReviewFilter('3')"
                        class="bg-[#0C0C0C] text-white {{ $reviewFilter === '3' ? 'border-[#E9BF80] bg-[#E9BF80]/20' : '' }} px-4 py-1 rounded hover:bg-[#B5964D] hover:text-black transition-colors">
                        3 Bintang ({{ $this->getReviewCountByRating(3) }})
                    </button>
                    <button wire:click="setReviewFilter('2')"
                        class="bg-[#0C0C0C] text-white {{ $reviewFilter === '2' ? 'border-[#E9BF80] bg-[#E9BF80]/20' : '' }} px-4 py-1 rounded hover:bg-[#B5964D] hover:text-black transition-colors">
                        2 Bintang ({{ $this->getReviewCountByRating(2) }})
                    </button>
                    <button wire:click="setReviewFilter('1')"
                        class="bg-[#0C0C0C] text-white {{ $reviewFilter === '1' ? 'border-[#E9BF80] bg-[#E9BF80]/20' : '' }} px-4 py-1 rounded hover:bg-[#B5964D] hover:text-black transition-colors">
                        1 Bintang ({{ $this->getReviewCountByRating(1) }})
                    </button>
                    <button wire:click="setReviewFilter('with_media')"
                        class="bg-[#0C0C0C] text-white {{ $reviewFilter === 'with_media' ? 'border-[#E9BF80] bg-[#E9BF80]/20' : '' }} px-4 py-1 rounded hover:bg-[#B5964D] hover:text-black transition-colors">
                        Dengan Media ({{ $this->getReviewCountByRating('with_media') }})
                    </button>
                </div>
            </div>
        </div>

        <!-- Daftar Ulasan -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @if ($vendor->reviews && $vendor->reviews->count() > 0)
                @foreach ($vendor->reviews as $review)
                    <div
                        class="border border-[#E9BF80] border-b-4 rounded-lg p-5 flex gap-4 shadow-md shadow-[#E9BF80]/30">
                        <!-- Avatar -->
                        <div class="w-14 h-10 rounded-full bg-white border border-[#E9BF80]"></div>

                        <!-- Konten -->
                        <div class="text-white">
                            <h4 class="font-bold">{{ $review->user_name ?? 'Anonymous' }}</h4>
                            <div class="flex items-center gap-1 text-[#E9BF80] text-sm">
                                @for ($j = 0; $j < 5; $j++)
                                    @if ($j < $review->rating)
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 24 24" class="w-3 h-3 text-[#E9BF80] mx-0.5">
                                            <path
                                                d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.853 1.512 8.259L12 18.896l-7.448 4.522L6.064 15.16 0 9.307l8.332-1.151z" />
                                        </svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" class="w-3 h-3 text-[#E9BF80] mx-0.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 .587l3.668 7.568 8.332 1.151-6.064 5.853 1.512 8.259L12 18.896l-7.448 4.522L6.064 15.16 0 9.307l8.332-1.151z" />
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <p class="text-xs text-[#888888] mb-2">
                                {{ $review->iso_date ? date('Y-m-d H:i', strtotime($review->iso_date)) : 'Tanggal tidak tersedia' }}
                            </p>
                            <p class="text-sm">
                                {{ $review->snippet ?? 'Tidak ada ulasan tersedia.' }}
                            </p>

                            {{-- Show review photos if available --}}
                            @if ($review->photos && $review->photos->count() > 0)
                                <div class="mt-3 flex gap-2">
                                    @foreach ($review->photos->take(3) as $photo)
                                        <img src="{{ $photo->type === 'link' ? $photo->source : asset('storage/' . $photo->source) }}"
                                            alt="Review photo"
                                            class="w-16 h-16 object-cover rounded border border-[#E9BF80]/50">
                                    @endforeach
                                    @if ($review->photos->count() > 3)
                                        <div
                                            class="w-16 h-16 bg-[#E9BF80]/20 border border-[#E9BF80] rounded flex items-center justify-center text-xs text-[#E9BF80]">
                                            +{{ $review->photos->count() - 3 }}
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                {{-- Default reviews when none are available --}}
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
            @endif
        </div>

        <!-- Tombol Lainnya -->
        <div class="flex justify-center mt-10">
            <button class="text-white font-Kuunari font-bold text-xl hover:underline">
                LAINNYA →
            </button>
        </div>
    </div>

</div>

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
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            initializeVendorLocationMap();
        });

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
                scrollWheelZoom: false, // Disable scroll wheel zoom for better UX
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

            // Show popup by default
            marker.openPopup();

            // Force map to recalculate size
            setTimeout(() => {
                map.invalidateSize();
            }, 100);

            // Add click handler to enable scroll zoom when clicked
            map.on('click', function() {
                map.scrollWheelZoom.enable();
                // Show a brief notification
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
