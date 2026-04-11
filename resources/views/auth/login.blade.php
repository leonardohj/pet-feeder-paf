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

                        <a href="{{ url('/auth/google/redirect')}}" class="gsi-material-button w-full">
                            <div class="gsi-material-button-state"></div>
                            <div class="gsi-material-button-content-wrapper">
                              <div class="gsi-material-button-icon">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" xmlns:xlink="http://www.w3.org/1999/xlink" style="display: block;">
                                  <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path>
                                  <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path>
                                  <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path>
                                  <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path>
                                  <path fill="none" d="M0 0h48v48H0z"></path>
                                </svg>
                              </div>
                              <span class="gsi-material-button-contents">{{ __('auth.login_google') }}</span>
                              <span style="display: none;">{{ __('auth.login_google') }}</span>
                            </div>
                        </a>

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