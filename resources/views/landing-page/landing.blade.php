<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    @yield('scripts')
    <title>paf</title>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
</head>
<body>
    <!-- Header -->
    <div class="border-b border-gray-300">
        <x-header2/>
    </div>

    <!-- Hero Section -->
    <section class="flex flex-col items-center text-center px-4 sm:px-8 md:px-16 lg:px-32 mt-16 lg:mt-20 space-y-6">
        <img src="{{ asset('img/logo_paf.png') }}" alt="PAF Logo" class="h-12 lg:h-16">
        
        <h1 class="text-3xl sm:text-4xl lg:text-6xl font-bold text-gray-900 leading-tight">
            Onde a tecnologia e os cuidados com animais de estimação se unem
        </h1>

        <p class="text-gray-600 sm:text-lg lg:text-xl max-w-4xl mx-auto">
           O Pet Feeder ajuda os donos de animais de estimação a criar horários de alimentação convenientes que podem ser personalizados, geridos e monitorizados. Ao combinar uma aplicação web com um dispositivo automatizado, permite aos donos garantir que os seus animais de estimação são alimentados a horas e mantêm uma rotina saudável.        </p>

        <div class="flex flex-col sm:flex-row gap-4 mt-4">
            <div class="font-semibold cursor-pointer rounded-full transition-all duration-300 ease-in-out text-center border hover:border-gray-600 hover:bg-gray-100 border-gray-200 py-3 text-gray-900 px-5 bg-white">
                Compra o nosso produto
            </div>
            <div class=" font-semibold cursor-pointer rounded-full text-center transition-all duration-300 ease-in-out bg-gray-900 px-5 py-3 text-white hover:bg-gray-800">
                 Entrar
            </div>
        </div>
    </section>
     <section class="mt-16 lg:mt-32 px-4 sm:px-8 md:px-16 lg:px-32 flex flex-col items-center">
        <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 text-center">
            Introducing our Pet Feeder Smart System
        </h2>

        <p class="text-gray-600 sm:text-lg text-center max-w-3xl">
            Effortlessly schedule, monitor, and manage your pet’s meals with a smart device and web app. Control feeding times via Wi-Fi, get real-time updates, and customize routines to suit your pet.
        </p>
        <div class="w-full flex gap-10 flex-col lg:flex-row justify-center items-center mt-10 text-center">
            <div class="h-100 w-full flex flex-col max-w-xl">
                <div class="rounded-t-2xl h-50 bg-black">
                    <img src="" alt="img1">
                </div>
                <div class="rounded-b-2xl bg-gray-100 h-50 flex items-center flex-col gap-3">
                    <div class="text-black text-2xl w-full max-w-sm mt-3">
                        Schedule control
                    </div>
                    <div class="text-gray-500 text-lg max-w-sm">
                        Program your pet’s meals effortlessly and never miss a feeding again.                    
                    </div>
                    <div class="font-semibold flex justify-center items-center gap-1.5">
                        <div>Try now</div> <div class="flex justify-center items-center h-5 w-5 bg-gray-900 border-1 rounded-full border-gray-900"><x-radix-arrow-top-right class="h-6 w-6 font-bold text-white p-0.5"/></div>
                    </div>
                </div>
            </div>
            <div class="h-100 w-full flex flex-col max-w-xl">
                <div class="rounded-t-2xl h-50 bg-black">
                    <img src="" alt="img1">
                </div>
                <div class="rounded-b-2xl bg-gray-100 h-50 flex items-center flex-col gap-3">
                    <div class="text-black text-2xl w-full max-w-sm mt-3">
                        Multiple Pets
                    </div>
                    <div class="text-gray-500 text-lg max-w-sm">
                        Manage multiple feeders and pets easily from a single app.
                    </div>
                    <div class="font-semibold flex justify-center items-center gap-1.5">
                        <div>Try now</div> <div class="flex justify-center items-center h-5 w-5 bg-gray-900 border-1 rounded-full border-gray-900"><x-radix-arrow-top-right class="h-6 w-6 font-bold text-white p-0.5"/></div>
                    </div>
                </div>
            </div>
        </div>
        </section>
</div>
</html>