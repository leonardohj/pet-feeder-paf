                @extends('layouts.auth')

                @section('body')
                    <x-header2></x-header2>
                    <div class="flex-1 flex">
                        <div class="flex-1 min-h-0 bg-white ">
                            <div class="bg-gray-50">
                                <div class="bg-white w-full rounded-tr-full h-5"></div>
                            </div>
                            <div class="flex justify-center items-center py-10">
                                <form action="{{ route('register') }}" method="POST" class="w-full max-w-2xl">
                                    @csrf
                                    <div class="px-6 flex flex-col justify-center items-center gap-4">
                                        <div class="text-3xl font-semibold w-full mb-5 text-left">Registo</div>
                                        <x-input name="name" label="Nome" type="text"
                                            placeholder="Enter your username" autocomplete="name" />
                                        <x-input name="email" label="Email" type="email"
                                            placeholder="Enter your email address" autocomplete="email" />
                                        <x-input name="password" label="Palavra passe" type="password"
                                            placeholder="Enter your password" autocomplete="new-password" />
                                        <x-input name="password_confirmation" label="Confirmar palavra passe"
                                            type="password" placeholder="Confirm your password"
                                            autocomplete="new-password" />

                                        <button type="submit"
                                            class="text-white py-2 px-3 bg-gray-900 w-full rounded-full cursor-pointer text-center mt-5 transition hover:bg-gray-800">
                                            Registo
                                        </button>

                                        <div class="text-sm text-gray-700 mt-3 text-center">
                                            Já tens uma conta? <a href="{{ route('login') }}"
                                                class="underline text-gray-900 hover:text-gray-700">Entrar</a>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div class="hidden lg:flex flex-1 min-h-0 bg-gray-50 justify-center items-center flex-col">
                            <div class="">
                                <img src="{{ asset('img/pt/register.png') }}" alt="">
                            </div>
                            <div class="flex-1 w-full min-h-0 bg-gray-200">
                            </div>
                        </div>
                    </div>
                @endsection
