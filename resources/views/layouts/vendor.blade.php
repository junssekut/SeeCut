<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SeeCut {{ isset($title) ? ' - ' . $title : '' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @switch(Route::currentRouteName())
        @case('style')
            @vite('resources/css/stylePage.css')
        @break

        @case('login')
            @vite('resources/css/register.css')
        @break
    @endswitch

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    @stack('styles')
</head>

<body class="font-Poppins min-h-screen min-w-screen bg-cover bg-bottom bg-no-repeat bg-white">
    @if (!Request::is(''))
        @persist('topbar')
        <livewire:topbar-vendor />
        @endpersist()
    @endif
    <div class="flex flex-col max-w-full h-full">
        {{ $slot }}
    </div>
</body>

</html>
