<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    @yield('scripts')
    <title>paf</title>
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
<!DOCTYPE html>
<html x-data="layout()" x-init="init()">



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>paf</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('scripts')

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>
