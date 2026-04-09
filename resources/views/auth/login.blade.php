@extends('layouts.auth')

@section('body')
<div class="flex flex-col min-h-screen overflow-hidden">

    <!-- Header -->
    <x-header2></x-header2>

    <!-- Main content row -->
    <div class="flex flex-1 min-h-0">

        <!-- Form column -->
        <div class="flex-1 flex flex-col min-h-0 bg-white">
            <div class="bg-gray-50">
                <div class="bg-white w-full rounded-tr-full h-5"></div>
            </div>

            <div class="flex-1 flex justify-center py-10">
                <form action="{{ route('login') }}" method="POST" class="w-full max-w-2xl px-6">
                    @csrf
                    <div class="flex flex-col justify-center items-center gap-4">
                        <div class="text-3xl font-semibold w-full mb-5 text-left">
                            {{ __('auth.login') }}
                        </div>

                        <x-input name="email" :label="__('auth.email')" type="email" :placeholder="__('auth.enter_email')"/>
                        <x-input name="password" :label="__('auth.password')" type="password" :placeholder="__('auth.enter_password')"/>

                        @if ($errors->has('credentials'))
                        <div class="font-semibold w-full text-left">
                            <p class="text-red-500 text-sm text-left">{{ $errors->first('credentials') }}</p>
                        </div>
                        @endif

                        <button 
                            type="submit"
                            class="text-white py-2 px-3 bg-gray-900 w-full rounded-full cursor-pointer text-center mt-5 hover:bg-gray-800 transition-all duration-300"
                        >
                            {{__('auth.login')}}
                        </button>

                        <div class="text-sm text-gray-700 mt-3 text-center">
                            {{ __('auth.doesnt_have_account') }} <a href="{{ route('register') }}" class="underline">{{ __('auth.do_register') }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Image column -->
        <div class="hidden lg:flex flex-1 min-h-0 bg-gray-50 justify-center items-center flex-col">
            <div>
                <img src="{{ asset('img/'. App::getLocale() .'/login.png') }}" alt="">
            </div>
            <div class="flex-1 w-full min-h-0 bg-gray-200"></div>
        </div>

    </div>
</div>
@endsection