<div class="container mx-auto px-4 py-8 min-h-screen">
    <div class="max-w-6xl mx-auto">
        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center mb-8 gap-4">
            <a href="{{ route('home') }}" wire:navigate
                class="p-2 rounded-full bg-Satin-Sheen-Yellow hover:bg-Satin-Sheen-Yellow hover:scale-110 hover:shadow-lg transition-all duration-300 ease-in-out flex-shrink-0 group">
                <svg version="1.0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 671.000000 680.000000"
                    class="w-6 h-6 group-hover:scale-110 transition-transform duration-300"
                    preserveAspectRatio="xMidYMid meet">
                    <g transform="translate(0.000000,680.000000) scale(0.100000,-0.100000)" fill="#6B592E"
                        stroke="none">
                        <path d="M4512 6740 c-161 -42 -108 5 -1177 -1060 -539 -537 -1188 -1183
-1441 -1436 -515 -512 -526 -526 -571 -698 -30 -116 -30 -216 0 -333 48 -186
-54 -74 1536 -1663 1092 -1092 1450 -1444 1494 -1469 117 -69 170 -81 345 -81
149 0 161 2 236 30 392 146 551 605 338 974 -28 49 -268 294 -1188 1215 -635
634 -1154 1156 -1154 1159 0 4 517 524 1149 1157 842 842 1160 1167 1190 1214
136 213 130 504 -14 722 -87 130 -241 239 -386 274 -91 21 -265 19 -357 -5z" />
                    </g>
                </svg>
            </a>

            <div class="flex-1">
                <h1 class="font-Kuunari text-3xl sm:text-4xl md:text-5xl text-Seasalt mb-2">
                    PROFIL SAYA
                </h1>
                <p class="text-base sm:text-lg text-gray-300">
                    Kelola informasi profil Anda untuk mengontrol, melindungi dan mengamankan akun
                </p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
            <!-- Left Column - Profile Image -->
            <div class="bg-Eerie-Black rounded-lg p-4 sm:p-6 border border-gray-700 order-2 lg:order-1">
                <h2 class="text-lg sm:text-xl font-semibold text-Seasalt mb-4 sm:mb-6">Foto Profil</h2>

                <!-- Current Profile Image -->
                <div class="flex justify-center items-center mb-4 sm:mb-6">
                    @if ($current_photo)
                        <img src="{{ $current_photo }}" alt="Profile Photo"
                            class="w-24 h-24 sm:w-32 sm:h-32 md:w-40 md:h-40 rounded-full object-cover border-4 border-Satin-Sheen-Yellow">
                    @else
                        <div
                            class="w-24 h-24 sm:w-32 sm:h-32 md:w-40 md:h-40 rounded-full bg-gradient-to-br from-Satin-Sheen-Yellow to-Dun flex items-center justify-center border-4 border-Satin-Sheen-Yellow profile-image-hover">
                            <span
                                class="text-Eerie-Black font-bold text-lg sm:text-xl md:text-2xl font-Kuunari">{{ $this->getInitials() }}</span>
                        </div>
                    @endif
                </div>

                <!-- Photo Upload Section -->
                <div class="text-center">
                    <input type="file" wire:model="photo" id="photo-upload" class="hidden" accept="image/*">
                    <label for="photo-upload"
                        class="inline-block bg-Dark-Teal text-Seasalt px-4 sm:px-6 py-2 sm:py-3 rounded-lg cursor-pointer hover:bg-opacity-90 hover:scale-105 hover:shadow-lg transition-all duration-300 ease-in-out border border-gray-600 text-sm sm:text-base group button-hover-lift button-hover-slide">
                        <span class="group-hover:translate-x-1 transition-transform duration-300 inline-block">Unggah
                            Foto Baru</span>
                    </label>

                    @if ($photo)
                        <div class="mt-4 p-3 bg-green-900 rounded-lg">
                            <p class="text-green-300 text-sm">Foto baru dipilih: {{ $photo->getClientOriginalName() }}
                            </p>
                        </div>
                    @endif

                    @error('photo')
                        <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                    @enderror

                    <p class="text-gray-400 text-xs sm:text-sm mt-2">
                        Format: JPG, PNG. Maksimal 2MB.
                    </p>
                </div>
            </div>

            <!-- Right Column - Profile Form -->
            <div class="bg-Eerie-Black rounded-lg p-4 sm:p-6 border border-gray-700 order-1 lg:order-2">
                <h2 class="text-lg sm:text-xl font-semibold text-Seasalt mb-4 sm:mb-6">Informasi Profil</h2>

                <form wire:submit="save" class="space-y-4 sm:space-y-6">
                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="block text-Seasalt font-medium mb-2 text-sm sm:text-base">
                            Nama Depan *
                        </label>
                        <div class="relative">
                            <input type="text" wire:model="first_name" id="first_name"
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 bg-gray-800 border border-gray-600 rounded-lg text-Seasalt focus:border-Satin-Sheen-Yellow focus:ring-1 focus:ring-Satin-Sheen-Yellow focus:outline-none transition-colors duration-200 text-sm sm:text-base"
                                placeholder="Masukkan nama depan">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        @error('first_name')
                            <p class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="last_name" class="block text-Seasalt font-medium mb-2 text-sm sm:text-base">
                            Nama Belakang *
                        </label>
                        <div class="relative">
                            <input type="text" wire:model="last_name" id="last_name"
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 bg-gray-800 border border-gray-600 rounded-lg text-Seasalt focus:border-Satin-Sheen-Yellow focus:ring-1 focus:ring-Satin-Sheen-Yellow focus:outline-none transition-colors duration-200 text-sm sm:text-base"
                                placeholder="Masukkan nama belakang">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        @error('last_name')
                            <p class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-Seasalt font-medium mb-2 text-sm sm:text-base">
                            Email *
                        </label>
                        <div class="relative">
                            <input type="email" wire:model.blur="email" id="email"
                                class="w-full px-3 sm:px-4 py-2 sm:py-3 bg-gray-800 border border-gray-600 rounded-lg text-Seasalt focus:border-Satin-Sheen-Yellow focus:ring-1 focus:ring-Satin-Sheen-Yellow focus:outline-none transition-colors duration-200 text-sm sm:text-base"
                                placeholder="Masukkan email">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z">
                                    </path>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                </svg>
                            </div>
                        </div>
                        @error('email')
                            <p class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Gender -->
                    <div>
                        <label class="block text-Seasalt font-medium mb-3 text-sm sm:text-base">Jenis Kelamin</label>
                        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" wire:model="gender" value="male"
                                    class="w-4 h-4 text-Satin-Sheen-Yellow bg-gray-800 border-gray-600 focus:ring-Satin-Sheen-Yellow focus:ring-2">
                                <span class="ml-2 text-Seasalt text-sm sm:text-base">Laki-laki</span>
                            </label>
                            <label class="flex items-center cursor-pointer">
                                <input type="radio" wire:model="gender" value="female"
                                    class="w-4 h-4 text-Satin-Sheen-Yellow bg-gray-800 border-gray-600 focus:ring-Satin-Sheen-Yellow focus:ring-2">
                                <span class="ml-2 text-Seasalt text-sm sm:text-base">Perempuan</span>
                            </label>
                        </div>
                        @error('gender')
                            <p class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Birth Date -->
                    <div>
                        <label for="birth_date" class="block text-Seasalt font-medium mb-2 text-sm sm:text-base">
                            Tanggal Lahir
                        </label>
                        <input type="date" wire:model="birth_date" id="birth_date"
                            class="w-full px-3 sm:px-4 py-2 sm:py-3 bg-gray-800 border border-gray-600 rounded-lg text-Seasalt focus:border-Satin-Sheen-Yellow focus:ring-1 focus:ring-Satin-Sheen-Yellow focus:outline-none transition-colors duration-200 text-sm sm:text-base">
                        @error('birth_date')
                            <p class="text-red-400 text-xs sm:text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end pt-4">
                        <button type="submit"
                            class="bg-Dark-Teal text-Seasalt px-6 sm:px-8 py-2 sm:py-3 rounded-lg hover:bg-opacity-90 hover:scale-105 hover:shadow-lg transition-all duration-300 ease-in-out font-medium border border-gray-600 focus:outline-none focus:ring-2 focus:ring-Satin-Sheen-Yellow text-sm sm:text-base group button-hover-lift button-hover-slide">
                            <span
                                class="group-hover:translate-x-1 transition-transform duration-300 inline-block">Simpan
                                Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        // Listen for toast notifications
        window.addEventListener('show-toast', event => {
            const {
                type,
                message
            } = event.detail[0];
            if (window.notyf) {
                window.notyf.open({
                    type: type,
                    message: message,
                    duration: 4000,
                    position: {
                        x: 'right',
                        y: 'bottom',
                    },
                    ripple: true
                });
            }
        });
    </script>
@endpush
