<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>SeeCut DEV{{ isset($title) ? ' - ' . $title : '' }}</title>

{{-- <link rel="icon" href="{{ asset('assets/images/luckycat-letter.png') }}" type="image/x-icon"> --}}

@vite(['resources/css/app.css', 'resources/js/app.js'])
