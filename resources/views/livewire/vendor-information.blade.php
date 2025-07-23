@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        #vendor-map.leaflet-container {
            border-radius: 1rem;
            box-shadow: 0 4px 24px 0 rgba(44, 62, 80, 0.10);
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        let vendorMap = null;
        let vendorMarker = null;

        function initializeMap() {
            // If map already exists, remove it first
            if (vendorMap) {
                vendorMap.remove();
                vendorMap = null;
                vendorMarker = null;
            }

            // Wait for the DOM element to be available
            const mapElement = document.getElementById('vendor-map');
            if (!mapElement) {
                console.log('Map element not found, retrying...');
                setTimeout(initializeMap, 100);
                return;
            }

            let lat = @json($latitude ?? -6.2);
            let lng = @json($longitude ?? 106.816666);

            vendorMap = L.map('vendor-map', {
                zoomControl: false
            }).setView([lat, lng], 15);

            L.control.zoom({
                position: 'topright'
            }).addTo(vendorMap);

            // Force map to recalculate size
            setTimeout(() => {
                vendorMap.invalidateSize();
            }, 100);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(vendorMap);

            L.control.scale().addTo(vendorMap);

            vendorMarker = L.marker([lat, lng], {
                draggable: true
            }).addTo(vendorMap);

            vendorMarker.bindPopup(
                `<div style='min-width:180px;'>` +
                `<div class='font-bold text-base mb-1'>${@json($name ?? '')}</div>` +
                `<div class='text-xs text-gray-700 mb-1'>${@json($address ?? '')}</div>` +
                `<div class='text-xs text-gray-500'>Lat: ${lat.toFixed(6)}<br>Lng: ${lng.toFixed(6)}</div>` +
                `</div>`
            ).openPopup();

            // On marker drag, update Livewire coordinates
            vendorMarker.on('dragend', function(e) {
                const {
                    lat,
                    lng
                } = vendorMarker.getLatLng();
                @this.set('latitude', lat);
                @this.set('longitude', lng);
                vendorMarker.setPopupContent(
                    `<div style='min-width:180px;'>` +
                    `<div class='font-bold text-base mb-1'>${@json($name ?? '')}</div>` +
                    `<div class='text-xs text-gray-700 mb-1'>${@json($address ?? '')}</div>` +
                    `<div class='text-xs text-gray-500'>Lat: ${lat.toFixed(6)}<br>Lng: ${lng.toFixed(6)}</div>` +
                    `</div>`
                );
                vendorMarker.openPopup();
            });

            // Setup geolocate button
            setupGeolocateButton();
        }

        function setupGeolocateButton() {
            const locateBtn = document.getElementById('locate-btn');
            if (locateBtn) {
                locateBtn.onclick = function() {
                    if (navigator.geolocation) {
                        locateBtn.disabled = true;
                        locateBtn.innerText = 'Mencari lokasi...';
                        navigator.geolocation.getCurrentPosition(function(position) {
                            const userLat = position.coords.latitude;
                            const userLng = position.coords.longitude;
                            vendorMap.setView([userLat, userLng], 16);
                            vendorMarker.setLatLng([userLat, userLng]);
                            vendorMarker.setPopupContent(
                                `<div style='min-width:180px;'>` +
                                `<div class='font-bold text-base mb-1'>${@json($name ?? '')}</div>` +
                                `<div class='text-xs text-gray-700 mb-1'>${@json($address ?? '')}</div>` +
                                `<div class='text-xs text-gray-500'>Lat: ${userLat.toFixed(6)}<br>Lng: ${userLng.toFixed(6)}</div>` +
                                `</div>`
                            );
                            vendorMarker.openPopup();
                            @this.set('latitude', userLat);
                            @this.set('longitude', userLng);
                            locateBtn.innerText = 'Gunakan Lokasi Saya';
                            locateBtn.disabled = false;
                        }, function() {
                            alert('Tidak dapat mengambil lokasi.');
                            locateBtn.innerText = 'Gunakan Lokasi Saya';
                            locateBtn.disabled = false;
                        });
                    }
                };
            }
        }

        // Initialize map on page load
        document.addEventListener('livewire:navigated', initializeMap);

        // Re-initialize map when section changes to information
        document.addEventListener('livewire:init', () => {
            Livewire.on('section-changed', (event) => {
                if (event.section === 'information') {
                    // Wait a bit for the DOM to update
                    setTimeout(initializeMap, 200);
                }
            });
        });

        // Also initialize when this specific component loads
        document.addEventListener('DOMContentLoaded', () => {
            // Check if we're on the information section
            if (document.getElementById('vendor-map')) {
                initializeMap();
            }
        });

        // Listen for Livewire component updates
        document.addEventListener('livewire:update', (event) => {
            // Check if the updated component contains our map
            if (event.detail.component.name === 'vendor-information' || document.getElementById('vendor-map')) {
                setTimeout(initializeMap, 100);
            }
        });

        // Also handle when the component is rendered
        document.addEventListener('livewire:load', () => {
            if (document.getElementById('vendor-map')) {
                initializeMap();
            }
        });
    </script>
