<div class="flex flex-col gap-6">
    <h2 class="text-2xl font-bold font-Poppins text-[#284123]">Hairstylist</h2>

    <div class="flex flex-col gap-8">
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-bold font-Poppins mb-4 text-[#284123]">Tambah Hairstylist Baru</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2 flex flex-col gap-4">
                    <div>
                        <label for="new_hairstylist_name" class="mb-1 text-black font-Poppins">Nama Hairstylist</label>
                        <input type="text" wire:model.live="new_hairstylist_name" id="new_hairstylist_name"
                            class="w-full h-10 bg-[#284123] text-white outline-none pl-4 pr-4 rounded-md border-none focus:ring-2 focus:ring-green-200"
                            placeholder="Nama hairstylist">
                        @error('new_hairstylist_name')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="new_hairstylist_description" class="mb-1 text-black font-Poppins">Deskripsi</label>
                        <textarea wire:model="new_hairstylist_description" id="new_hairstylist_description" rows="3"
                            class="w-full text-sm text-white rounded-lg border border-[#284123] bg-[#284123] focus:outline-none focus:ring-2 focus:ring-green-200 focus:text-white p-3"
                            placeholder="Deskripsi singkat tentang hairstylist..."></textarea>
                        @error('new_hairstylist_description')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="flex flex-col items-center gap-4 w-32">
                    <label for="new_hairstylist_image" class="mb-1 text-black font-Poppins text-center">Foto
                        Hairstylist</label>

                    <!-- Photo Preview -->
                    <div class="mb-4 w-32 h-40">
                        @if ($new_hairstylist_image)
                            <img src="{{ $new_hairstylist_image->temporaryUrl() }}" alt="Preview"
                                class="w-32 h-40 rounded-lg object-cover border-2 border-[#284123] shadow">
                        @else
                            @php
                                $initials = '';
                                if (!empty($new_hairstylist_name)) {
                                    $initials = collect(explode(' ', $new_hairstylist_name))
                                        ->filter()
                                        ->map(fn($word) => mb_substr($word, 0, 1))
                                        ->join('');
                                }
                            @endphp
                            <div
                                class="w-32 h-40 rounded-lg flex items-center justify-center shadow border-2 border-[#284123] bg-[#3d4a2f]">
                                <span class="text-3xl font-bold text-white font-Poppins select-none">
                                    {{ $initials }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Upload Button -->
                    <input type="file" id="new_hairstylist_image" wire:model="new_hairstylist_image" accept="image/*"
                        class="hidden" wire:key="hairstylist-image-{{ $hairstylistImageKey }}">
                    <button type="button" onclick="document.getElementById('new_hairstylist_image').click();"
                        class="bg-[#284123] text-white py-2 px-4 rounded-lg hover:bg-green-700 transition w-full">
                        Pilih Foto
                    </button>

                    @error('new_hairstylist_image')
                        <span class="text-red-500 text-xs text-center">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="mt-6">
                <button type="button" wire:click="addHairstylist"
                    class="bg-[#284123] text-white py-2 px-6 rounded-lg hover:bg-green-700 transition">
                    Tambah Hairstylist
                </button>
            </div>
        </div>

        @if (count($hairstylists) > 0)
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-bold font-Poppins mb-4 text-[#284123]">Daftar Hairstylist</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($hairstylists as $stylist)
                        <div
                            class="flex items-center gap-4 bg-[#f7fafc] border border-[#e2e8f0] shadow-sm rounded-lg px-4 py-3 transition hover:shadow-md">
                            @if ($stylist['image_path'])
                                <img src="{{ asset('storage/' . $stylist['image_path']) }}"
                                    alt="Foto {{ $stylist['name'] }}"
                                    class="w-16 h-20 rounded-lg object-cover border-2 border-[#284123] flex-shrink-0">
                            @else
                                @php
                                    $initials = collect(explode(' ', $stylist['name'] ?? ''))
                                        ->filter()
                                        ->map(fn($word) => mb_substr($word, 0, 1))
                                        ->join('');
                                @endphp
                                <div
                                    class="w-16 h-20 rounded-lg bg-[#3d4a2f] flex items-center justify-center border-2 border-[#284123] flex-shrink-0">
                                    <span class="text-lg font-bold text-white font-Poppins select-none">
                                        {{ $initials }}
                                    </span>
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                <div class="font-semibold text-[#284123] text-base truncate">
                                    {{ $stylist['name'] }}
                                </div>
                                <div class="text-sm text-gray-700 line-clamp-2">
                                    {{ $stylist['description'] }}
                                </div>
                            </div>
                            <button type="button" wire:click="removeHairstylist({{ $stylist['id'] }})"
                                class="p-2 rounded-md hover:bg-red-100 transition group flex-shrink-0" title="Hapus">
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
