<style>
    .active-plan {
        outline: 2px solid #D9D9D9;
        border-radius: 0.5rem;
        padding: 0.5rem 1.5rem;
    }

    .active-plan h2 {
        color: #E9BF80 !important;
    }

    .plan-option h2 {
        color: #FAFAFA;
        transition: color 0.2s;
    }
</style>
<x-layouts.app>
    <div class="min-h-screen bg-gradient-to-b from-[#011C19] to-[#284123] text-white">
        <div class="judul">
            <h1 class= "text-6xl font-bold text-center text-[#D9D9D9] p-4 font-Kuunari">
                PILIH PAKET LANGGANANMU
            </h1>
        </div>
        <div class="paket flex justify-center items-center gap-36 mt-10">
            <!-- Paket Basic -->
            <div class="paket1 plan-option" data-plan="basic">
                <h2 class="text-5xl font-bold text-center text-[#FAFAFA] p-4 font-Kuunari">
                    BASIC PLAN
                </h2>
                <!-- Paket Standard -->
            </div>
            <div class="paket2 plan-option" data-plan="standard">
                <h2 class="text-5xl font-bold text-center text-[#E9BF80] p-4 font-Kuunari">
                    STANDARD PLAN
                </h2>
                <!-- Paket Pro -->
            </div>
            <div class="paket3 plan-option" data-plan="pro">
                <h2 class="text-5xl font-bold text-center text-[#FAFAFA] p-4 font-Kuunari">
                    PRO PLAN
                </h2>
            </div>
        </div>
        <!-- line -->
        <div class="garis w-full h-[2px] bg-[#FAFAFA] mt-6"></div>
        <!-- card -->
        <div class="w-full flex items-center justify-center mt-10">
            <!-- harga card -->
            <div
                class="kotak bg-white rounded-2xl shadow-lg px-10 py-6 flex items-center justify-center space-x-8 w-full max-w-xl h-[250px]">
                <div class="harga">
                    <h1 class = "text-9xl font-bold font-Kuunari text-[#284123]">
                        99K
                    </h1>
                </div>
                <!-- Deskripsi Harga -->
                <div class="deskripsi ml-6">
                    <h2 class="text-[#011C19] text-5xl font-bold font-poppins">3 Bulan</h2>
                    <p class="text-[#011C19] text-lg font-poppins">
                        Fitur Booking Otomatis <br />
                        Halaman Profil Digital
                </div>
            </div>
        </div>
        <!-- Button -->
        <div class="button flex justify-end mt-6 px-6">
            <button class="bg-[#06261E] text-white font-bold font-Kuunari text-lg  px-10 py-2 rounded-sm ">
                PEMBAYARAN
            </button>
        </div>

        <!-- card struk -->
        <!-- Overlay hitam transparan -->
        <div class="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50">
            <!-- Card struk -->
            <div class="bg-white rounded-2xl shadow-xl w-[95%] max-w-md p-6">
                <!-- Pembelian Paket -->
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-[#011C19] font-Kuunari">PEMBELIAN PAKET</h2>
                    <p class="text-sm text-[#011C19] font-poppins mt-1">Segera Lakukan Pembayaran</p>
                </div>

                <!-- Plan & Durasi -->
                <div class="flex justify-center gap-4 mt-5">
                    <div class="bg-[#13331B] text-[#E9BF80] font-bold text-base px-4 py-2 rounded-md font-Kuunari">
                        BASIC PLAN
                    </div>
                    <div class="bg-[#13331B] text-[#E9BF80] font-bold text-base px-4 py-2 rounded-md font-Kuunari">
                        6 BULAN
                    </div>
                </div>

                <!-- VA Info -->
                <div class="text-center mt-4 font-poppins text-[#011C19] text-sm">
                    <p>No. BCA Virtual Account:</p>
                    <p class="font-bold text-base">1902085887306306</p>
                    <p>a.n Seecut</p>
                </div>

                <!-- Detail Pemesanan -->
                <div class="mt-6 text-sm text-[#011C19] font-poppins">
                    <h3 class="font-semibold text-base mb-2">Detail Pemesanan</h3>
                    <div class="flex justify-between">
                        <span>Harga Paket</span>
                        <span class="font-semibold">179.000</span>
                    </div>
                    <div class="flex justify-between mt-1">
                        <span>Diskon</span>
                        <span>0</span>
                    </div>
                </div>

                <!-- Total -->
                <div
                    class="border-y border-[#B59776] py-2 mt-4 flex justify-between text-sm text-[#011C19] font-poppins font-semibold">
                    <span>TOTAL</span>
                    <span>179.000</span>
                </div>

                <!-- Deadline Transfer -->
                <div class="text-center mt-4 font-poppins text-sm text-[#011C19]">
                    <p class="font-semibold">Transfer Sebelum</p>
                    <p>Pukul 11.30 WIB</p>
                    <p>Selasa, 27 Mei 2025</p>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.querySelectorAll('.plan-option').forEach(option => {
            option.addEventListener('click', () => {
                // Hapus class active dari semua plan
                document.querySelectorAll('.plan-option').forEach(el => {
                    el.classList.remove('active-plan');
                });

                // Tambahkan class active ke yang diklik
                option.classList.add('active-plan');

                // Ambil nilai data-plan dan update harga
                const selectedPlan = option.getAttribute('data-plan');
                updateHarga(selectedPlan);
            });
        });

        function updateHarga(plan) {
            const harga = document.querySelector('.harga h1');
            const deskripsi = document.querySelector('.deskripsi');

            if (plan === 'basic') {
                harga.textContent = '99K';
                deskripsi.innerHTML = `
                <h2 class="text-[#011C19] text-5xl font-bold font-poppins">3 Bulan</h2>
                <p class="text-[#011C19] text-lg font-poppins">
                    Fitur Booking Otomatis <br />
                    Halaman Profil Digital
                </p>
            `;
            } else if (plan === 'standard') {
                harga.textContent = '179K';
                deskripsi.innerHTML = `
                <h2 class="text-[#011C19] text-5xl font-bold font-poppins">6 Bulan</h2>
                <p class="text-[#011C19] text-lg font-poppins">
                    Fitur Booking Otomatis <br />
                    Halaman Profil Digital
                </p>
            `;
            } else if (plan === 'pro') {
                harga.textContent = '299K';
                deskripsi.innerHTML = `
                <h2 class="text-[#011C19] text-5xl font-bold font-poppins">12 Bulan</h2>
                <p class="text-[#011C19] text-lg font-poppins">
                    Fitur Booking Otomatis <br />
                    Halaman Profil Digital
                </p>
            `;
            }
        }
    </script>

</x-layouts.app>
