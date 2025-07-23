<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Manajemen Reservasi</h1>
            <p class="text-gray-600">Kelola semua reservasi pelanggan Anda</p>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-center animate-fade-in">
                <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="text-green-800 font-medium">{{ session('message') }}</span>
            </div>
        @endif

        <!-- Filter and Search Section -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6 border border-gray-200">
            <div class="flex flex-col lg:flex-row justify-between items-center gap-4">
                <!-- Filter Buttons -->
                <div class="flex flex-wrap gap-2">
                    <button wire:click="setStatus('all')"
                        class="px-6 py-2 rounded-full font-medium transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500
                        {{ $status == 'all' ? 'bg-gradient-to-r from-green-600 to-green-700 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            Semua
                        </span>
                    </button>
                    <button wire:click="setStatus('masuk')"
                        class="px-6 py-2 rounded-full font-medium transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500
                        {{ $status == 'masuk' ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Masuk
                        </span>
                    </button>
                    <button wire:click="setStatus('proses')"
                        class="px-6 py-2 rounded-full font-medium transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500
                        {{ $status == 'proses' ? 'bg-gradient-to-r from-yellow-500 to-yellow-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Proses
                        </span>
                    </button>
                    <button wire:click="setStatus('selesai')"
                        class="px-6 py-2 rounded-full font-medium transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500
                        {{ $status == 'selesai' ? 'bg-gradient-to-r from-green-600 to-green-700 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Selesai
                        </span>
                    </button>
                    <button wire:click="setStatus('batal')"
                        class="px-6 py-2 rounded-full font-medium transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500
                        {{ $status == 'batal' ? 'bg-gradient-to-r from-red-600 to-red-700 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Batal
                        </span>
                    </button>
                </div>

                <!-- Search Input -->
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input wire:model.live.debounce.500ms="search" type="text"
                        placeholder="Cari berdasarkan nama, email, atau telepon..."
                        class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg w-80 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200">
                </div>
            </div>
        </div>
        <!-- Table Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 table-container relative"
            wire:loading.class="opacity-75">
            <!-- Loading Overlay -->
            <div wire:loading wire:target="setStatus,search"
                class="absolute inset-0 bg-white bg-opacity-90 flex items-center justify-center z-10 rounded-xl">
                <div class="flex items-center space-x-2">
                    <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-green-600"></div>
                    <span class="text-gray-600 font-medium">Memuat data...</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full"">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span>Tanggal</span>
                                </div>
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Jam</span>
                                </div>
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                    <span>Nama</span>
                                </div>
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    <span>Email</span>
                                </div>
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                        </path>
                                    </svg>
                                    <span>No. Telepon</span>
                                </div>
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Status</span>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($reservations as $reservation)
                            <tr class="hover:bg-gray-50 transition-all duration-200 group"
                                wire:key="reservation-{{ $reservation->id }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ \Carbon\Carbon::parse($reservation->slot?->date)->format('d M Y') }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($reservation->slot?->date)->format('l') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ \Carbon\Carbon::parse($reservation->slot?->start_time)->format('H:i') }}
                                            </div>
                                            <div class="text-sm text-gray-500">WIB</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                            <span class="text-purple-600 font-medium text-sm">
                                                {{ substr($reservation->name, 0, 1) }}
                                            </span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $reservation->name }}
                                            </div>
                                            <div class="text-sm text-gray-500">Pelanggan</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $reservation->email }}</div>
                                    <div class="text-sm text-gray-500">
                                        {{ strlen($reservation->email) > 25 ? substr($reservation->email, 0, 25) . '...' : $reservation->email }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $reservation->phone }}</div>
                                    <div class="text-sm text-gray-500">Telepon</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <select wire:change="updateStatus({{ $reservation->id }}, $event.target.value)"
                                        class="rounded-lg px-4 py-2 text-sm font-medium transition-all duration-200 focus:ring-2 focus:ring-offset-2 focus:outline-none cursor-pointer border-2 hover:shadow-md
                                        @if ($reservation->status == 'confirmed') bg-blue-50 border-blue-200 text-blue-700 hover:bg-blue-100 focus:ring-blue-500
                                        @elseif($reservation->status == 'pending') 
                                            bg-yellow-50 border-yellow-200 text-yellow-700 hover:bg-yellow-100 focus:ring-yellow-500
                                        @elseif($reservation->status == 'finished') 
                                            bg-green-50 border-green-200 text-green-700 hover:bg-green-100 focus:ring-green-500
                                        @elseif($reservation->status == 'cancelled') 
                                            bg-red-50 border-red-200 text-red-700 hover:bg-red-100 focus:ring-red-500
                                        @else 
                                            bg-gray-50 border-gray-200 text-gray-700 hover:bg-gray-100 focus:ring-gray-500 @endif">
                                        <option value="confirmed"
                                            {{ $reservation->status === 'confirmed' ? 'selected' : '' }}>
                                            ✓ Masuk
                                        </option>
                                        <option value="pending"
                                            {{ $reservation->status === 'pending' ? 'selected' : '' }}>
                                            ⏳ Proses
                                        </option>
                                        <option value="finished"
                                            {{ $reservation->status === 'finished' ? 'selected' : '' }}>
                                            ✅ Selesai
                                        </option>
                                        <option value="cancelled"
                                            {{ $reservation->status === 'cancelled' ? 'selected' : '' }}>
                                            ❌ Batal
                                        </option>
                                    </select>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-12 h-12 text-gray-400 mb-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                        <p class="text-gray-500 text-lg font-medium">Tidak ada reservasi ditemukan</p>
                                        <p class="text-gray-400 text-sm mt-1">Coba ubah filter atau kata kunci
                                            pencarian</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if ($reservations->hasPages())
            <div class="mt-6 flex items-center justify-between">
                <div class="flex-1 flex justify-between sm:hidden">
                    @if ($reservations->onFirstPage())
                        <span
                            class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                            Previous
                        </span>
                    @else
                        <a href="{{ $reservations->previousPageUrl() }}"
                            class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            Previous
                        </a>
                    @endif

                    @if ($reservations->hasMorePages())
                        <a href="{{ $reservations->nextPageUrl() }}"
                            class="ml-3 relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                            Next
                        </a>
                    @else
                        <span
                            class="ml-3 relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">
                            Next
                        </span>
                    @endif
                </div>

                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700">
                            Showing
                            <span class="font-medium">{{ $reservations->firstItem() }}</span>
                            to
                            <span class="font-medium">{{ $reservations->lastItem() }}</span>
                            of
                            <span class="font-medium">{{ $reservations->total() }}</span>
                            results
                        </p>
                    </div>
                    <div>
                        {{ $reservations->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@push('styles')
    <style>
        /* Custom animation for filter switching */
        .filter-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Loading animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }

        /* Hover effects for table rows */
        .group:hover .group-hover\:scale-105 {
            transform: scale(1.05);
        }

        /* Status badge animations */
        select:focus {
            transform: scale(1.02);
        }

        /* Filter button pulse animation (kept for buttons) */
        .filter-active {
            animation: filterPulse 0.5s ease-out;
        }

        @keyframes filterPulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Prevent layout shift during updates */
        [wire\:loading] {
            transition: opacity 0.2s ease-in-out;
        }

        /* Smooth table updates */
        .table-container {
            min-height: 400px;
            transition: all 0.3s ease;
        }

        /* Prevent input flickering */
        input[wire\:model] {
            transition: none !important;
        }

        /* Stable table layout */
        table {
            table-layout: fixed;
        }

        /* Table rows base styles - GSAP will handle animations */
        tbody tr {
            transform-origin: center;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Keep original functionality for status selects
        document.addEventListener('change', function(event) {
            if (event.target.matches('select[wire\\:change^="updateStatus"]')) {
                const select = event.target;
                const originalBg = select.style.backgroundColor;
                select.style.backgroundColor = '#f3f4f6';
                select.style.pointerEvents = 'none';

                // Add loading spinner
                const spinner = document.createElement('div');
                spinner.className = 'absolute inset-0 flex items-center justify-center';
                spinner.innerHTML =
                    '<div class="animate-spin h-4 w-4 border-2 border-gray-300 border-t-gray-600 rounded-full"></div>';

                const wrapper = document.createElement('div');
                wrapper.className = 'relative inline-block';
                select.parentNode.insertBefore(wrapper, select);
                wrapper.appendChild(select);
                wrapper.appendChild(spinner);

                // Remove loading state after a short delay
                setTimeout(() => {
                    select.style.backgroundColor = originalBg;
                    select.style.pointerEvents = 'auto';
                    spinner.remove();
                }, 800);
            }
        });

        // Filter button animations
        document.addEventListener('click', function(event) {
            if (event.target.closest('button[wire\\:click^="setStatus"]')) {
                const button = event.target.closest('button');
                button.classList.add('filter-active');
                setTimeout(() => {
                    button.classList.remove('filter-active');
                }, 500);
            }
        });

        // Search input focus effects
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.querySelector('input[wire\\:model*="search"]');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    // Disable transitions during typing
                    this.style.transition = 'none';
                    setTimeout(() => {
                        this.style.transition = '';
                    }, 100);
                });
            }
        });
    </script>
@endpush
