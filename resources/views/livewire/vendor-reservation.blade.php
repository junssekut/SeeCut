<div class="p-0 bg-[#222]">
    <div class="bg-white shadow-lg mx-auto min-h-screen">
        <div class="px-48 flex items-center py-4 bg-gray-100 border border-gray-300">
            <div class="flex space-x-2">
                <button wire:click="setStatus('all')"
                    class="px-4 py-1 rounded-full {{ $status == 'all' ? 'bg-Dark-Muted-Olive text-Seasalt' : 'bg-gray-200' }}">Semua</button>
                <button wire:click="setStatus('masuk')"
                    class="px-4 py-1 rounded-full {{ $status == 'masuk' ? 'bg-Dark-Muted-Olive text-Seasalt' : 'bg-gray-200' }}">Masuk</button>
                <button wire:click="setStatus('proses')"
                    class="px-4 py-1 rounded-full {{ $status == 'proses' ? 'bg-Dark-Muted-Olive text-Seasalt' : 'bg-gray-200' }}">Proses</button>
                <button wire:click="setStatus('selesai')"
                    class="px-4 py-1 rounded-full {{ $status == 'selesai' ? 'bg-Dark-Muted-Olive text-Seasalt' : 'bg-gray-200' }}">Selesai</button>
                <button wire:click="setStatus('batal')"
                    class="px-4 py-1 rounded-full {{ $status == 'batal' ? 'bg-Dark-Muted-Olive text-Seasalt' : 'bg-gray-200' }}">Batal</button>
            </div>
            <div class="ml-auto">
                <input wire:model.debounce.500ms="search" type="text" placeholder="Cari"
                    class="rounded-full px-4 py-1 bg-gray-200">
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-center">
                <thead>
                    <tr class="bg-gray-200 text-lg">
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Jam</th>
                        <th class="px-4 py-2">Nama</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">No. Telepon</th>
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
                            <td class="px-4 py-2">
                                <select wire:change="updateStatus({{ $reservation->id }}, $event.target.value)"
                                    class="rounded-lg px-10 py-1 focus:ring-0 outline-none text-center cursor-pointer border
                                    @if ($reservation->status == 'confirmed') focus:border-gray-500 border-gray-500 text-gray-500 bg-gray-500/10
                                    @elseif($reservation->status == 'pending') focus:border-Satin-Sheen-Yellow border-Satin-Sheen-Yellow text-Satin-Sheen-Yellow bg-Satin-Sheen-Yellow/10
                                    @elseif($reservation->status == 'finished') focus:border-Dark-Olive border-Dark-Olive text-Dark-Olive bg-Dark-Olive/10
                                    @elseif($reservation->status == 'cancelled') focus:border-red-500 border-red-500 text-red-500 bg-red-500/10
                                    @else border-gray-200 text-gray-700 @endif">
                                    <option value="confirmed"
                                        {{ $reservation->status === 'confirmed' ? 'selected' : '' }}>Masuk</option>
                                    <option value="pending" {{ $reservation->status === 'pending' ? 'selected' : '' }}>
                                        Proses</option>
                                    <option value="finished"
                                        {{ $reservation->status === 'finished' ? 'selected' : '' }}>Selesai</option>
                                    <option value="cancelled"
                                        {{ $reservation->status === 'cancelled' ? 'selected' : '' }}>Batal</option>
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
