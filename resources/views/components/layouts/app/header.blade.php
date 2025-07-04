<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="font-Poppins min-h-screen min-w-screen bg-cover bg-bottom bg-no-repeat bg-[#0C0C0C]">
    @if (!Request::is('masuksekarang'))
        @persist('topbar')
        <livewire:topbar />
        @endpersist()
    @endif
    <div class="flex flex-col max-w-full h-screen">
        {{ $slot }}
    </div>
    @if (!Request::is('masuksekarang'))
        @persist('footer')
        <livewire:footer />
        @endpersist()
    @endif
</body>

</html>
