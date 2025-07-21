<div
    class="flex flex-col lg:flex-row justify-between items-center gap-4 px-8 md:px-16 lg:px-48 py-4 bg-Dark-Teal relative z-50">
    <div>
        <a href="{{ route('vendor.reservation') }}"><img class="w-24"
                src="{{ asset(path: 'assets/images/logo-text.png') }}" alt="SeeCut"></a>
    </div>
    <div class="flex flex-col sm:flex-row gap-7 justify-center items-center">
        <a class="font-Kuunari text-Seasalt text-xl hover:text-Ecru transition-colors duration-300 ease-in-out"
            href="{{ route('vendor.reservation') }}">RESERVASI</a>
        <a class="font-Kuunari text-Seasalt text-xl hover:text-Ecru transition-colors duration-300 ease-in-out"
            href="{{ route('vendor.profile') }}">INFORMASI</a>
        <a class="font-Kuunari text-Seasalt text-xl hover:text-Ecru transition-colors duration-300 ease-in-out"
            href="{{ route('vendor.extend') }}">PREMIUM</a>
    </div>
    <div class="relative" x-data="{ open: false }" @click.outside="open = false">
        <!-- Profile Dropdown Trigger -->
        <button @click="open = !open"
            class="flex items-center gap-3 font-Kuunari ring-1 ring-Seasalt text-Seasalt px-4 py-2 text-md hover:ring-Satin-Sheen-Yellow hover:bg-Satin-Sheen-Yellow/10 transition-all duration-300 ease-in-out rounded-lg focus:outline-none focus:ring-2 focus:ring-Satin-Sheen-Yellow focus:ring-opacity-50">
            <!-- Profile Image -->
            @php
                $profileImage = null;
                if (auth()->user() && auth()->user()->profile && auth()->user()->profile?->image_id) {
                    $profileImage = \App\Models\ProfileImage::find(auth()->user()->profile->image_id);
                }
            @endphp
            @if ($profileImage && $profileImage->source)
                <img src="{{ asset('storage/' . $profileImage->source) }}" alt="Profile"
                    class="w-8 h-8 rounded-full object-cover border-2 border-Seasalt">
            @else
                <div class="w-8 h-8 rounded-full bg-Seasalt/20 flex items-center justify-center">
                    <svg class="w-5 h-5 text-Seasalt" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            @endif

            <!-- Vendor Name -->
            <span class="hidden sm:block">
                {{ auth()->user()?->vendor?->name ?? 'Guest' }}
            </span>

            <!-- Dropdown Arrow -->
            <svg class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>

        <!-- Dropdown Menu -->
        <div x-show="open" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
            class="absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-2xl ring-1 ring-black/10 z-50 backdrop-blur-sm"
            style="filter: drop-shadow(0 20px 25px rgb(0 0 0 / 0.15));">

            <!-- Profile Header -->
            <div class="px-6 py-4 border-b border-gray-100/80">
                <div class="flex items-center gap-4">
                    @php
                        $profileImage = null;
                        if (auth()->user() && auth()->user()->profile && auth()->user()->profile->image_id) {
                            $profileImage = \App\Models\ProfileImage::find(auth()->user()->profile->image_id);
                        }
                    @endphp
                    @if ($profileImage && $profileImage->source)
                        <img src="{{ asset('storage/' . $profileImage->source) }}" alt="Profile"
                            class="w-12 h-12 rounded-full object-cover border-2 border-gray-200/50 shadow-sm">
                    @else
                        <div
                            class="w-12 h-12 rounded-full bg-gradient-to-br from-Dark-Teal to-Satin-Sheen-Yellow flex items-center justify-center shadow-sm">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg font-bold text-gray-900 truncate font-Kuunari">
                            {{ auth()->user()?->vendor?->name ?? 'Guest User' }}
                        </h3>
                        <p class="text-sm text-gray-500 truncate">
                            {{ auth()->user()?->email ?? 'Not logged in' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Menu Items -->
            <div class="py-2">
                <a href="{{ route('vendor.profile') }}"
                    class="flex items-center gap-3 px-6 py-3 text-gray-700 hover:bg-gray-50/80 transition-all duration-200 group focus:outline-none focus:bg-gray-50/80">
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-Dark-Teal transition-colors duration-200"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="font-medium">Edit Profile</span>
                </a>

                <div class="border-t border-gray-100/80 my-2"></div>

                <form method="POST" action="{{ route('vendor.logout.post') }}" class="w-full">
                    @csrf
                    <button type="submit"
                        class="flex items-center gap-3 px-6 py-3 text-red-600 hover:bg-red-50/80 transition-all duration-200 group w-full text-left focus:outline-none focus:bg-red-50/80">
                        <svg class="w-5 h-5 text-red-500 group-hover:text-red-600 transition-colors duration-200"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
