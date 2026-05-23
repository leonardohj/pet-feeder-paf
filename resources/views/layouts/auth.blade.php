<!DOCTYPE html>
<html lang="en" x-data="layout()" x-init="init()">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Pet Feeder</title>

    {{-- Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Extra scripts --}}
    @yield('scripts')

    {{-- Favicons --}}
    <link rel="icon" type="image/png" href="{{ asset('favicon-96x96.png') }}" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}" />
    <meta name="apple-mobile-web-app-title" content="PetFeeder" />
    <link rel="manifest" href="{{ asset('site.webmanifest') }}" />

    {{-- Alpine --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>

@php
    $user = Auth::user();
    $currentUrl = rtrim(url()->current(), '/');
@endphp

<body class="h-full m-0 flex flex-col">
    <main class="flex-1 flex flex-col overflow-y-hidden">
        @yield('body')
    </main>
</body>

</html>