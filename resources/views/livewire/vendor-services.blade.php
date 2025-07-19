<div class="flex flex-col gap-6">
    <h2 class="text-2xl font-bold font-Poppins text-[#284123]">Layanan</h2>

    <div class="flex flex-col gap-8">
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-bold font-Poppins mb-4 text-[#284123]">Tambah Layanan Baru</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="new_service_name" class="mb-1 text-black font-Poppins">Nama Layanan</label>
                    <input type="text" wire:model="new_service_name" id="new_service_name"
                        class="w-full h-10 bg-[#284123] text-white outline-none pl-4 pr-4 rounded-md border-none focus:ring-2 focus:ring-green-200"
                        placeholder="Nama layanan">
                    @error('new_service_name')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label for="new_service_price" class="mb-1 text-black font-Poppins">Harga</label>
                    <input type="number" wire:model="new_service_price" id="new_service_price"
                        class="w-full h-10 bg-[#284123] text-white outline-none pl-4 pr-4 rounded-md border-none focus:ring-2 focus:ring-green-200"
                        placeholder="100000">
                    @error('new_service_price')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="mt-4">
                <button type="button" wire:click="addService"
                    class="bg-[#284123] text-white py-2 px-6 rounded-lg hover:bg-green-700 transition">
                    Tambah Layanan
                </button>
            </div>
        </div>

        @if (count($services) > 0)
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-bold font-Poppins mb-4 text-[#284123]">Layanan yang Tersedia</h3>
                <div class="grid grid-cols-1 gap-3">
                    @foreach ($services as $service)
                        <div
                            class="flex items-center gap-3 bg-[#f7fafc] border border-[#e2e8f0] shadow-sm rounded-md px-5 py-3 transition hover:shadow-md">
                            <span
                                class="font-semibold text-[#284123] text-base flex-1">{{ $service['service_name'] }}</span>
                            <span class="font-bold text-[#284123] text-sm bg-[#e6f4ea] rounded px-3 py-1">
                                {{ 'Rp' . number_format($service['price'], 0, ',', '.') }}
                            </span>
                            <button type="button" wire:click="removeService({{ $service['id'] }})"
                                class="ml-2 p-2 rounded-md hover:bg-red-100 transition group" title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-5 w-5 text-red-500 group-hover:text-red-700" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4a1 1 0 011 1v2H9V4a1 1 0 011-1zm-7 4h18" />
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
