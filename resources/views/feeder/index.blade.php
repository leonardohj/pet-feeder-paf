@extends('layouts.app')
@section('breadcrumb')
    <x-breadcrumbs class="mb-4" :links="[
        __('breadcrumbs.feeders') => route('feeder.index'),
    ]" />
@endsection
@section('body')
    <div class="px-5 py-2 w-full">
        <div class="flex w-full flex-wrap flex-row justify-center gap-3">

            @if ($feeders->isEmpty())
                <!-- No feeders -->
                <x-no-feeders title="{{ __('feeder.no_feeder_associated_yet') }}"
                    text="{{ __('feeder.associate_feeder_monotorize') }}" click="$dispatch('open-modal-associate-feeder')"
                    button_text="{{ __('feeder.associate_feeder') }}"></x-no-feeders>
            @else
                <!-- Feeders list -->
                <div class="flex w-full flex-wrap flex-row justify-center md:justify-start gap-8">
                    @foreach ($feeders as $feeder)
                        <div
                            class="group relative flex flex-col w-full max-w-sm bg-white rounded-3xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 overflow-hidden">

                            <div class="absolute top-4 right-4 z-10">
                                <div
                                    class="flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/90 backdrop-blur-sm shadow-sm border border-gray-100">
                                    <div
                                        class="{{ $feeder->status ? 'bg-green-500' : 'bg-red-500' }} h-2.5 w-2.5 rounded-full animate-pulse">
                                    </div>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-gray-600">
                                        {{ $feeder->status ? 'Online' : 'Offline' }}
                                    </span>
                                </div>
                            </div>

                            <div class="relative h-56 w-full bg-gray-50 overflow-hidden">
                                <img src="{{ asset('img/img.webp') }}" alt="{{ $feeder->name }}"
                                    class="h-full w-full object-contain p-4 transition-transform duration-500 ease-out">
                                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/5 to-transparent"></div>
                            </div>

                            <div class="p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-800 transition-colors">
                                            {{ $feeder->name }}
                                        </h3>
                                        <p class="text-xs text-gray-400 mt-1 flex items-center gap-1">
                                            <x-mdi-clock-outline class="h-3 w-3" />
                                            {{ __('feeder.last_fed_at') }}:
                                            {{ $feeder->last_fed_at?->format('d/m/Y H:i') ?? __('feeder.never') }}
                                        </p>
                                    </div>
                                </div>

                                <a href="{{ route('feeder.show', ['feeder_id' => $feeder->id]) }}"
                                    class="mt-2 flex items-center justify-between w-full px-5 py-3 bg-gray-50 hover:bg-gray-800 rounded-2xl text-gray-700 hover:text-white transition-all duration-300 font-semibold">
                                    <span class="text-sm">{{ __('feeder.manage_feeder') }}</span>
                                    <x-radix-arrow-right
                                        class="h-5 w-5 transform group-hover:translate-x-1 transition-transform" />
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>


@endsection
