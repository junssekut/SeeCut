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
                                <th class="p-4 text-center w-[8%] text-white font-bold text-sm">Logo</th>
                                <th class="p-4 text-center w-[6%] text-white font-bold text-sm">ID</th>
                                <th class="p-4 text-center w-[15%] text-white font-bold text-sm">Nama</th>
                                <th class="p-4 text-center w-[18%] text-white font-bold text-sm">Email</th>
                                <th class="p-4 text-center w-[20%] text-white font-bold text-sm">Alamat</th>
                                <th class="p-4 text-center w-[13%] text-white font-bold text-sm">Jam Operasional</th>
                                <th class="p-4 text-center w-[10%] text-white font-bold text-sm">Paket</th>
                                <th class="p-4 text-center w-[6%] text-white font-bold text-sm">Aksi</th>
                            </tr>
                        </thead>

                        <!-- Data Rows -->
                        <tbody>
                            @foreach ($subscriptions as $sub)
                                <tr class="bg-white hover:bg-gray-50 transition-all duration-300 group">
                                    <td class="p-4 align-middle">
                                        <div class="flex justify-center">
                                            <div class="relative">
                                                <img src="{{ $sub['logo'] }}" alt="Logo"
                                                    class="w-12 h-12 object-cover rounded-xl shadow-sm ring-2 ring-gray-100 group-hover:ring-gray-200 transition-all duration-300">
                                                <div
                                                    class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 rounded-full border-2 border-white">
                                                </div>
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
                                        <a href="mailto:{{ $sub['email'] }}"
                                            class="text-blue-600 hover:text-blue-800 font-medium text-sm underline decoration-2 underline-offset-2 hover:decoration-blue-800 transition-all duration-200">
                                            {{ $sub['email'] }}
                                        </a>
                                    </td>
                                    <td class="p-4 text-center align-middle">
                                        <div class="relative group">
                                            <div class="text-slate-700 font-medium text-sm leading-relaxed text-left max-w-[200px] mx-auto overflow-hidden cursor-help"
                                                style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"
                                                title="{{ $sub['alamat'] }}">
                                                {{ $sub['alamat'] }}
                                            </div>
                                            <!-- Tooltip on hover -->
                                            <div
                                                class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 px-3 py-2 bg-gray-800 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none z-10 max-w-xs">
                                                {{ $sub['alamat'] }}
                                                <div
                                                    class="absolute top-full left-1/2 transform -translate-x-1/2 border-4 border-transparent border-t-gray-800">
                                                </div>
                                            </div>
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
                                        <button wire:click="deleteSubscription('{{ $sub['id'] }}')"
                                            wire:confirm="Apakah Anda yakin ingin menghapus langganan {{ $sub['name'] }}?"
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
</div>

<script>
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
