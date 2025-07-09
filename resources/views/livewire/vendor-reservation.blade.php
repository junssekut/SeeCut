<div class="p-0 bg-[#222]">
    <div class="bg-white shadow-lg mx-auto min-h-screen">
        <div class="px-48 flex items-center py-4 bg-gray-100 border border-gray-300">
            <div class="flex space-x-2">
                <button wire:click="setStatus('all')"
                    class="px-4 py-1 rounded-full {{ $status == 'all' ? 'bg-[#495b3c] text-white' : 'bg-gray-200' }}">Semua</button>
                <button wire:click="setStatus('masuk')"
                    class="px-4 py-1 rounded-full {{ $status == 'masuk' ? 'bg-[#495b3c] text-white' : 'bg-gray-200' }}">Masuk</button>
                <button wire:click="setStatus('proses')"
                    class="px-4 py-1 rounded-full {{ $status == 'proses' ? 'bg-[#495b3c] text-white' : 'bg-gray-200' }}">Proses</button>
                <button wire:click="setStatus('selesai')"
                    class="px-4 py-1 rounded-full {{ $status == 'selesai' ? 'bg-[#495b3c] text-white' : 'bg-gray-200' }}">Selesai</button>
                <button wire:click="setStatus('batal')"
                    class="px-4 py-1 rounded-full {{ $status == 'batal' ? 'bg-[#495b3c] text-white' : 'bg-gray-200' }}">Batal</button>
            </div>
            <div class="ml-auto">
                <input wire:model.debounce.500ms="search" type="text" placeholder="Cari"
                    class="rounded-full px-4 py-1 bg-gray-200">
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-center">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Jam</th>
                        <th class="px-4 py-2">Nama</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">No. Telepon</th>
                        <th class="px-4 py-2">Pemesanan</th>
                        <th class="px-4 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $reservation)
                        <tr class="{{ $loop->even ? 'bg-gray-100' : 'bg-white' }} hover:bg-[#f5f5e9] transition-colors">
                            <td class="px-4 py-2">{{ $reservation->slot?->date }}</td>
                            <td class="px-4 py-2">{{ $reservation->slot?->start_time }}</td>
                            <td class="px-4 py-2">{{ $reservation->name }}</td>
                            <td class="px-4 py-2">{{ $reservation->email }}</td>
                            <td class="px-4 py-2">{{ $reservation->phone }}</td>
                            <td class="px-4 py-2">{{ $reservation->note ?? '-' }}</td>
                            <td class="px-4 py-2">
                                <select wire:model="reservations.{{ $reservation->id }}.status"
                                    class="rounded-full bg-gray-200 px-4 py-1">
                                    <option value="confirmed">Masuk</option>
                                    <option value="pending">Proses</option>
                                    <option value="finished">Selesai</option>
                                    <option value="cancelled">Batal</option>
                                </select>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-gray-400">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $reservations->links() }}
        </div>
    </div>
</div>
