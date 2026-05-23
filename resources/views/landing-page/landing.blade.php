<!DOCTYPE html>
<html lang="pt">

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
        <x-header2 />
    </div>

    <!-- Hero Section -->
    <section class="flex flex-col items-center text-center px-4 sm:px-8 md:px-16 lg:px-32 mt-16 lg:mt-20 space-y-6">
        <img src="{{ asset('img/logo_paf.png') }}" alt="PAF Logo" class="h-12 lg:h-16">

        <h1 class="text-3xl sm:text-4xl lg:text-6xl font-bold text-gray-900 leading-tight">
            {{ __('landing-page.hero_title') }}
        </h1>

        <p class="text-gray-600 sm:text-lg lg:text-xl max-w-4xl mx-auto">
            {{ __('landing-page.hero_description') }}
        </p>

        <div class="flex flex-col sm:flex-row gap-4 mt-4">
            <div class="font-semibold cursor-pointer rounded-full transition-all duration-300 ease-in-out text-center border hover:border-gray-600 hover:bg-gray-100 border-gray-200 py-3 text-gray-900 px-5 bg-white">
                {{ __('landing-page.buy_product') }}
            </div>

            <div class="font-semibold cursor-pointer rounded-full text-center transition-all duration-300 ease-in-out bg-gray-900 px-5 py-3 text-white hover:bg-gray-800">
                {{ __('landing-page.login') }}
            </div>
        </div>
    </section>

    {{-- 
    <section class="mt-16 lg:mt-32 px-4 sm:px-8 md:px-16 lg:px-32 flex flex-col items-center">
        <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 text-center">
            {{ __('landing-page.introducing_title') }}
        </h2>

        <p class="text-gray-600 sm:text-lg text-center max-w-3xl">
            {{ __('landing-page.introducing_description') }}
        </p>

        <div class="w-full flex gap-10 flex-col lg:flex-row justify-center items-center mt-10 text-center">

            <div class="h-100 w-full flex flex-col max-w-xl">
                <div class="rounded-t-2xl h-50 bg-black">
                    <img src="" alt="img1">
                </div>

                <div class="rounded-b-2xl bg-gray-100 h-50 flex items-center flex-col gap-3">
                    <div class="text-black text-2xl w-full max-w-sm mt-3">
                        {{ __('landing-page.schedule_control_title') }}
                    </div>

                    <div class="text-gray-500 text-lg max-w-sm">
                        {{ __('landing-page.schedule_control_description') }}
                    </div>

                    <div class="font-semibold flex justify-center items-center gap-1.5">
                        <div>{{ __('landing-page.try_now') }}</div>

                        <div class="flex justify-center items-center h-5 w-5 bg-gray-900 border-1 rounded-full border-gray-900">
                            <x-radix-arrow-top-right class="h-6 w-6 font-bold text-white p-0.5"/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="h-100 w-full flex flex-col max-w-xl">
                <div class="rounded-t-2xl h-50 bg-black">
                    <img src="" alt="img1">
                </div>

                <div class="rounded-b-2xl bg-gray-100 h-50 flex items-center flex-col gap-3">
                    <div class="text-black text-2xl w-full max-w-sm mt-3">
                        {{ __('landing-page.multiple_pets_title') }}
                    </div>

                    <div class="text-gray-500 text-lg max-w-sm">
                        {{ __('landing-page.multiple_pets_description') }}
                    </div>

                    <div class="font-semibold flex justify-center items-center gap-1.5">
                        <div>{{ __('landing-page.try_now') }}</div>

                        <div class="flex justify-center items-center h-5 w-5 bg-gray-900 border-1 rounded-full border-gray-900">
                            <x-radix-arrow-top-right class="h-6 w-6 font-bold text-white p-0.5"/>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    --}}
</body>

</html>