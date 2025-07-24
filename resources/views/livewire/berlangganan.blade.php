<div class="flex h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <aside class="w-64 bg-slate-800 text-white flex flex-col shadow-xl">
        <div class="p-6 border-b border-gray-600">
            <div class="flex items-center">
                <img src="{{ asset('assets/ld/logo-text.png') }}" alt="SeeCut Logo" class="h-12">
            </div>
        </div>

        <nav class="flex-1 p-4">
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center font-Kuunari text-lg p-3 {{ request()->routeIs('dashboard') ? 'bg-white text-slate-800' : 'hover:bg-white hover:text-slate-800' }} rounded-lg font-semibold transition-all duration-300 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        DASBOR
                    </a>
                </li>
                <li>
                    <a href="{{ route('berlangganan') }}"
                        class="flex items-center font-Kuunari text-lg p-3 bg-white text-slate-800 rounded-lg font-semibold transition-all duration-300 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        BERLANGGANAN
                    </a>
                </li>
            </ul>
        </nav>

        <div class="p-4 border-t border-gray-600">
            <div class="flex items-center mb-4">
                <div
                    class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                    <span class="text-white font-bold text-sm">MR</span>
                </div>
                <div>
                    <p class="text-sm font-semibold text-white">Matthew Raditya</p>
                    <p class="text-xs text-gray-400">Administrator</p>
                </div>
            </div>
            <a href="#"
                class="flex items-center p-3 hover:bg-red-600 hover:text-white rounded-lg font-semibold transition-all duration-300 text-red-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                KELUAR
            </a>
        </div>
    </aside>

    <main class="flex-1 overflow-y-auto bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="p-8">
            <!-- Admin Header -->
            <header class="flex justify-between items-center mb-10 animate-fade-in">
                <div>
                    <h1 class="text-4xl font-extrabold text-gray-900 tracking-wide font-Kuunari mb-2">
                        MANAJEMEN LANGGANAN
                    </h1>
                    <p class="text-gray-600 text-lg">
                        Kelola semua langganan barbershop
                    </p>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Search -->
                    <div class="relative">
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari langganan..."
                            class="pl-10 pr-4 py-2 bg-gray-800 text-white border border-gray-600 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all w-64 placeholder-gray-400">
                        <svg class="absolute left-3 top-2.5 w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>
            </header>

            <!-- Flash Messages -->
            @if (session()->has('message'))
                <div id="flash-message"
                    class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative flex items-center justify-between transition-all duration-300 ease-in-out"
                    role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="block sm:inline font-medium">{{ session('message') }}</span>
                    </div>
                    <button type="button" onclick="dismissFlashMessage()"
                        class="text-green-700 hover:text-green-900 ml-4 transition-colors duration-200 cursor-pointer p-1 rounded-full hover:bg-green-200">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endif

            @if (session()->has('error'))
                <div id="error-message"
                    class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative flex items-center justify-between transition-all duration-300 ease-in-out"
                    role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="block sm:inline font-medium">{{ session('error') }}</span>
                    </div>
                    <button type="button" onclick="dismissErrorMessage()"
                        class="text-red-700 hover:text-red-900 ml-4 transition-colors duration-200 cursor-pointer p-1 rounded-full hover:bg-red-200">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            @endif

            @if (count($subscriptions) == 0)
                <div class="bg-white rounded-2xl shadow-sm p-12 text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada langganan ditemukan</h3>
                    <p class="text-gray-500">
                        @if ($search)
                            Tidak ada hasil untuk pencarian "{{ $search }}". Coba kata kunci lain.
                        @else
                            Belum ada data langganan yang tersedia.
                        @endif
                    </p>
                </div>
            @else
                <!-- Subscription Management Table -->
                <div
                    class="bg-white rounded-2xl shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden">
                    <table class="w-full">
                        <!-- Header -->
                        <thead>
                            <tr class="bg-slate-800">
                                <th class="p-4 text-center w-[12%] text-white font-bold text-sm">Logo</th>
                                <th class="p-4 text-center w-[6%] text-white font-bold text-sm">ID</th>
                                <th class="p-4 text-center w-[14%] text-white font-bold text-sm">Nama</th>
                                <th class="p-4 text-center w-[16%] text-white font-bold text-sm">Email</th>
                                <th class="p-4 text-center w-[18%] text-white font-bold text-sm">Alamat</th>
                                <th class="p-4 text-center w-[12%] text-white font-bold text-sm">Jam Operasional</th>
                                <th class="p-4 text-center w-[10%] text-white font-bold text-sm">Paket</th>
                                <th class="p-4 text-center w-[6%] text-white font-bold text-sm">Aksi</th>
                            </tr>
                        </thead>

                        <!-- Data Rows -->
                        <tbody>
                            @foreach ($subscriptions as $sub)
                                <tr class="bg-white hover:bg-gray-50 transition-all duration-300 group cursor-pointer"
                                    wire:click="showVendorDetails({{ $sub['vendor_id'] }})">
                                    <td class="p-4 align-middle">
                                        <div class="flex justify-center">
                                            <div class="relative w-12 h-12 bg-gray-100 rounded-lg overflow-hidden">
                                                <img src="{{ $sub['logo'] }}" alt="Logo"
                                                    class="w-full h-full object-cover shadow-sm ring-2 ring-gray-100 group-hover:ring-gray-200 transition-all duration-300"
                                                    onerror="this.src='{{ asset('assets/ld/logo-text.png') }}'">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 text-center align-middle">
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800">
                                            #{{ $sub['id'] }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-center align-middle">
                                        <div class="font-bold text-slate-900 text-sm">{{ $sub['name'] }}</div>
                                    </td>
                                    <td class="p-4 text-center align-middle">
                                        <a href="mailto:{{ $sub['email'] }}" onclick="event.stopPropagation()"
                                            class="text-blue-600 hover:text-blue-800 font-medium text-sm underline decoration-2 underline-offset-2 hover:decoration-blue-800 transition-all duration-200">
                                            {{ $sub['email'] }}
                                        </a>
                                    </td>
                                    <td class="p-4 text-center align-middle">
                                        <div class="text-slate-700 font-medium text-sm leading-relaxed text-left max-w-[200px] mx-auto overflow-hidden"
                                            style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                            {{ $sub['alamat'] }}
                                        </div>
                                    </td>
                                    <td class="p-4 text-center align-middle">
                                        <div
                                            class="inline-flex items-center px-3 py-1.5 rounded-lg bg-gray-100 text-gray-800 text-sm font-semibold">
                                            {{ $sub['jam'] }}
                                        </div>
                                    </td>
                                    <td class="p-4 text-center align-middle">
                                        <span
                                            class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-sm font-bold bg-green-100 text-green-800 shadow-sm hover:shadow-md hover:scale-105 transition-all duration-200 min-w-[100px] w-[100px]">
                                            {{ $sub['paket'] }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-center align-middle">
                                        <button onclick="event.stopPropagation(); showDeleteConfirmation('{{ $sub['id'] }}', '{{ $sub['name'] }}')"
                                            class="group/btn relative inline-flex items-center justify-center p-2.5 text-red-500 hover:text-white bg-red-50 hover:bg-red-500 rounded-xl transition-all duration-300 hover:shadow-lg hover:scale-110">
                                            <svg class="h-5 w-5 transition-transform duration-300 group-hover/btn:scale-110"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            <div
                                                class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover/btn:opacity-100 transition-opacity duration-200">
                                                Hapus
                                            </div>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </main>

    <!-- Vendor Detail Modal -->
    @if ($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50 p-4"
            wire:click="closeModal">
            <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto" wire:click.stop>
                >
                <!-- Modal Header -->
                <div class="flex justify-between items-center p-6 border-b border-gray-200">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Detail Vendor</h2>
                        <p class="text-gray-600 text-sm mt-1">Informasi lengkap vendor barbershop</p>
                    </div>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <!-- Vendor Info Header -->
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0">
                            <img src="{{ $selectedVendor['thumbnail_url'] ?? asset('assets/ld/logo-text.png') }}"
                                alt="Logo" class="w-20 h-20 object-cover shadow-lg ring-4 ring-gray-100"
                                onerror="this.src='{{ asset('assets/ld/logo-text.png') }}'">
                        </div>
                        <div class="ml-6">
                            <h3 class="text-xl font-bold text-gray-900">{{ $selectedVendor['name'] ?? 'N/A' }}</h3>
                            <p class="text-gray-600 mt-1">{{ $selectedVendor['email'] ?? 'N/A' }}</p>
                            <div class="flex items-center mt-2">
                                <div class="flex items-center">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= ($selectedVendor['rating'] ?? 0) ? 'text-yellow-400' : 'text-gray-300' }}"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                    <span
                                        class="ml-2 text-sm text-gray-600">({{ $selectedVendor['reviews_count'] ?? 0 }}
                                        ulasan)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Vendor Details -->
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Contact Info -->
                        <div class="bg-gray-50 rounded-xl p-4">
                            <h4 class="font-semibold text-gray-900 mb-3">Informasi Kontak</h4>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 text-gray-500 mr-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <span class="text-gray-700">{{ $selectedVendor['phone'] ?? 'N/A' }}</span>
                                </div>
                                <div class="flex items-start">
                                    <svg class="w-4 h-4 text-gray-500 mr-3 mt-0.5" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <span class="text-gray-700">{{ $selectedVendor['address'] ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Subscription Info -->
                        @if (isset($selectedVendor['subscription']) && $selectedVendor['subscription'])
                            <div class="bg-blue-50 rounded-xl p-4">
                                <h4 class="font-semibold text-gray-900 mb-3">Informasi Berlangganan</h4>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-sm text-gray-600">Paket</p>
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            {{ $selectedVendor['subscription']['plan'] ?? 'N/A' }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Status</p>
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                    {{ ($selectedVendor['subscription']['status'] ?? 'inactive') === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($selectedVendor['subscription']['status'] ?? 'inactive') }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Mulai</p>
                                        <p class="font-medium">
                                            {{ $selectedVendor['subscription']['start_date'] ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-600">Berakhir</p>
                                        <p class="font-medium">
                                            {{ $selectedVendor['subscription']['end_date'] ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-span-2">
                                        <p class="text-sm text-gray-600">Harga</p>
                                        <p class="font-bold text-lg text-green-600">Rp
                                            {{ number_format($selectedVendor['subscription']['price'] ?? 0, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Description -->
                        <div class="bg-gray-50 rounded-xl p-4">
                            <h4 class="font-semibold text-gray-900 mb-3">Deskripsi</h4>
                            <p class="text-gray-700">{{ $selectedVendor['description'] ?? 'Tidak ada deskripsi' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-end p-6 border-t border-gray-200">
                    <button wire:click="closeModal"
                        class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors duration-200">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-60 opacity-0 invisible transition-all duration-300">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform scale-95 transition-transform duration-300" id="deleteModalContent">
            <div class="p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Konfirmasi Hapus</h3>
                <p class="text-gray-600 mb-6" id="deleteConfirmText">Apakah Anda yakin ingin menghapus langganan ini?</p>
                <div class="flex space-x-3 justify-center">
                    <button onclick="cancelDelete()" class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-semibold transition-colors duration-200">
                        Batal
                    </button>
                    <button onclick="confirmDelete()" class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold transition-colors duration-200">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Global variables for delete confirmation
    let pendingDeleteId = null;
    let pendingDeleteName = null;

    // Delete confirmation functions
    function showDeleteConfirmation(id, name) {
        pendingDeleteId = id;
        pendingDeleteName = name;
        
        const modal = document.getElementById('deleteModal');
        const modalContent = document.getElementById('deleteModalContent');
        const confirmText = document.getElementById('deleteConfirmText');
        
        confirmText.textContent = `Apakah Anda yakin ingin menghapus langganan ${name}?`;
        
        modal.classList.remove('opacity-0', 'invisible');
        modal.classList.add('opacity-100', 'visible');
        
        setTimeout(() => {
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
        }, 10);
    }
    
    function cancelDelete() {
        const modal = document.getElementById('deleteModal');
        const modalContent = document.getElementById('deleteModalContent');
        
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.remove('opacity-100', 'visible');
            modal.classList.add('opacity-0', 'invisible');
        }, 200);
        
        pendingDeleteId = null;
        pendingDeleteName = null;
    }
    
    function confirmDelete() {
        if (pendingDeleteId) {
            // Call Livewire method to delete
            @this.call('deleteSubscription', pendingDeleteId);
            
            // Close modal
            cancelDelete();
        }
    }

    // Close modal when clicking outside
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            cancelDelete();
        }
    });

    // Flash message functions
    function dismissFlashMessage() {
        const flashMessage = document.getElementById('flash-message');
        if (flashMessage) {
            flashMessage.style.opacity = '0';
            flashMessage.style.transform = 'translateY(-10px)';
            setTimeout(function() {
                flashMessage.remove();
            }, 300);
        }
    }

    function dismissErrorMessage() {
        const errorMessage = document.getElementById('error-message');
        if (errorMessage) {
            errorMessage.style.opacity = '0';
            errorMessage.style.transform = 'translateY(-10px)';
            setTimeout(function() {
                errorMessage.remove();
            }, 300);
        }
    }

    // Auto dismiss flash messages
    document.addEventListener('DOMContentLoaded', function() {
        // Auto dismiss success message after 3 seconds
        if (document.getElementById('flash-message')) {
            setTimeout(function() {
                dismissFlashMessage();
            }, 3000);
        }

        // Auto dismiss error message after 5 seconds
        if (document.getElementById('error-message')) {
            setTimeout(function() {
                dismissErrorMessage();
            }, 5000);
        }
    });
</script>
