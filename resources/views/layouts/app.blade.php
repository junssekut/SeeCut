<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SeeCut')</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/logo-app.png') }}" type="image/png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @switch(Route::currentRouteName())
        @case('style.index')
            @vite('resources/css/stylePage.css')
        @break

        @case('login')
            @vite('resources/css/register.css')
        @break
    @endswitch

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    @stack('styles')

    @livewireStyles
</head>

<body class="font-Poppins min-h-screen min-w-screen bg-cover bg-bottom bg-no-repeat bg-[#0A0A0A]">
    @php
        $currentRoute = Route::currentRouteName();
        $is404 =
            request()->is('*') &&
            view()->exists('errors.404') &&
            (app('router')->current() === null || str_contains(request()->url(), '404'));
        $isErrorPage = str_contains($currentRoute ?? '', 'error') || $is404 || request()->route() === null;
    @endphp

    @if (!str_contains($currentRoute ?? '', 'login') && !$isErrorPage)
        @persist('navbar')
        <livewire:navigation.navbar />
        @endpersist()
    @endif

    <div class="flex flex-col max-w-full h-full">
        @isset($slot)
            {{ $slot }}
        @endisset
        @yield('content')
    </div>

    @if (!str_contains($currentRoute ?? '', 'login') && !str_contains($currentRoute ?? '', 'dashboard') && !$isErrorPage)
        @persist('footer')
        <livewire:navigation.footer />
        @endpersist()
    @endif

    @livewireScripts
</body>

<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

<script>
    // Initialize Notyf
    const notyf = new Notyf({
        duration: 4000,
        position: {
            x: 'right',
            y: 'bottom',
        },
        ripple: true,
        types: [{
                type: 'success',
                background: '#10B981',
                icon: {
                    className: 'material-icons',
                    tagName: 'i',
                    text: 'check_circle'
                }
            },
            {
                type: 'error',
                background: '#EF4444',
                icon: {
                    className: 'material-icons',
                    tagName: 'i',
                    text: 'error'
                }
            }
        ]
    });

    // Make notyf available globally
    window.notyf = notyf;
</script>

@stack('scripts')



</html>
