@section('title', 'Vendor - Profile')

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Check if URL has section parameter, if not add default
            const urlParams = new URLSearchParams(window.location.search);
            if (!urlParams.has('section')) {
                const newUrl = new URL(window.location);
                newUrl.searchParams.set('section', 'information');
                window.history.replaceState({}, '', newUrl);
            }
        });
    </script>
@endpush

<div class="w-full min-h-screen bg-gray-50 flex items-start justify-center py-12">
    <div class="w-[90%] max-w-7xl grid grid-cols-12 gap-8 bg-white rounded-2xl shadow-lg p-8">
        <!-- Left Sidebar Navigation -->
        <div class="col-span-12 md:col-span-3 border-r border-gray-200 pr-6">
            <h2 class="text-xl font-bold font-Poppins mb-6 text-[#284123]">Pengaturan Profile</h2>
            <nav class="space-y-2">
                <button wire:click="setActiveSection('information')"
                    class="w-full text-left px-4 py-3 rounded-lg transition {{ $activeSection === 'information' ? 'bg-[#284123] text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium">Informasi</span>
                    </div>
                </button>

                <button wire:click="setActiveSection('operating-hours')"
                    class="w-full text-left px-4 py-3 rounded-lg transition {{ $activeSection === 'operating-hours' ? 'bg-[#284123] text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="font-medium">Jam Operasional</span>
                    </div>
                </button>

                <button wire:click="setActiveSection('services')"
                    class="w-full text-left px-4 py-3 rounded-lg transition {{ $activeSection === 'services' ? 'bg-[#284123] text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                        <span class="font-medium">Layanan</span>
                    </div>
                </button>

                <button wire:click="setActiveSection('hairstylists')"
                    class="w-full text-left px-4 py-3 rounded-lg transition {{ $activeSection === 'hairstylists' ? 'bg-[#284123] text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        <span class="font-medium">Hairstylist</span>
                    </div>
                </button>
            </nav>
        </div>

        <!-- Right Content Area -->
        <div class="col-span-12 md:col-span-9">
            @if ($activeSection === 'information')
                @livewire('vendor-information', 'vendor-information-' . $activeSection)
            @elseif($activeSection === 'operating-hours')
                @livewire('vendor-operating-hours', 'vendor-operating-hours-' . $activeSection)
            @elseif($activeSection === 'services')
                @livewire('vendor-services', 'vendor-services-' . $activeSection)
            @elseif($activeSection === 'hairstylists')
                @livewire('vendor-hairstylists', 'vendor-hairstylists-' . $activeSection)
            @endif
        </div>
    </div>
</div>
