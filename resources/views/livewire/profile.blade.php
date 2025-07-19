<div class= "flex flex-col w-full">
    <a href="#">
        <button
            class="circle-button w-10 h-10 rounded-full bg-[#E9BF80] text-xl flex justify-center items-center ml-16 mt-9">
            <svg version="1.0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 671.000000 680.000000" class="w-4 h-4"
                preserveAspectRatio="xMidYMid meet">

                <g transform="translate(0.000000,680.000000) scale(0.100000,-0.100000)" fill="#6B592E" stroke="none">
                    <path d="M4512 6740 c-161 -42 -108 5 -1177 -1060 -539 -537 -1188 -1183
-1441 -1436 -515 -512 -526 -526 -571 -698 -30 -116 -30 -216 0 -333 48 -186
-54 -74 1536 -1663 1092 -1092 1450 -1444 1494 -1469 117 -69 170 -81 345 -81
149 0 161 2 236 30 392 146 551 605 338 974 -28 49 -268 294 -1188 1215 -635
634 -1154 1156 -1154 1159 0 4 517 524 1149 1157 842 842 1160 1167 1190 1214
136 213 130 504 -14 722 -87 130 -241 239 -386 274 -91 21 -265 19 -357 -5z" />
                </g>
            </svg>
        </button>
    </a>

    <div class="w-full h-auto ml-10">
        <h1 class="font-Kuunari text-5xl pl-52 pt-4">
            PROFIL SAYA
        </h1>
    </div>
    <div class="font-Poppins text-lg pl-52 pt-4 ml-10">
        <p class="">Kelola informasi profil Anda untuk mengontrol, melindungi dan mengamankan akun</p>
    </div>

    <div class="flex flex-row">
        {{-- kiri --}}
        <div class="w-[50%] h-auto mt-14 ml-10">
            <div class="font-Poppins text-[#FAFAFA] pl-52">
                <p class="text-xl">Profil</p>
            </div>
            <div class="mt-6">
                <!-- Logo -->
                <div class="mb-8 pl-52">
                    <!-- Menampilkan gambar yang disimpan dari localStorage jika ada -->
                    <img id="logoPreview" src="{{ asset('assets/ld/buzzcut.jpg') }}" alt="logo" class="rounded-lg">
                </div>

                <!-- Tombol Unggah Foto -->
                <button onclick="#"
                    class="bg-[#1A1A1A] ml-52 text-xl font-Poppins text-white py-2 px-6 rounded-lg border border-[#D9D9D9] hover:bg-[#D9D9D9] hover:border-[#1A1A1A] hover:text-[#1A1A1A] focus:outline-none mb-4">
                    Unggah Foto Baru
                </button>

            </div>
        </div>

        {{-- kanan --}}
        <div class="w-[50%] h-auto mt-20 ml-20">
            <form action="" method="POST" class="flex flex-col gap-12">
                {{-- nama barber --}}
                <div class="w-auto h-6 ml-8">
                    <label for="nama" class="font-Poppins text-white">Username</label>
                    <div class="relative w-full">
                        <input type="text" name="nama" id="nama"
                            class="w-[60%] h-9 bg-[#1A1A1A] outline-none pl-4 pr-4 border-none rounded-md focus:border-none focus:outline-none focus:ring-0">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-6 h-6 absolute right-64 top-1/2 transform -translate-y-1/2"
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

                {{-- email --}}
                <div class="w-auto h-6 ml-8">
                    <label for="nama" class="font-Poppins text-white">Email</label>
                    <div class="relative w-full">
                        <input type="email" name="nama" id="nama"
                            class="w-[60%] h-9 bg-[#1A1A1A] outline-none pl-4 pr-4 border-none rounded-md focus:border-none focus:outline-none focus:ring-0">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-6 h-6 absolute right-64 top-1/2 transform -translate-y-1/2"
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

                {{-- gender --}}
                <div class="w-auto h-6 ml-8">
                    <label for="nama" class="font-Poppins text-white">Jenis Kelamin</label>
                    <div class="flex flex-row mt-1 gap-9 items-center h-9">
                        <div class="flex items-center  rounded-sm">
                            <input id="bordered-radio-1" type="radio" name="bordered-radio"
                                class="w-4 h-4 text-[#1A1A1A] bg-white border-none focus:ring-2 focus:ring-black">
                            <label for="bordered-radio-1" class="ms-2 text-md font-Poppins text-white">Laki-laki</label>
                        </div>
                        <div class="flex items-center rounded-sm">
                            <input id="bordered-radio-1" type="radio" name="bordered-radio"
                                class="w-4 h-4 text-[#1A1A1A] bg-white border-none focus:ring-2 focus:ring-black">
                            <label for="bordered-radio-1" class="ms-2 text-md font-Poppins text-white">Perempuan</label>
                        </div>
                        <div class="flex items-center rounded-sm">
                            <input id="bordered-radio-1" type="radio" name="bordered-radio"
                                class="w-4 h-4 text-[#1A1A1A] bg-white border-none focus:ring-2 focus:ring-black">
                            <label for="bordered-radio-1" class="ms-2 text-md font-Poppins text-white">Lainnya</label>
                        </div>
                    </div>
                </div>

                {{-- tanggal lahir --}}
                <div class="w-auto ml-8">
                    <div class="relative w-[60%]">
                        <label for="nama" class="font-Poppins text-white">Tanggal Lahir</label>
                        <div
                            class="flex items-center w-full h-9 bg-[#1A1A1A] outline-none pl-4 pr-4 border-none rounded-md focus:border-none focus:outline-none focus:ring-0">
                            <label for="" class="text-gray-400">ultah</label>
                        </div>
                    </div>
                </div>
            </form>
            <div class="w-[50%] ml-8 mt-2 font-Poppins">
                <p class="text-sm">Kamu sudah melakukan verifikasi KYC sehingga tidak dapat mengubah tanggal lahir
                </p>
            </div>

            {{-- button --}}
            <div class="flex justify-end mr-60 mt-11">
                <div
                    class="bg-[#2C3E50] text-white rounded-md w-[15vh] h-[4vh] flex justify-center items-center border border-solid border-[#D9D9D9] hover:bg-[#D9D9D9] hover:border-[#2C3E50] hover:text-[#2C3E50]">
                    <button class="">Simpan</button>
                </div>

            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr('#flatpickr-date', {
            dateFormat: 'Y-m-d',
            monthSelectorType: 'static'
        });
    });
</script>
