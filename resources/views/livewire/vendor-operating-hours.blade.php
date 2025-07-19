@push('styles')
    <style>
        input[type="time"]::-webkit-calendar-picker-indicator {
            filter: invert(1) brightness(2);
            opacity: 1;
        }

        input[type="time"] {
            color: #fff;
        }
    </style>
@endpush

<div class="flex flex-col gap-6">
    <h2 class="text-2xl font-bold font-Poppins text-[#284123]">Jam Operasional</h2>

    <form wire:submit.prevent="save" class="flex flex-col gap-8">
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-bold font-Poppins mb-4 text-[#284123]">Jam Operasional Mingguan</h3>
            <div class="grid grid-cols-1 gap-4">
                @foreach ($days as $day)
                    <div class="flex items-center gap-4">
                        <span class="w-24 font-semibold text-gray-700">{{ $day }}</span>
                        <input type="time" wire:model="open_hours.{{ $day }}.open_time"
                            class="bg-[#284123] text-white rounded px-3 py-2 focus:ring-2 focus:ring-green-200" />
                        <span class="text-gray-500">-</span>
                        <input type="time" wire:model="open_hours.{{ $day }}.close_time"
                            class="bg-[#284123] text-white rounded px-3 py-2 focus:ring-2 focus:ring-green-200" />
                        <span class="text-xs text-gray-400">
                            @if (empty($open_hours[$day]['open_time']) && empty($open_hours[$day]['close_time']))
                                (Tutup)
                            @endif
                        </span>
                    </div>
                @endforeach
            </div>
            <div class="mt-6 text-sm text-gray-600">
                <p><strong>Catatan:</strong> Kosongkan kedua field untuk hari libur</p>
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
