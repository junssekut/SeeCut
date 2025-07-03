<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
    {{-- @if (!Request::is('masuksekarang') && !Request::is('informasi'))
        @persist('footer')
        <livewire:footer-vendor />
        @endpersist()
    @endif --}}

</body>

</html>