@endpush

<div class="flex flex-col gap-6">
    <h2 class="text-2xl font-bold font-Poppins text-[#284123]">Informasi Barbershop</h2>

    <form wire:submit.prevent="save" class="flex flex-col gap-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Left: Upload Photo -->
            <div class="flex flex-col items-center justify-start">
                <h3 class="text-lg font-bold font-Poppins mb-6 text-gray-800">Upload Foto</h3>
                <div class="mb-8">
                    @if ($logo)
                        <img src="{{ $logo->temporaryUrl() }}" alt="logo"
                            class="mx-auto w-44 h-44 rounded-full shadow-lg object-cover border-4 border-[#284123]">
                    @elseif ($currentLogoPath)
                        <img src="{{ asset('storage/' . $currentLogoPath) }}" alt="logo"
                            class="mx-auto w-44 h-44 rounded-full shadow-lg object-cover border-4 border-[#284123]">
                    @else
                        @php
                            $initials = collect(explode(' ', $name ?? ''))
                                ->filter()
                                ->map(fn($word) => mb_substr($word, 0, 1))
                                ->join('');
                        @endphp
                        <div
                            class="mx-auto w-44 h-44 rounded-full flex items-center justify-center shadow-lg border-4 border-[#284123] bg-[#3d4a2f]">
                            <span
                                class="text-6xl font-bold text-white font-Poppins select-none">{{ $initials }}</span>
                        </div>
                    @endif
                </div>
                <input type="file" id="fileInput" wire:model="logo" class="hidden" accept="image/*">
                <button type="button" onclick="document.getElementById('fileInput').click();"
                    class="bg-[#284123] text-xl font-Kuunari text-white py-2 px-6 rounded-lg hover:bg-green-600 focus:outline-none mb-4 transition">
                    UNGGAH FOTO
                </button>
                @error('logo')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>

            <!-- Right: Form Fields -->
            <div class="md:col-span-2">
                <div class="bg-white rounded-xl shadow p-6">
                    <div class="flex flex-col gap-6">
                        <div>
                            <label for="nama" class="font-Poppins text-black">Nama Barbershop</label>
                            <div class="relative mt-1">
                                <input type="text" wire:model="name" name="nama" id="nama"
                                    class="w-full h-10 bg-[#284123] text-white outline-none pl-4 pr-10 rounded-md focus:ring-2 focus:ring-green-200">
                                <svg class="w-6 h-6 absolute right-3 top-1/2 transform -translate-y-1/2 text-white opacity-70"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                    </path>
                                </svg>
                            </div>
                            @error('name')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="alamat" class="font-Poppins text-black">Alamat</label>
                            <div class="relative mt-1">
                                <input type="text" wire:model="address" name="alamat" id="alamat"
                                    class="w-full h-10 bg-[#284123] text-white outline-none pl-4 pr-10 rounded-md focus:ring-2 focus:ring-green-200">
                                <svg class="w-6 h-6 absolute right-3 top-1/2 transform -translate-y-1/2 text-white opacity-70"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                    </path>
                                </svg>
                            </div>
                            @error('address')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label for="description" class="font-Poppins text-black">Deskripsi</label>
                            <textarea wire:model="description" id="description" rows="4"
                                class="block w-full text-sm text-white rounded-lg border border-[#284123] bg-[#284123] focus:outline-none focus:ring-2 focus:ring-green-200 focus:text-white p-4 mt-1"
                                placeholder="Masukkan deskripsi barbershop..."></textarea>
                            @error('description')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <label class="font-Poppins text-black mb-2 block">Pin Lokasi Barbershop</label>
                            <div class="rounded-lg overflow-hidden border border-[#284123] shadow-lg"
                                style="height: 300px;" wire:key="vendor-map-container">
                                <div id="vendor-map" wire:ignore style="height: 100%; width: 100%;"></div>
                            </div>
                            <button type="button" id="locate-btn"
                                class="mt-2 px-4 py-2 bg-[#284123] text-white rounded shadow hover:bg-green-700 transition">Gunakan
                                Lokasi Saya</button>
                            <input type="hidden" wire:model="latitude">
                            <input type="hidden" wire:model="longitude">
                            @error('latitude')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                            @error('longitude')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-4 mt-8">
            <button type="button" onclick="window.history.back()"
                class="bg-gray-500 text-white py-2 px-6 rounded-lg hover:bg-gray-600 focus:outline-none">
                Batal
            </button>
            <button type="submit"
                class="bg-[#011C19] text-white py-2 px-6 rounded-lg hover:bg-[#284123] focus:outline-none">
                Simpan
            </button>
        </div>
    </form>
</div>
