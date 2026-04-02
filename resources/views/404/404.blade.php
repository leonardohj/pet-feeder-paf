<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>404 - Page Not Found</title>
    @vite('resources/css/app.css') {{-- Make sure Tailwind is loaded --}}
</head>
<body class="flex items-center justify-center bg-gray-50">
    <div class="text-center">
        <img src="{{ asset('img/404.png') }}" alt="404 - Page Not Found" class="mx-auto w-full max-w-xl mb-6">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Oops! Page Not Found</h1>
        <p class="text-gray-500 mb-6">The page you’re looking for doesn’t exist or has been moved.</p>
        <a href="{{ url('/') }}" class="bg-black hover:bg-gray-800 transition-colors  w-full text-white font-medium px-6 py-3 rounded-xl">
           Go Back Home
        </a>
    </div>
</body>
</html>
