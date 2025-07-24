@props(['currentRoute' => ''])

<aside class="w-64 bg-slate-800 text-white flex flex-col shadow-xl">
    <div class="p-6 border-b border-gray-600">
        <div class="flex items-center">
            <img src="{{ asset('assets/ld/logo-text.png') }}" alt="SeeCut Logo" class="h-12">
        </div>
    </div>

    <nav class="flex-1 p-4">
        <ul class="space-y-2">
            <li>
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center font-Kuunari text-lg p-3 {{ request()->routeIs('admin.dashboard') ? 'bg-white text-slate-800' : 'hover:bg-white hover:text-slate-800' }} rounded-lg font-semibold transition-all duration-300 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    DASBOR
                </a>
            </li>
            <li>
                <a href="{{ route('berlangganan') }}"
                    class="flex items-center font-Kuunari text-lg p-3 {{ request()->routeIs('berlangganan') ? 'bg-white text-slate-800' : 'hover:bg-white hover:text-slate-800' }} rounded-lg font-semibold transition-all duration-300 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    BERLANGGANAN
                </a>
            </li>
        </ul>
    </nav>

    <div class="p-4 border-t border-gray-600">
        @auth
            @php
                $user = Auth::user();
                $profile = $user->profile ?? null;
                $fullName = $profile?->full_name ?? $user->name ?? 'Admin';
                $role = ucfirst($profile?->role ?? 'Administrator');
                
                // Generate initials from full name
                $nameParts = explode(' ', trim($fullName));
                if (count($nameParts) >= 2) {
                    $initials = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1));
                } else {
                    $initials = strtoupper(substr($fullName, 0, 2));
                }
            @endphp
            
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                    <span class="text-white font-bold text-sm">{{ $initials }}</span>
                </div>
                <div>
                    <p class="text-sm font-semibold text-white">{{ $fullName }}</p>
                    <p class="text-xs text-gray-400">{{ $role }}</p>
                </div>
            </div>
        @else
            <div class="flex items-center mb-4">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-3">
                    <span class="text-white font-bold text-sm">AD</span>
                </div>
                <div>
                    <p class="text-sm font-semibold text-white">Admin</p>
                    <p class="text-xs text-gray-400">Administrator</p>
                </div>
            </div>
        @endauth
        
        <form method="POST" action="{{ route('admin.logout.post') }}" class="w-full">
            @csrf
            <button type="submit"
                class="flex items-center w-full p-3 hover:bg-red-600 hover:text-white rounded-lg font-semibold transition-all duration-300 text-red-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                KELUAR
            </button>
        </form>
    </div>
</aside>
