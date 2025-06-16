<div
    class="relative z-20 bg-Eerie-Black p-6 md:p-8 md:py-6 rounded-lg shadow-lg font-sans w-full border-t-8 border-t-Ecru">
    <div class="grid grid-cols-4 gap-6 items-end">

        <div class="space-y-2">
            <label for="lokasi"
                class="block text-xl font-medium font-Kuunari text-Seasalt uppercase tracking-wider">LOKASI</label>
            <select wire:model.live="lokasi" id="lokasi" name="lokasi"
                class="block w-full bg-Charcoal border-none text-Dark-Charcoal placeholder-Dark-Charcoal rounded-md shadow-sm py-3 px-4 focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                @foreach ($lokasiOptions as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        {{-- <div class="bg-Ecru w-[2px] h-full text-transparent">none</div> --}}

        {{-- Layanan Input --}}
        <div class="space-y-2">
            <label for="layanan"
                class="block text-xl font-medium font-Kuunari text-Seasalt uppercase tracking-wider">LAYANAN</label>
            <select wire:model.live="layanan" id="layanan" name="layanan"
                class="block w-full bg-Charcoal border-none text-Dark-Charcoal placeholder-Dark-Charcoal rounded-md shadow-sm py-3 px-4 focus:outline-none focus:ring-amber-500 focus:border-amber-500 sm:text-sm">
                @foreach ($layananOptions as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>

        {{-- Harga Input --}}
        <div class="space-y-2 md:col-span-1">
            <label for="harga"
                class="block text-xl font-medium font-Kuunari text-Seasalt uppercase tracking-wider">HARGA</label>
            <div class="flex flex-col items-center">
                <input wire:model.live="harga" id="harga" name="harga" type="range" min="0"
                    max="{{ $maxHarga }}" step="10000"
                    class="w-full h-2 bg-neutral-700 rounded-lg appearance-none cursor-pointer accent-amber-500">
                <span class="mt-2 text-sm text-Seasalt">
                    Rp {{ number_format($harga, 0, ',', '.') }} - Rp {{ number_format($maxHarga, 0, ',', '.') }}
                </span>
            </div>
        </div>

        {{-- Search Button --}}
        <div class="md:col-span-1 flex items-end">
            <button wire:click="search" type="button"
                class="text-lg w-full bg-Ecru hover:bg-Dun text-Dark-Charcoal-2 font-Kuunari font-semibold py-3 px-6 rounded-md shadow-sm transition duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-neutral-800 focus:ring-amber-400">
                CARI BARBERSHOP
            </button>
        </div>
    </div>

    {{-- Optional: Display selected values for debugging --}}
    {{--
    <div class="mt-6 p-4 bg-neutral-700 rounded text-white text-xs">
        <p>Debug:</p>
        <p>Lokasi: {{ $lokasi ?: 'Tidak dipilih' }}</p>
        <p>Layanan: {{ $layanan ?: 'Tidak dipilih' }}</p>
        <p>Harga Maksimal: Rp {{ number_format($harga, 0, ',', '.') }}</p>
    </div>
    --}}
</div>
