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
                <form action="{{ route('register') }}" method="POST" class="w-full max-w-2xl">
                    @csrf

                    <div class="px-6 flex-1 flex flex-col justify-center items-center gap-4">
                        <div class="text-3xl font-semibold w-full mb-5 text-left">{{ __('auth.register')}}</div>

                        <x-input
                            name="name"
                            :label="__('auth.username')"
                            type="text"
                            :placeholder="__('auth.enter_username')"
                            autocomplete="name"
                        />

                        <x-input
                            name="email"
                            :label="__('auth.email')"
                            type="email"
                            :placeholder="__('auth.enter_email')"
                            autocomplete="email"
                        />

                        <x-input
                            name="password"
                            :label="__('auth.password')"
                            type="password"
                            :placeholder="__('auth.enter_password')"
                            autocomplete="new-password"
                        />

                        <x-input
                            name="password_confirmation"
                            :label="__('auth.confirm_password')"
                            type="password"
                            :placeholder="__('auth.enter_confirm_password')"
                            autocomplete="new-password"
                        />

                        <button
                            type="submit"
                            class="text-white py-2 px-3 bg-gray-900 w-full rounded-full cursor-pointer text-center mt-5 transition hover:bg-gray-800"
                        >
                            {{ __('auth.register') }}
                        </button>

                        <div class="text-sm text-gray-700 mt-3 text-center">
                            {{ __('auth.already_has_account') }}
                            <a href="{{ route('login') }}" class="underline text-gray-900 hover:text-gray-700">
                                {{ __('auth.login')}}
                            </a>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        <div class="hidden lg:flex flex-1 min-h-0 bg-gray-50 flex-col">
            <div class="flex justify-center items-center">
                <img src="{{ asset('img/' . App::getLocale(). '/register.png') }}" alt="">
            </div>

            <div id="gray-thing" class="flex-1 w-full bg-gray-200"></div>
        </div>
    </div>
    </div>
@endsection