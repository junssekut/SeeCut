@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
        background: #f3f4f6;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 6px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #bdbdbd;
    }

    .custom-scrollbar {
        scrollbar-width: thin;
        scrollbar-color: #d1d5db #f3f4f6;
    }
</style>

<div class="flex h-screen bg-gradient-to-br from-gray-50 to-gray-100">
    <!-- Use the admin sidebar component -->
    <x-admin-sidebar />

    <main class="flex-1 overflow-y-auto bg-gradient-to-br from-gray-50 to-gray-100">
        <div class="p-8">
            <!-- Admin Header -->
            <header class="flex justify-between items-center mb-10 animate-fade-in">
                <div>
                    <h1 class="text-4xl font-extrabold text-gray-900 tracking-wide font-Kuunari mb-2">
                        DASBOR ADMIN
                    </h1>
                    <p class="text-gray-600 text-lg">
                        Selamat datang di dashboard admin SeeCut
                    </p>
                </div>
            </header>

            <!-- Page Content -->
            <div class="grid grid-cols-1 lg:grid-cols-7 gap-8">
                <div class="lg:col-span-5 space-y-8">
                    <section
                        class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 mb-1">Ringkasan</h2>
                                <p class="text-gray-600">Ikhtisar statistik sistem</p>
                            </div>
                            <button
                                class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2 rounded-lg text-sm font-semibold transition-colors duration-200">
                                Semua ▾
                            </button>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div
                                class="bg-gradient-to-br from-blue-500 to-blue-600 text-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-blue-100 text-sm font-medium">Total Langganan</p>
                                        <p class="text-4xl font-bold mt-2">{{ number_format($totalSubscriptions) }}</p>
                                        <p class="text-blue-100 text-sm mt-1">↗ Aktif saat ini</p>
                                    </div>
                                    <div class="bg-blue-400/30 p-3 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="bg-gradient-to-br from-emerald-500 to-emerald-600 text-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-emerald-100 text-sm font-medium">Total Pendapatan</p>
                                        <p class="text-3xl font-bold mt-2">Rp
                                            {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                                        <p class="text-emerald-100 text-sm mt-1">↗ Per bulan</p>
                                    </div>
                                    <div class="bg-emerald-400/30 p-3 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                            <div
                                class="bg-gradient-to-br from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 border border-purple-200 transition-all duration-300 p-6 rounded-xl shadow-sm hover:shadow-md cursor-pointer group">
                                <div class="flex items-center justify-between mb-4">
                                    <p class="text-purple-600 text-sm font-semibold">Total Pengguna</p>
                                    <div
                                        class="w-10 h-10 bg-purple-200 rounded-xl flex items-center justify-center group-hover:bg-purple-300 transition-colors">
                                        <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <p class="text-3xl font-bold text-gray-900 leading-none">
                                        {{ number_format($totalUsers) }}</p>
                                    <div class="flex items-center">
                                        <span
                                            class="text-green-600 text-sm font-semibold bg-green-100 px-3 py-1 rounded-full">
                                            Terdaftar
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="bg-gradient-to-br from-orange-50 to-orange-100 hover:from-orange-100 hover:to-orange-200 border border-orange-200 transition-all duration-300 p-6 rounded-xl shadow-sm hover:shadow-md cursor-pointer group">
                                <div class="flex items-center justify-between mb-4">
                                    <p class="text-orange-600 text-sm font-semibold">Rata-rata Pendapatan</p>
                                    <div
                                        class="w-10 h-10 bg-orange-200 rounded-xl flex items-center justify-center group-hover:bg-orange-300 transition-colors">
                                        <svg class="w-5 h-5 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <p class="text-2xl font-bold text-gray-900 leading-none">
                                        Rp
                                        {{ number_format($totalSubscriptions > 0 ? $totalRevenue / $totalSubscriptions : 0, 0, ',', '.') }}
                                    </p>
                                    <div class="flex items-center">
                                        <span
                                            class="text-orange-600 text-sm font-semibold bg-orange-100 px-3 py-1 rounded-full">
                                            Per vendor
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="bg-gradient-to-br from-teal-50 to-teal-100 hover:from-teal-100 hover:to-teal-200 border border-teal-200 transition-all duration-300 p-6 rounded-xl shadow-sm hover:shadow-md cursor-pointer group">
                                <div class="flex items-center justify-between mb-4">
                                    <p class="text-teal-600 text-sm font-semibold">Tingkat Pertumbuhan</p>
                                    <div
                                        class="w-10 h-10 bg-teal-200 rounded-xl flex items-center justify-center group-hover:bg-teal-300 transition-colors">
                                        <svg class="w-5 h-5 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <p class="text-2xl font-bold text-gray-900 leading-none">+15.3%</p>
                                    <div class="flex items-center">
                                        <span
                                            class="text-green-600 text-sm font-semibold bg-green-100 px-3 py-1 rounded-full">
                                            Bulan ini
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section
                        class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 mb-1">Aktivitas Vendor</h2>
                                <p class="text-gray-600">Aktivitas terbaru dari vendor barbershop</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                                <span class="text-sm text-gray-600 font-medium">Pembaruan Langsung</span>
                            </div>
                        </div>
                        <div class="space-y-4 max-h-80 overflow-y-auto pr-2 custom-scrollbar">
                            @forelse($vendorActivities as $activity)
                                @php
                                    $colors = [
                                        'from-blue-500 to-purple-600',
                                        'from-green-500 to-teal-600',
                                        'from-purple-500 to-pink-600',
                                        'from-orange-500 to-red-600',
                                        'from-indigo-500 to-blue-600',
                                        'from-teal-500 to-cyan-600',
                                        'from-pink-500 to-rose-600',
                                        'from-yellow-500 to-orange-600',
                                    ];
                                    $colorIndex = abs(crc32($activity['name'])) % count($colors);
                                    $avatarColor = $colors[$colorIndex];
                                @endphp
                                <div
                                    class="flex items-center bg-gradient-to-r from-gray-50 to-gray-100 hover:from-blue-50 hover:to-indigo-50 p-5 rounded-xl shadow-sm hover:shadow-md transition-all duration-300 border border-gray-200 hover:border-blue-200 group">
                                    <div
                                        class="w-14 h-14 rounded-full flex-shrink-0 ring-4 ring-white shadow-lg group-hover:ring-blue-100 transition-all duration-300 bg-gradient-to-br {{ $avatarColor }} flex items-center justify-center">
                                        <span class="text-white font-bold text-lg">
                                            {{ strtoupper(substr($activity['name'], 0, 2)) }}
                                        </span>
                                    </div>
                                    <div class="ml-5 flex-1">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <p class="text-gray-900 font-bold text-base mb-1">
                                                    {{ $activity['activity'] }}</p>
                                                <div class="flex items-center space-x-2">
                                                    <p class="text-sm text-gray-600">
                                                        <span
                                                            class="font-semibold text-blue-600">{{ $activity['name'] }}</span>
                                                    </p>
                                                    <span class="w-1 h-1 bg-gray-400 rounded-full"></span>
                                                    <p class="text-sm text-gray-500">{{ $activity['time'] }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-2">
                                                @php
                                                    $typeColors = [
                                                        'update' => 'bg-blue-100 text-blue-700',
                                                        'create' => 'bg-green-100 text-green-700',
                                                        'confirm' => 'bg-yellow-100 text-yellow-700',
                                                        'upload' => 'bg-purple-100 text-purple-700',
                                                    ];
                                                    $typeIcons = [
                                                        'update' => '🔄',
                                                        'create' => '➕',
                                                        'confirm' => '✅',
                                                        'upload' => '📤',
                                                    ];
                                                    $typeNames = [
                                                        'update' => 'Perbarui',
                                                        'create' => 'Buat',
                                                        'confirm' => 'Konfirmasi',
                                                        'upload' => 'Unggah',
                                                    ];
                                                @endphp
                                                <span
                                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $typeColors[$activity['type']] ?? 'bg-gray-100 text-gray-700' }}">
                                                    <span
                                                        class="mr-1">{{ $typeIcons[$activity['type']] ?? '📋' }}</span>
                                                    {{ $typeNames[$activity['type']] ?? ucfirst($activity['type']) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-12">
                                    <div
                                        class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 font-medium">Belum ada aktivitas vendor</p>
                                </div>
                            @endforelse
                        </div>
                    </section>

                    <!-- Revenue Growth Chart Section -->
                    <section
                        class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-900 mb-1">Grafik Pertumbuhan Pendapatan</h2>
                                <p class="text-gray-600">Tren pendapatan 6 bulan terakhir</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                <span class="text-sm text-gray-600 font-medium">Pertumbuhan:
                                    @php
                                        $revenues = $chartData['revenues'] ?? [];
                                        $growth = 0;
                                        if (count($revenues) > 1) {
                                            $firstRevenue = reset($revenues);
                                            $lastRevenue = end($revenues);
                                            if ($firstRevenue > 0) {
                                                $growth = ($lastRevenue / $firstRevenue) * 100 - 100;
                                            }
                                        }
                                    @endphp
                                    +{{ number_format($growth, 1) }}%</span>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6" style="height: 400px;">
                            <canvas id="revenueChart" style="width: 100%; height: 100%;"></canvas>
                        </div>
                    </section>
                </div>

                <!-- Right Sidebar for Notifications and Small Widgets -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Subscription Plans Section -->
                    <section
                        class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-1">Distribusi Paket</h3>
                                <p class="text-gray-600 text-sm">Paket berlangganan aktif</p>
                            </div>
                            <button
                                class="bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 hover:border-blue-300 px-3 py-1 rounded-lg text-xs font-semibold transition-all duration-200 shadow-sm hover:shadow-md mt-0.5"
                                onclick="openPackageModal()">
                                Detail
                            </button>
                        </div>

                        <!-- Subscription Chart -->
                        <div class="mb-4">
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-4"
                                style="height: 200px;">
                                <canvas id="subscriptionChart" style="width: 100%; height: 100%;"></canvas>
                            </div>
                        </div>

                        <!-- Summary Stats -->
                        <div class="grid grid-cols-2 gap-3 pt-4 border-t border-gray-100">
                            <div class="text-center">
                                <p class="text-xl font-bold text-gray-900">
                                    {{ array_sum(array_column($subscriptionPlans, 'count')) }}</p>
                                <p class="text-xs text-gray-600">Total Pelanggan</p>
                            </div>
                            <div class="text-center">
                                <p class="text-xl font-bold text-green-600">
                                    Rp
                                    {{ number_format(array_sum(array_map(function ($plan) {return $plan['count'] * $plan['price'];}, $subscriptionPlans)) / 1000000,1) }}M
                                </p>
                                <p class="text-xs text-gray-600">Pendapatan Bulanan</p>
                            </div>
                        </div>
                    </section>

                    <!-- New Subscriber Notifications -->
                    <section
                        class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-1">Berlangganan Baru</h3>
                                <p class="text-gray-600 text-sm">Barbershop yang baru bergabung</p>
                            </div>
                            <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                        </div>
                        <div class="space-y-2 max-h-60 overflow-y-auto custom-scrollbar">
                            @forelse($recentSubscriptions ?? [] as $sub)
                                @php
                                    $subColors = [
                                        'from-green-500 to-emerald-600',
                                        'from-blue-500 to-cyan-600',
                                        'from-purple-500 to-indigo-600',
                                        'from-orange-500 to-yellow-600',
                                        'from-pink-500 to-rose-600',
                                        'from-teal-500 to-green-600',
                                    ];
                                    $subColorIndex = abs(crc32($sub['name'] ?? 'default')) % count($subColors);
                                    $subAvatarColor = $subColors[$subColorIndex];
                                @endphp
                                <div
                                    class="flex items-center bg-gradient-to-r from-green-50 to-emerald-50 hover:from-green-100 hover:to-emerald-100 p-2 rounded-lg border border-green-200 transition-all duration-300 group">
                                    <div
                                        class="w-8 h-8 rounded-full flex-shrink-0 ring-2 ring-green-200 group-hover:ring-green-300 transition-all duration-300 bg-gradient-to-br {{ $subAvatarColor }} flex items-center justify-center">
                                        <span class="text-white font-bold text-xs">
                                            {{ strtoupper(substr($sub['name'] ?? 'NU', 0, 2)) }}
                                        </span>
                                    </div>
                                    <div class="ml-2 flex-1">
                                        <p class="text-gray-900 font-semibold text-xs leading-tight">
                                            {{ $sub['name'] ?? 'Barbershop Baru' }}</p>
                                        <div class="flex items-center space-x-1 mt-0.5">
                                            <span
                                                class="px-1.5 py-0.5 text-xs font-bold bg-green-100 text-green-700 rounded-full">
                                                {{ $sub['plan'] ?? 'Dasar' }}
                                            </span>
                                            <span
                                                class="text-xs text-gray-500">{{ $sub['time'] ?? '1 jam lalu' }}</span>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8">
                                    <div
                                        class="w-12 h-12 mx-auto mb-3 bg-gray-100 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 text-sm">Belum ada langganan baru</p>
                                </div>
                            @endforelse
                        </div>
                    </section>
                </div>
            </div>

            <!-- Package Details Modal -->
            <div id="packageModal"
                class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center z-50 opacity-0 invisible transition-all duration-300 p-4">
                <div class="bg-white rounded-2xl shadow-2xl max-w-5xl w-full max-h-[85vh] overflow-y-auto transform scale-95 transition-transform duration-300"
                    id="modalContent">
                    <!-- Modal Header -->
                    <div class="flex justify-between items-center p-6 border-b border-gray-200">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900">Detail Distribusi Paket</h2>
                            <p class="text-gray-600 text-sm mt-1">Informasi lengkap paket berlangganan</p>
                        </div>
                        <button onclick="closePackageModal()"
                            class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12">
                                </path>
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6">
                        <!-- Package Statistics -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div
                                class="bg-gradient-to-br from-blue-50 to-blue-100 p-4 rounded-xl border border-blue-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-blue-600 text-sm font-medium">Total Pelanggan</p>
                                        <p class="text-2xl font-bold text-blue-800" id="totalSubscribers">
                                            {{ array_sum(array_column($subscriptionPlans, 'count')) }}</p>
                                    </div>
                                    <div class="w-10 h-10 bg-blue-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="bg-gradient-to-br from-green-50 to-green-100 p-4 rounded-xl border border-green-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-green-600 text-sm font-medium">Pendapatan Bulanan</p>
                                        <p class="text-2xl font-bold text-green-800">Rp
                                            {{ number_format(array_sum(array_map(function ($plan) {return $plan['count'] * $plan['price'];}, $subscriptionPlans)) / 1000000,1) }}M
                                        </p>
                                    </div>
                                    <div class="w-10 h-10 bg-green-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="bg-gradient-to-br from-purple-50 to-purple-100 p-4 rounded-xl border border-purple-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-purple-600 text-sm font-medium">Harga Rata-rata</p>
                                        <p class="text-2xl font-bold text-purple-800">Rp
                                            {{ number_format(array_sum(array_map(function ($plan) {return $plan['count'] * $plan['price'];}, $subscriptionPlans)) / max(1, array_sum(array_column($subscriptionPlans, 'count'))),0,',','.') }}
                                        </p>
                                    </div>
                                    <div class="w-10 h-10 bg-purple-200 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Package Details Table -->
                        <div class="bg-gray-50 rounded-xl p-4">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">Rincian Paket Berlangganan</h3>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                @foreach ($subscriptionPlans as $plan)
                                    <div
                                        class="flex items-center justify-between bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                        <div class="flex items-center space-x-4">
                                            <div class="w-4 h-4 rounded-full flex-shrink-0"
                                                style="background-color: {{ $plan['color'] }}"></div>
                                            <div>
                                                <h4 class="font-bold text-gray-900">{{ $plan['name'] }}</h4>
                                                <p class="text-sm text-gray-600">Rp
                                                    {{ number_format($plan['price'], 0, ',', '.') }}/bulan</p>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-lg font-bold text-gray-900">{{ $plan['count'] }} pengguna
                                            </p>
                                            <p class="text-sm text-gray-600">{{ $plan['percentage'] }}% dari total</p>
                                            <p class="text-sm font-bold text-green-600 mt-1">Rp
                                                {{ number_format($plan['count'] * $plan['price'], 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Growth Projection -->
                        <div
                            class="mt-6 bg-gradient-to-r from-indigo-50 to-purple-50 p-4 rounded-xl border border-indigo-200">
                            <h3 class="text-lg font-bold text-indigo-900 mb-3">Proyeksi Pertumbuhan</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="text-center md:text-left">
                                    <p class="text-sm text-indigo-600">Target Bulan Depan</p>
                                    <p class="text-xl font-bold text-indigo-800">+{{ rand(5, 15) }}% pelanggan</p>
                                </div>
                                <div class="text-center md:text-left">
                                    <p class="text-sm text-indigo-600">Estimasi Pendapatan</p>
                                    <p class="text-xl font-bold text-indigo-800">Rp
                                        {{ number_format((array_sum(array_map(function ($plan) {return $plan['count'] * $plan['price'];}, $subscriptionPlans)) *1.1) /1000000,1) }}M
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex justify-end space-x-3 p-6 border-t border-gray-200 bg-gray-50 rounded-b-2xl">
                        <button onclick="closePackageModal()"
                            class="px-4 py-2 text-gray-600 hover:text-gray-800 font-semibold transition-colors">
                            Tutup
                        </button>
                        <button onclick="exportPackageData()"
                            class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
                            Ekspor Data
                        </button>
                    </div>
                </div>
            </div>

            <script>
                // Modal Functions
                function openPackageModal() {
                    const modal = document.getElementById('packageModal');
                    const modalContent = document.getElementById('modalContent');

                    modal.classList.remove('opacity-0', 'invisible');
                    modal.classList.add('opacity-100', 'visible');

                    setTimeout(() => {
                        modalContent.classList.remove('scale-95');
                        modalContent.classList.add('scale-100');
                    }, 10);

                    // Prevent body scroll
                    document.body.style.overflow = 'hidden';
                }

                function closePackageModal() {
                    const modal = document.getElementById('packageModal');
                    const modalContent = document.getElementById('modalContent');

                    modalContent.classList.remove('scale-100');
                    modalContent.classList.add('scale-95');

                    setTimeout(() => {
                        modal.classList.remove('opacity-100', 'visible');
                        modal.classList.add('opacity-0', 'invisible');
                    }, 200);

                    // Restore body scroll
                    document.body.style.overflow = 'auto';
                }

                // Close modal when clicking outside
                document.getElementById('packageModal').addEventListener('click', function(e) {
                    if (e.target === this) {
                        closePackageModal();
                    }
                });

                // Close modal with Escape key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        closePackageModal();
                    }
                });

                // Export Package Data Function
                function exportPackageData() {
                    const data = {
                        timestamp: new Date().toISOString(),
                        summary: {
                            totalSubscribers: {{ array_sum(array_column($subscriptionPlans, 'count')) }},
                            monthlyRevenue: {{ array_sum(array_map(function ($plan) {return $plan['count'] * $plan['price'];}, $subscriptionPlans)) }},
                            averagePrice: {{ array_sum(array_map(function ($plan) {return $plan['count'] * $plan['price'];}, $subscriptionPlans)) / max(1, array_sum(array_column($subscriptionPlans, 'count'))) }}
                        },
                        plans: @json($subscriptionPlans)
                    };

                    const csvContent = "data:text/csv;charset=utf-8," +
                        "Nama Paket,Harga,Pengguna,Persentase,Pendapatan\n" +
                        data.plans.map(plan =>
                            `"${plan.name}","Rp ${plan.price.toLocaleString('id-ID')}","${plan.count}","${plan.percentage}%","Rp ${(plan.count * plan.price).toLocaleString('id-ID')}"`
                        ).join("\n");

                    const encodedUri = encodeURI(csvContent);
                    const link = document.createElement("a");
                    link.setAttribute("href", encodedUri);
                    link.setAttribute("download", `distribusi_paket_${new Date().toISOString().split('T')[0]}.csv`);
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);

                    // Show success message
                    alert('Data berhasil diekspor!');
                }

                document.addEventListener('DOMContentLoaded', function() {
                    Chart.defaults.plugins.legend.display = true;
                    Chart.defaults.plugins.legend.position = 'top';
                    Chart.defaults.plugins.legend.align = 'start';
                    Chart.defaults.elements.point.radius = 6;
                    Chart.defaults.elements.point.hoverRadius = 8;
                    Chart.defaults.elements.line.tension = 0.4;

                    // Revenue Growth Chart
                    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
                    const revenueChart = new Chart(revenueCtx, {
                        type: 'line',
                        data: {
                            labels: @json($chartData['months']),
                            datasets: [{
                                label: 'Pendapatan (Juta Rupiah)',
                                data: @json($chartData['revenues']),
                                borderColor: '#10b981',
                                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                borderWidth: 4,
                                fill: true,
                                pointBackgroundColor: '#10b981',
                                pointBorderColor: '#ffffff',
                                pointBorderWidth: 3,
                                pointRadius: 8,
                                pointHoverBackgroundColor: '#059669',
                                pointHoverBorderColor: '#ffffff',
                                pointHoverBorderWidth: 4,
                                pointHoverRadius: 12
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: true,
                                    labels: {
                                        usePointStyle: true,
                                        font: {
                                            size: 14,
                                            weight: '600'
                                        },
                                        color: '#374151',
                                        padding: 20
                                    }
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                    titleColor: '#ffffff',
                                    bodyColor: '#ffffff',
                                    borderColor: '#10b981',
                                    borderWidth: 2,
                                    cornerRadius: 12,
                                    displayColors: true,
                                    titleFont: {
                                        size: 16,
                                        weight: 'bold'
                                    },
                                    bodyFont: {
                                        size: 14
                                    },
                                    padding: 12,
                                    callbacks: {
                                        label: function(context) {
                                            return 'Pendapatan: Rp ' + context.parsed.y.toLocaleString(
                                                'id-ID') + 'M';
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(209, 213, 219, 0.3)',
                                        borderDash: [3, 3]
                                    },
                                    ticks: {
                                        color: '#6b7280',
                                        font: {
                                            size: 12,
                                            weight: '500'
                                        },
                                        padding: 10,
                                        callback: function(value) {
                                            return 'Rp ' + value + 'M';
                                        }
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        color: '#6b7280',
                                        font: {
                                            size: 12,
                                            weight: '500'
                                        },
                                        padding: 10
                                    }
                                }
                            },
                            interaction: {
                                intersect: false,
                                mode: 'index'
                            },
                            elements: {
                                point: {
                                    hoverRadius: 12
                                }
                            },
                            animation: {
                                duration: 2500,
                                easing: 'easeInOutQuart'
                            }
                        }
                    });

                    // Subscription Distribution Chart
                    const subscriptionCtx = document.getElementById('subscriptionChart').getContext('2d');
                    const subscriptionChart = new Chart(subscriptionCtx, {
                        type: 'doughnut',
                        data: {
                            labels: @json(array_column($subscriptionPlans, 'name')),
                            datasets: [{
                                data: @json(array_column($subscriptionPlans, 'count')),
                                backgroundColor: @json(array_column($subscriptionPlans, 'color')),
                                borderColor: '#ffffff',
                                borderWidth: 2,
                                hoverBorderWidth: 3,
                                hoverOffset: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '65%',
                            plugins: {
                                legend: {
                                    display: true,
                                    position: 'bottom',
                                    labels: {
                                        usePointStyle: true,
                                        pointStyle: 'circle',
                                        font: {
                                            size: 10,
                                            weight: '600'
                                        },
                                        color: '#374151',
                                        padding: 10,
                                        generateLabels: function(chart) {
                                            const data = chart.data;
                                            if (data.labels.length && data.datasets.length) {
                                                return data.labels.map((label, index) => {
                                                    const value = data.datasets[0].data[index];
                                                    const total = data.datasets[0].data.reduce((a, b) =>
                                                        a + b, 0);
                                                    const percentage = total > 0 ? ((value / total) *
                                                        100).toFixed(0) : 0;
                                                    return {
                                                        text: `${label} (${percentage}%)`,
                                                        fillStyle: data.datasets[0].backgroundColor[
                                                            index],
                                                        hidden: false,
                                                        index: index
                                                    };
                                                });
                                            }
                                            return [];
                                        }
                                    }
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                    titleColor: '#ffffff',
                                    bodyColor: '#ffffff',
                                    borderColor: '#d1d5db',
                                    borderWidth: 1,
                                    cornerRadius: 8,
                                    callbacks: {
                                        label: function(context) {
                                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                            const percentage = total > 0 ? ((context.parsed / total) * 100)
                                                .toFixed(1) : 0;
                                            return `${context.label}: ${context.parsed} pengguna (${percentage}%)`;
                                        }
                                    }
                                }
                            },
                            animation: {
                                animateRotate: true,
                                animateScale: true,
                                duration: 2000,
                                easing: 'easeInOutQuart'
                            },
                            interaction: {
                                intersect: false
                            }
                        }
                    });

                    // Add center text for doughnut chart
                    Chart.register({
                        id: 'centerText',
                        beforeDraw(chart) {
                            if (chart.config.type === 'doughnut') {
                                const {
                                    ctx,
                                    chartArea: {
                                        width,
                                        height
                                    }
                                } = chart;
                                ctx.save();
                                ctx.font = 'bold 16px Arial';
                                ctx.fillStyle = '#374151';
                                ctx.textAlign = 'center';
                                ctx.textBaseline = 'middle';
                                const total = chart.data.datasets[0].data.reduce((a, b) => a + b, 0);

                                ctx.font = '12px Arial';
                                ctx.fillStyle = '#6b7280';

                                ctx.restore();
                            }
                        }
                    });

                    // Add hover animations for cards
                    document.querySelectorAll('.group').forEach(card => {
                        card.addEventListener('mouseenter', function() {
                            this.style.transform = 'translateY(-2px)';
                        });
                        card.addEventListener('mouseleave', function() {
                            this.style.transform = 'translateY(0)';
                        });
                    });

                    // Auto-refresh charts every 30 seconds
                    setInterval(() => {
                        if (typeof Livewire !== 'undefined') {
                            Livewire.emit('refreshChartData');
                        }
                    }, 30000);
                });
            </script>
        </div>
    </main>
</div>
