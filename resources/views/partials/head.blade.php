<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>SeeCut DEV{{ isset($title) ? ' - ' . $title : '' }}</title>
{{-- <title>{{ Route::currentRouteName()}}</title> --}}

{{-- <link rel="icon" href="{{ asset('assets/images/luckycat-letter.png') }}" type="image/x-icon"> --}}

@vite(['resources/css/app.css', 'resources/js/app.js'])


@switch(Route::currentRouteName())
    @case('style')
        @vite('resources/css/stylePage.css')
        @break

    @case('masuksekarang')
        @vite('resources/css/register.css')
        @break

        
@endswitch
<!-- SwiperJS CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />