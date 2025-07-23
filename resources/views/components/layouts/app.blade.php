<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'SeeCut' }}</title>

    @vite(['resources/css/app.css', 'resources/css/toastr-custom.css', 'resources/js/app.js'])

    @switch(Route::currentRouteName())
        @case('style')
            @vite('resources/css/stylePage.css')
        @break

        @case('login')
            @vite('resources/css/register.css')
        @break
    @endswitch

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    @stack('styles')

    @livewireStyles
</head>

<body class="font-Poppins min-h-screen min-w-screen bg-cover bg-bottom bg-no-repeat bg-[#0C0C0C]">
    @if (!str_contains(Route::currentRouteName(), 'login'))
        @persist('navbar')
        <livewire:navigation.navbar />
        @endpersist()
    @endif

    <div class="flex flex-col max-w-full h-full">
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main>
            {{ $slot }}
        </main>
    </div>

    @if (!str_contains(Route::currentRouteName(), 'login'))
        @persist('footer')
        <livewire:navigation.footer />
        @endpersist()
    @endif

    @livewireScripts
</body>

<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

@stack('scripts')

</html>
