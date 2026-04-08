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

<body class="h-full m-0 flex flex-col">
    <main class="flex-1 flex flex-col">
        @yield('body')
    </main>
</body>
</html>
