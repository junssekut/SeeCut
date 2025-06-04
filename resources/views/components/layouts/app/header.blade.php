<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body class="font-Poppins min-h-screen min-w-screen bg-cover bg-bottom bg-no-repeat bg-[#0C0C0C]">
    @persist('topbar')
    <livewire:topbar />
    @endpersist()
    <div class="flex flex-col max-w-full h-full">
        {{ $slot }}
    </div>
    @persist('footer')
    <livewire:footer />
    @endpersist()
</body>

</html>
