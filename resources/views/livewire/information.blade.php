<div class="flex">
    <div id="unggahFoto" class="w-[30%] h-screen">
        <div class="flex justify-center pt-32 h-screen">
            <div class="text-center">
                <!-- Logo -->
                <div class="mb-8">
                    <!-- Menampilkan gambar yang disimpan dari localStorage jika ada -->
                    <img id="logoPreview" src="{{ asset('images/logo.png') }}" alt="logo"
                        class="mx-auto w-44 h-44 rounded-full">
                </div>

                <!-- Tombol Unggah Foto -->
                <button onclick="document.getElementById('fileInput').click();"
                    class="bg-[#284123] text-xl font-Kuunari text-white py-2 px-6 rounded-lg hover:bg-green-600 focus:outline-none mb-4">
                    Unggah Foto
                </button>

                <!-- Input file yang disembunyikan -->
                <input type="file" id="fileInput" class="hidden" accept="image/*" onchange="previewImage(event)">
            </div>
        </div>
    </div>

    {{-- form --}}
    <div class="w-[35%] h-screen mt-24">
        <form action="" method="POST" class="flex flex-col" onsubmit="return validateForm(event)">
            {{-- nama barber --}}
            <div class="w-auto h-6 ml-8">
                <label for="nama" class="font-Poppins text-black">Nama Barbershop</label>
                <div class="relative">
                    <input type="text" name="nama" id="nama"
                        class="w-[85%] h-9 bg-[#284123] outline-none pl-4 pr-4 rounded-md focus:border-none focus:outline-none focus:ring-0">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6 absolute right-20 top-1/2 transform -translate-y-1/2"
                        viewBox="0 0 283.5 283.500005" preserveAspectRatio="xMidYMid meet" version="1.2">
                        <defs>
                            <clipPath id="a5354d1d33">
                                <path
                                    d="M 123 227 L 221.636719 227 L 221.636719 236.472656 L 123 236.472656 Z M 123 227 " />
                            </clipPath>
                            <clipPath id="0daac9dfbb">
                                <path
                                    d="M 61.398438 46.285156 L 205 46.285156 L 205 235 L 61.398438 235 Z M 61.398438 46.285156 " />
                            </clipPath>
                        </defs>
                        <g id="6026f3be9d">
                            <g clip-rule="nonzero" clip-path="url(#a5354d1d33)">
                                <path style="stroke:none;fill-rule:nonzero;fill:#FFFFFF;fill-opacity:1;"
                                    d="M 217.039062 227.359375 L 128.179688 227.359375 C 125.660156 227.359375 123.617188 229.398438 123.617188 231.914062 C 123.617188 234.425781 125.660156 236.464844 128.179688 236.464844 L 217.039062 236.464844 C 219.554688 236.464844 221.597656 234.425781 221.597656 231.914062 C 221.597656 229.398438 219.554688 227.359375 217.039062 227.359375 Z M 217.039062 227.359375 " />
                            </g>
                            <g clip-rule="nonzero" clip-path="url(#0daac9dfbb)">
                                <path style="stroke:none;fill-rule:nonzero;fill:#FFFFFF;fill-opacity:1;"
                                    d="M 186.265625 100.609375 L 203.367188 76.222656 C 204.8125 74.160156 204.3125 71.324219 202.25 69.882812 L 169.871094 47.242188 C 168.878906 46.550781 167.65625 46.277344 166.464844 46.488281 C 165.273438 46.699219 164.214844 47.371094 163.519531 48.359375 L 64.929688 188.945312 C 62.636719 192.21875 61.429688 196.0625 61.4375 200.054688 L 61.519531 229.667969 C 61.523438 231.148438 62.246094 232.535156 63.460938 233.382812 C 64.238281 233.925781 65.152344 234.207031 66.078125 234.207031 C 66.597656 234.207031 67.121094 234.117188 67.625 233.9375 L 95.519531 223.882812 C 99.28125 222.527344 102.484375 220.082031 104.78125 216.808594 Z M 168.375 57.3125 L 193.285156 74.726562 L 181.414062 91.660156 L 156.503906 74.242188 Z M 97.3125 211.585938 C 96.101562 213.3125 94.410156 214.601562 92.421875 215.320312 L 70.617188 223.179688 L 70.558594 200.03125 C 70.550781 197.925781 71.191406 195.898438 72.402344 194.171875 L 151.273438 81.703125 L 176.183594 99.117188 Z M 97.3125 211.585938 " />
                            </g>
                        </g>
                    </svg>
                </div>
            </div>

            {{-- alamat --}}
            <div class="w-auto h-6 ml-8 pt-12 pb-2">
                <label for="nama" class="font-Poppins text-black">Alamat</label>
                <div class="relative">
                    <input type="text" name="nama" id="nama"
                        class="w-[85%] h-9 bg-[#284123] outline-none pl-4 pr-4 rounded-md focus:border-none focus:outline-none focus:ring-0">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-6 h-6 absolute right-20 top-1/2 transform -translate-y-1/2"
                        viewBox="0 0 283.5 283.500005" preserveAspectRatio="xMidYMid meet" version="1.2">
                        <defs>
                            <clipPath id="a5354d1d33">
                                <path
                                    d="M 123 227 L 221.636719 227 L 221.636719 236.472656 L 123 236.472656 Z M 123 227 " />
                            </clipPath>
                            <clipPath id="0daac9dfbb">
                                <path
                                    d="M 61.398438 46.285156 L 205 46.285156 L 205 235 L 61.398438 235 Z M 61.398438 46.285156 " />
                            </clipPath>
                        </defs>
                        <g id="6026f3be9d">
                            <g clip-rule="nonzero" clip-path="url(#a5354d1d33)">
                                <path style="stroke:none;fill-rule:nonzero;fill:#FFFFFF;fill-opacity:1;"
                                    d="M 217.039062 227.359375 L 128.179688 227.359375 C 125.660156 227.359375 123.617188 229.398438 123.617188 231.914062 C 123.617188 234.425781 125.660156 236.464844 128.179688 236.464844 L 217.039062 236.464844 C 219.554688 236.464844 221.597656 234.425781 221.597656 231.914062 C 221.597656 229.398438 219.554688 227.359375 217.039062 227.359375 Z M 217.039062 227.359375 " />
                            </g>
                            <g clip-rule="nonzero" clip-path="url(#0daac9dfbb)">
                                <path style="stroke:none;fill-rule:nonzero;fill:#FFFFFF;fill-opacity:1;"
                                    d="M 186.265625 100.609375 L 203.367188 76.222656 C 204.8125 74.160156 204.3125 71.324219 202.25 69.882812 L 169.871094 47.242188 C 168.878906 46.550781 167.65625 46.277344 166.464844 46.488281 C 165.273438 46.699219 164.214844 47.371094 163.519531 48.359375 L 64.929688 188.945312 C 62.636719 192.21875 61.429688 196.0625 61.4375 200.054688 L 61.519531 229.667969 C 61.523438 231.148438 62.246094 232.535156 63.460938 233.382812 C 64.238281 233.925781 65.152344 234.207031 66.078125 234.207031 C 66.597656 234.207031 67.121094 234.117188 67.625 233.9375 L 95.519531 223.882812 C 99.28125 222.527344 102.484375 220.082031 104.78125 216.808594 Z M 168.375 57.3125 L 193.285156 74.726562 L 181.414062 91.660156 L 156.503906 74.242188 Z M 97.3125 211.585938 C 96.101562 213.3125 94.410156 214.601562 92.421875 215.320312 L 70.617188 223.179688 L 70.558594 200.03125 C 70.550781 197.925781 71.191406 195.898438 72.402344 194.171875 L 151.273438 81.703125 L 176.183594 99.117188 Z M 97.3125 211.585938 " />
                            </g>
                        </g>
                    </svg>
                </div>
            </div>

            {{-- jam operasional --}}
            <div class="max-w-[16rem] ml-8 grid grid-cols-2 gap-x-10 pt-16">
                <div class="w-28">
                    <label for="start-time" class="block font-Poppins text-black">Jam Buka</label>
                    <div class="relative">
                        <input type="time" id="start-time"
                            class="bg-[#284123] leading-none border-none text-white text-base rounded-lg block w-full p-2.5"
                            min="06:00" max="24:00" value="00:00" required />
                    </div>
                </div>
                <div class="w-28">
                    <label for="end-time" class="block font-Poppins text-black">Jam Tutup</label>
                    <div class="relative">
                        <input type="time" id="end-time"
                            class="bg-[#284123] border-none leading-none text-white text-base rounded-lg block w-full p-2.5"
                            min="06:00" max="24:00" value="00:00" required />
                    </div>
                </div>
            </div>

            {{-- range harga --}}
            <div class="w-[80%] h-6 ml-8 grid grid-cols-2 gap-x-10 pt-3">
                <div class="w-48">
                    <label for="price-min" class="mb-1 text-black font-Poppins">Harga Minimal</label>
                    <input type="number" name="price-min" id="price-min"
                        class="w-full h-9 bg-[#284123] outline-none pl-4 pr-4 rounded-md border-none focus:border-none focus:outline-none focus:ring-0"
                        placeholder="$">
                </div>
                <div class="w-48">
                    <label for="price-max" class="mb-1 text-black font-Poppins">Harga Maximal</label>
                    <input type="number" name="price-max" id="price-max"
                        class="w-full h-9 bg-[#284123] outline-none pl-4 pr-4 rounded-md border-none focus:border-none focus:outline-none focus:ring-0"
                        placeholder="$">
                </div>
            </div>

            {{-- deskripsi --}}
            <div class="w-[80%] h-6 ml-8 pt-16">
                <label for="message" class="block mb-1 font-Poppins text-black">Deskripsi</label>
                <textarea id="message" rows="5"
                    class="block w-full text-sm text-white rounded-lg border border-[#284123] bg-transparent focus:outline-none focus:ring-0 focus:border-[#284123] focus:text-black"
                    placeholder=""></textarea>
            </div>

            <div class="flex justify-end px-20 mt-40 gap-4">
                <!-- Tombol Batal -->
                <button type="button" onclick="window.history.back()"
                    class="bg-gray-500 text-white py-2 px-6 rounded-lg hover:bg-gray-600 focus:outline-none">
                    Batal
                </button>
                <!-- Tombol Simpan -->
                <button type="submit"
                    class="bg-[#011C19] text-white py-2 px-6 rounded-lg hover:bg-[#284123] focus:outline-none">
                    Simpan
                </button>
            </div>
        </form>

        {{-- paket --}}
        <div class="ml-7">
            <div class="mt-4 flex">
                <label for="paket" class="font-Poppins text-black">Paket Utama</label>
            </div>
            <div class="w-[40vh] flex h-[7vh] border-solid border-4 border-[#D9D9D9] mt-2">
                <div class="text-black w-[50%] h-full flex justify-center items-center font-Kuunari text-4xl">
                    STANDARD
                </div>
                <div class="flex flex-col text-black font-Poppins">
                    <div class="w-full h-[50%] flex justify-center items-center">
                        Berlaku hingga
                    </div>
                    <div class="w-full h-[50%] flex justify-start items-center">
                        32 Feb 2026
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="w-[35%] h-screen flex flex-col">
        <div id="penataRambut" class="w-full">
            <div class="flex items-start pt-10 h-auto ">
                <div class="w-full">
                    <h1 class="text-2xl mb-4 text-black font-Poppins">Penata Rambut</h1>

                    <!-- Menampilkan foto-foto yang diunggah -->
                    <div class="">
                        <!-- Menampilkan gambar yang disimpan dari localStorage jika ada -->
                        <img id="imagePreview" src="{{ asset('images/penata.png') }}" alt="penata"
                            class="w-72 h-72 rounded-md bg-black">
                    </div>

                    <!-- Tombol Unggah Foto -->
                    <button onclick="document.getElementById('fileInput').click();"
                        class="bg-[#284123] text-xl font-Kuunari text-white py-2 px-6 rounded-lg hover:bg-green-600 focus:outline-none mt-4">
                        Unggah Foto
                    </button>

                    <!-- Input file yang disembunyikan untuk multiple file -->
                    <input type="file" id="fileInput" class="hidden" accept="image/*" multiple
                        onchange="handleImageUpload(event)">
                </div>
            </div>

        </div>
        {{-- nama --}}
        <div class="w-full mt-5">
            <label for="nama" class="font-Poppins text-black">Nama Pemotong Rambut</label>
            <div class="relative">
                <input type="text" name="nama" id="nama"
                    class="w-[50%] h-9 bg-[#284123] outline-none pl-4 pr-4 rounded-md focus:border-none focus:outline-none focus:ring-0">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-6 h-6 absolute left-60 top-1/2 transform -translate-y-1/2" viewBox="0 0 283.5 283.500005"
                    preserveAspectRatio="xMidYMid meet" version="1.2">
                    <defs>
                        <clipPath id="a5354d1d33">
                            <path
                                d="M 123 227 L 221.636719 227 L 221.636719 236.472656 L 123 236.472656 Z M 123 227 " />
                        </clipPath>
                        <clipPath id="0daac9dfbb">
                            <path
                                d="M 61.398438 46.285156 L 205 46.285156 L 205 235 L 61.398438 235 Z M 61.398438 46.285156 " />
                        </clipPath>
                    </defs>
                    <g id="6026f3be9d">
                        <g clip-rule="nonzero" clip-path="url(#a5354d1d33)">
                            <path style="stroke:none;fill-rule:nonzero;fill:#FFFFFF;fill-opacity:1;"
                                d="M 217.039062 227.359375 L 128.179688 227.359375 C 125.660156 227.359375 123.617188 229.398438 123.617188 231.914062 C 123.617188 234.425781 125.660156 236.464844 128.179688 236.464844 L 217.039062 236.464844 C 219.554688 236.464844 221.597656 234.425781 221.597656 231.914062 C 221.597656 229.398438 219.554688 227.359375 217.039062 227.359375 Z M 217.039062 227.359375 " />
                        </g>
                        <g clip-rule="nonzero" clip-path="url(#0daac9dfbb)">
                            <path style="stroke:none;fill-rule:nonzero;fill:#FFFFFF;fill-opacity:1;"
                                d="M 186.265625 100.609375 L 203.367188 76.222656 C 204.8125 74.160156 204.3125 71.324219 202.25 69.882812 L 169.871094 47.242188 C 168.878906 46.550781 167.65625 46.277344 166.464844 46.488281 C 165.273438 46.699219 164.214844 47.371094 163.519531 48.359375 L 64.929688 188.945312 C 62.636719 192.21875 61.429688 196.0625 61.4375 200.054688 L 61.519531 229.667969 C 61.523438 231.148438 62.246094 232.535156 63.460938 233.382812 C 64.238281 233.925781 65.152344 234.207031 66.078125 234.207031 C 66.597656 234.207031 67.121094 234.117188 67.625 233.9375 L 95.519531 223.882812 C 99.28125 222.527344 102.484375 220.082031 104.78125 216.808594 Z M 168.375 57.3125 L 193.285156 74.726562 L 181.414062 91.660156 L 156.503906 74.242188 Z M 97.3125 211.585938 C 96.101562 213.3125 94.410156 214.601562 92.421875 215.320312 L 70.617188 223.179688 L 70.558594 200.03125 C 70.550781 197.925781 71.191406 195.898438 72.402344 194.171875 L 151.273438 81.703125 L 176.183594 99.117188 Z M 97.3125 211.585938 " />
                        </g>
                    </g>
                </svg>
            </div>
        </div>
        {{-- deskripsi --}}
        <div class="w-[80%] h-6 mt-5">
            <label for="message" class="block mb-1 font-Poppins text-black">Deskripsi</label>
            <textarea id="message" rows="5"
                class="block w-full text-sm text-white rounded-lg border border-[#284123] bg-transparent focus:outline-none focus:ring-0 focus:border-[#284123] focus:text-black"
                placeholder=""></textarea>
        </div>
    </div>

</div>

<script>
    // Fungsi untuk menampilkan preview gambar setelah memilih file
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Menyimpan gambar ke localStorage untuk gambar pertama
                localStorage.setItem('uploadedImage', e.target.result);
                // Mengubah gambar yang ada di halaman sesuai dengan gambar yang dipilih
                document.getElementById('logoPreview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }

    // Memuat gambar yang sudah disimpan dari localStorage saat halaman dimuat ulang
    window.onload = function() {
        const savedImage = localStorage.getItem('uploadedImage');
        if (savedImage) {
            document.getElementById('logoPreview').src = savedImage;
        }
    }

    // Fungsi untuk mengunggah dan menampilkan gambar-gambar lainnya dalam galeri
    function handleImageUpload(event) {
        const files = event.target.files;
        const imageGallery = document.getElementById('imagePreview');

        // Clear existing images in the gallery
        imageGallery.innerHTML = '';

        // Loop through selected files and display them
        for (let i = 0; i < files.length; i++) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgElement = document.createElement('img');
                imgElement.src = e.target.result;
                imgElement.classList.add('mb-4', 'w-40', 'h-40', 'object-cover');
                imageGallery.appendChild(imgElement);
            };
            reader.readAsDataURL(files[i]);
        }
    }
</script>
