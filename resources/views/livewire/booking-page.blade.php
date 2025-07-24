<div class="relative min-h-screen">
    <!-- Background Image -->
    <div class="absolute inset-0 z-0 bg-center bg-contain bg-no-repeat opacity-10"
        style="background-image: url('{{ asset('assets/images/wave.png') }}');">
    </div>

    <div class="relative flex flex-col px-6 md:px-16 lg:px-48">
        {{-- Back Button --}}
        <div class="py-10 md:py-12">
            <button onclick="window.history.back()"
                class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-Ecru hover:bg-Seasalt transition-all duration-300 flex items-center justify-center shadow">
                <svg width="14" height="28" viewBox="0 0 14 28" fill="none" xmlns="http://www.w3.org/2000/svg"
                    class="w-4 md:w-6 h-6 text-gray-700">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M2.15016 13.1704L8.74999 6.57059L10.3997 8.22026L4.62466 13.9953L10.3997 19.7703L8.74999 21.4199L2.15016 14.8201C1.93144 14.6013 1.80857 14.3046 1.80857 13.9953C1.80857 13.6859 1.93144 13.3892 2.15016 13.1704Z"
                        fill="#6B592E" />
                </svg>
            </button>
        </div>
        <div class="flex flex-col md:flex-row justify-between items-stretch gap-y-8">
            {{-- Left --}}
            <div class="flex flex-col basis-full md:basis-[50%] flex-shrink-0">
                <div class="mb-6">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl uppercase font-Kuunari text-Ecru mb-3">pilih slot
                    </h1>
                    <form id="bookingForm" class="space-y-4">
                        {{-- Date Selection --}}
                        <div class="block text-xl font-Poppins font-medium mb-3">
                            <label class="text-Seasalt">Pilih Tanggal
                                <span class="text-Seasalt/20">- Juli 2025 <span class="text-red-500">*</span></span>
                            </label>
                        </div>
                        <div id="date-selection" class="flex items-center gap-4 overflow-x-auto pb-2 font-Poppins">
                            <div data-date="2025-07-24"
                                class="date-slot text-center p-3 border rounded-lg cursor-pointer flex-shrink-0 w-16 bg-Satin-Sheen-Yellow border-Satin-Sheen-Yellow text-Seasalt">
                                <p class="font-light uppercase text-sm">kam</p>
                                <p class="font-bold text-xl">24</p>
                            </div>
                            <div data-date="2025-07-25"
                                class="date-slot text-center p-3 border rounded-lg cursor-pointer flex-shrink-0 w-16 bg-transparent border-Satin-Sheen-Yellow text-Seasalt hover:bg-Satin-Sheen-Yellow">
                                <p class="font-light uppercase text-sm">jum</p>
                                <p class="font-bold text-xl">25</p>
                            </div>
                            <div data-date="2025-07-26"
                                class="date-slot text-center p-3 border rounded-lg cursor-pointer flex-shrink-0 w-16 bg-transparent border-Satin-Sheen-Yellow text-Seasalt hover:bg-Satin-Sheen-Yellow">
                                <p class="font-light uppercase text-sm">sab</p>
                                <p class="font-bold text-xl">26</p>
                            </div>
                            <div data-date="2025-07-27"
                                class="date-slot text-center p-3 border rounded-lg cursor-not-allowed flex-shrink-0 w-16 bg-transparent border-Seasalt/5 text-Seasalt/50">
                                <p class="font-light uppercase text-sm">min</p>
                                <p class="font-bold text-xl">27</p>
                            </div>
                            <div data-date="2025-07-28"
                                class="date-slot text-center p-3 border rounded-lg cursor-pointer flex-shrink-0 w-16 bg-transparent border-Satin-Sheen-Yellow text-Seasalt hover:bg-Satin-Sheen-Yellow">
                                <p class="font-light uppercase text-sm">sen</p>
                                <p class="font-bold text-xl">28</p>
                            </div>
                            <div data-date="2025-07-29"
                                class="date-slot text-center p-3 border rounded-lg cursor-pointer flex-shrink-0 w-16 bg-transparent border-Satin-Sheen-Yellow text-Seasalt hover:bg-Satin-Sheen-Yellow">
                                <p class="font-light uppercase text-sm">sel</p>
                                <p class="font-bold text-xl">29</p>
                            </div>
                            <div data-date="2025-07-30"
                                class="date-slot text-center p-3 border rounded-lg cursor-pointer flex-shrink-0 w-16 bg-transparent border-Satin-Sheen-Yellow text-Seasalt hover:bg-Satin-Sheen-Yellow">
                                <p class="font-light uppercase text-sm">rab</p>
                                <p class="font-bold text-xl">30</p>
                            </div>
                        </div>
                        {{-- Time Selection --}}
                        <div class="block text-xl font-Poppins font-medium mb-3">
                            <label class="text-Seasalt">Pilih Waktu<span class="text-red-500">*</span></label>
                        </div>
                        <div class="font-Poppins font-medium text-Seasalt">
                            <div id="time-selection" class="grid grid-cols-3 sm:grid-cols-4 gap-3 text-sm">
                                <div data-time="08.00 - 09.00"
                                    class="time-slot active-slot text-center p-3 border rounded-lg cursor-pointer border-Satin-Sheen-Yellow bg-Satin-Sheen-Yellow">
                                    08.00 - 09.00</div>
                                <div data-time="10.00 - 11.00"
                                    class="time-slot text-center p-3 border rounded-lg cursor-pointer border-Satin-Sheen-Yellow bg-transparent hover:bg-Satin-Sheen-Yellow">
                                    10.00 - 11.00</div>
                                <div data-time="11.00 - 12.00"
                                    class="time-slot text-center p-3 border rounded-lg cursor-not-allowed border-Seasalt/5 bg-transparent text-Seasalt/50">
                                    11.00 - 12.00</div>
                                <div data-time="12.00 - 13.00"
                                    class="time-slot text-center p-3 border rounded-lg cursor-pointer border-Satin-Sheen-Yellow bg-transparent hover:bg-Satin-Sheen-Yellow">
                                    12.00 - 13.00</div>
                                <div data-time="14.00 - 15.00"
                                    class="time-slot text-center p-3 border rounded-lg cursor-pointer border-Satin-Sheen-Yellow bg-transparent hover:bg-Satin-Sheen-Yellow">
                                    14.00 - 15.00</div>
                                <div data-time="16.00 - 17.00"
                                    class="time-slot text-center p-3 border rounded-lg cursor-pointer border-Satin-Sheen-Yellow bg-transparent hover:bg-Satin-Sheen-Yellow">
                                    16.00 - 17.00</div>
                                <div data-time="17.00 - 18.00"
                                    class="time-slot text-center p-3 border rounded-lg cursor-pointer border-Satin-Sheen-Yellow bg-transparent hover:bg-Satin-Sheen-Yellow">
                                    17.00 - 18.00</div>
                                <div data-time="19.00 - 20.00"
                                    class="time-slot text-center p-3 border rounded-lg cursor-pointer border-Satin-Sheen-Yellow bg-transparent hover:bg-Satin-Sheen-Yellow">
                                    19.00 - 20.00</div>
                                <div data-time="21.00 - 22.00"
                                    class="time-slot text-center p-3 border rounded-lg cursor-pointer border-Satin-Sheen-Yellow bg-transparent hover:bg-Satin-Sheen-Yellow">
                                    21.00 - 22.00</div>
                            </div>
                        </div>
                        {{-- Layanan Section --}}
                        <div class="block text-xl font-Poppins font-medium mb-3">
                            <label class="text-Seasalt">Layanan</label>
                        </div>
                        <div>
                            <div class="relative">
                                <select id="service" name="service"
                                    class="custom-input appearance-none w-full p-4 pl-12 rounded-lg focus:outline-none focus:ring-2 focus:ring-Satin-Sheen-Yellow bg-Eerie-Black">
                                    <option value="" disabled selected>Pilih layanan yang anda inginkan
                                    </option>
                                    <option value="Haircut Premium">Haircut Premium</option>
                                    <option value="Haircut & Shave">Haircut & Shave</option>
                                    <option value="Hair Coloring">Hair Coloring</option>
                                </select>
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 7.5l.415-.207a.75.75 0 011.085.67V10.5m0 0h6m-6 0v-1.5m0 1.5v3.375m6-3.375h-6m6 0v-1.5m0 1.5v3.375m0 0l-.415.207a.75.75 0 01-1.085-.67V13.5m11.25-8.25h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 21h15a2.25 2.25 0 002.25-2.25V7.5A2.25 2.25 0 0019.5 5.25z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        {{-- Name Pelanggan --}}
                        <div class="block text-xl font-Poppins font-medium mb-3">
                            <label class="text-Seasalt">Nama Pelanggan</label>
                        </div>
                        <div>
                            <div class="relative">
                                <input type="text" id="name" name="name" placeholder="Masukkan nama anda"
                                    class="custom-input w-full p-4 pl-12 rounded-lg focus:outline-none focus:ring-2 focus:ring-Satin-Sheen-Yellow bg-Eerie-Black">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        {{-- Nomor Handphone --}}
                        <div class="block text-xl font-Poppins font-medium mb-3">
                            <label class="text-Seasalt">Phone Number</label>
                        </div>
                        <div>
                            <div class="relative">
                                <input type="tel" id="phone" name="phone"
                                    class="custom-input w-full p-4 pl-12 rounded-lg focus:outline-none focus:ring-2 focus:ring-Satin-Sheen-Yellow bg-Eerie-Black"
                                    placeholder="Masukkan nomor handphone anda">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 6.75z">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        {{-- Email --}}
                        <div class="block text-xl font-Poppins font-medium mb-3">
                            <label class="text-Seasalt">Email</label>
                        </div>
                        <div>
                            <div class="relative">
                                <input type="email" id="email" name="email"
                                    placeholder="Masukkan email anda"
                                    class="custom-input w-full p-4 pl-12 rounded-lg focus:outline-none focus:ring-2 focus:ring-Satin-Sheen-Yellow bg-Eerie-Black">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75">
                                        </path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{-- Line --}}
            <div class="hidden md:flex gap-[2px] mx-8 md:mx-16">
                <div class="w-[1px] bg-Ecru"></div>
                <div class="w-[1px] bg-Ecru"></div>
            </div>
            {{-- Right --}}
            <div class= "flex flex-col basis-full md:basis-[50%] flex-shrink-0">
                <div class="mb-6 space-y-4">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl uppercase font-Kuunari text-Ecru mb-3">detail
                        reservasi</h1>
                    <div class="border border-Ecru rounded-lg p-6 space-y-4 text-base">
                        <div class="flex justify-between font-Poppins font-medium text-xl">
                            <span class="text-Seasalt/40">Tanggal</span>
                            <span id="detail-date" class="text-Seasalt">-</span>
                        </div>
                        <div class="flex justify-between font-Poppins font-medium text-xl">
                            <span class="text-Seasalt/40">Waktu</span>
                            <span id="detail-time" class="text-Seasalt">-</span>
                        </div>
                        <div class="flex justify-between font-Poppins font-medium text-xl">
                            <span class="text-Seasalt/40">Layanan</span>
                            <span id="detail-service" class="text-Seasalt">-</span>
                        </div>
                        <hr class="border-Field-Drab my-4">
                        <div class="flex justify-between font-Poppins font-medium text-xl">
                            <span class="text-Seasalt/40">Nama</span>
                            <span id="detail-name" class="text-Seasalt">-</span>
                        </div>
                        <div class="flex justify-between font-Poppins font-medium text-xl">
                            <span class="text-Seasalt/40">No. Handphone</span>
                            <span id="detail-phone" class="text-Seasalt">-</span>
                        </div>
                        <div class="flex justify-between font-Poppins font-medium text-xl">
                            <span class="text-Seasalt/40">Email</span>
                            <span id="detail-email" class="text-Seasalt">-</span>
                        </div>
                    </div>
                    <button type="submit" form="bookingForm"
                        class="w-full mt-6 bg-Ecru text-Taupe font-bold text-lg py-3 rounded-lg hover:bg-Dun transition-colors uppercase">reservasi
                        sekarang</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateSelection = document.getElementById('date-selection');
            const timeSelection = document.getElementById('time-selection');

            const detailDate = document.getElementById('detail-date');
            const detailTime = document.getElementById('detail-time');
            const detailService = document.getElementById('detail-service');
            const detailName = document.getElementById('detail-name');
            const detailPhone = document.getElementById('detail-phone');
            const detailEmail = document.getElementById('detail-email');

            const serviceInput = document.getElementById('service');
            const nameInput = document.getElementById('name');
            const phoneInput = document.getElementById('phone');
            const emailInput = document.getElementById('email');

            function updateDetails() {
                // Update Tanggal
                const selectedDateEl = dateSelection.querySelector('.bg-Satin-Sheen-Yellow');
                if (selectedDateEl) {
                    const date = new Date(selectedDateEl.dataset.date);
                    detailDate.textContent = date.toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: 'long',
                        year: 'numeric'
                    });
                } else {
                    detailDate.textContent = '-';
                }

                // Update Waktu
                const selectedTimeEl = timeSelection.querySelector('.bg-Satin-Sheen-Yellow');
                detailTime.textContent = selectedTimeEl ? selectedTimeEl.dataset.time : '-';

                // Update dari Input Form
                detailService.textContent = serviceInput.value ? serviceInput.value : '-';
                detailName.textContent = nameInput.value ? nameInput.value : '-';
                detailPhone.textContent = phoneInput.value ? phoneInput.value : '-';
                detailEmail.textContent = emailInput.value ? emailInput.value : '-';
            }

            if (dateSelection) {
                dateSelection.addEventListener('click', function(e) {
                    const target = e.target.closest('.date-slot');
                    if (!target || target.classList.contains('text-Seasalt/50')) return;

                    dateSelection.querySelectorAll('.date-slot').forEach(slot => {
                        if (!slot.classList.contains('text-Seasalt/50')) {
                            slot.classList.remove('bg-Satin-Sheen-Yellow', 'text-Eerie-Black');
                            slot.classList.add('bg-transparent', 'text-Seasalt');
                        }
                    });

                    target.classList.add('bg-Satin-Sheen-Yellow', 'text-Eerie-Black');
                    target.classList.remove('bg-transparent', 'text-Seasalt');

                    updateDetails();
                });
            }

            if (timeSelection) {
                timeSelection.addEventListener('click', function(e) {
                    const target = e.target.closest('.time-slot');
                    if (!target || target.classList.contains('text-Seasalt/50')) return;

                    timeSelection.querySelectorAll('.time-slot').forEach(slot => {
                        if (!slot.classList.contains('text-Seasalt/50')) {
                            slot.classList.remove('bg-Satin-Sheen-Yellow', 'text-Eerie-Black');
                            slot.classList.add('bg-transparent', 'text-Seasalt');
                        }
                    });

                    target.classList.add('bg-Satin-Sheen-Yellow', 'text-Eerie-Black');
                    target.classList.remove('bg-transparent', 'text-Seasalt');

                    updateDetails();
                });
            }

            serviceInput.addEventListener('change', updateDetails);
            nameInput.addEventListener('input', updateDetails);
            phoneInput.addEventListener('input', updateDetails);
            emailInput.addEventListener('input', updateDetails);

            updateDetails();
        });
    </script>
@endpush
