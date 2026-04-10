@extends('layouts.app')

@section('breadcrumb')
    <x-breadcrumbs class="mb-4" :links="[
        __('breadcrumbs.feeders') => route('feeder.index'),
        $feeder->name => '',
    ]" />
@endsection

@section('body')
    <div class="">
        <x-card :title="$feeder->name" titleSize="3xl">

            <div class="flex flex-wrap items-center justify-between gap-4 pb-6 border-b border-gray-100">
                <div class="flex items-center gap-2">
                    <span class="text-sm font-medium text-gray-700">Status:</span>
                    @if ($feeder->status)
                        <span
                            class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold uppercase">
                            <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                            Active
                        </span>
                    @else
                        <span
                            class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-200 text-gray-700 text-xs font-bold uppercase">
                            <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                            Offline
                        </span>
                    @endif
                </div>
                

            </div>
            <x-button>
                <a href="{{ route('schedule', ['search' => $feeder->name]) }}" class="flex items-center justify-center gap-2"> <x-mdi-calendar-blank-outline class="h-5 w-5"></x-mdi-calendar-blank-outline> View Schedules <x-mdi-arrow-right class="h-5 w-5"></x-mdi-arrow-left>
                </a>
            </x-button>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-3">
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Device Code</label>
                        <p class="mt-1 text-gray-800 font-mono bg-gray-100 px-2 py-1 rounded inline-block">
                            {{ $feeder->code }}
                        </p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Pet Type</label>
                        <p class="mt-1 text-gray-800 flex items-center capitalize">
                            <span class="mr-2 text-xl">
                                {{ $feeder->pet_type == 'cat' ? '🐱' : ($feeder->pet_type == 'dog' ? '🐶' : '🐾') }}
                            </span>
                            {{ $feeder->pet_type }}
                        </p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Last Feeding</label>
                        <p class="mt-1 text-gray-800">
                            @if ($feeder->last_fed_at)
                                {{ $feeder->last_fed_at->diffForHumans() }}
                                <span
                                    class="block text-xs text-gray-500">{{ $feeder->last_fed_at->format('M d, Y H:i') }}</span>
                            @else
                                <span class="text-gray-500 italic">No activity recorded</span>
                            @endif
                        </p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Device Token</label>
                        <p class="mt-1 text-gray-800 text-xs truncate" title="{{ $feeder->device_token }}">
                            {{ Str::limit($feeder->device_token, 30) }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 flex justify-between items-center text-xs text-gray-500">
                <p>Added on {{ $feeder->created_at->format('F j, Y') }}</p>
                <p>ID: #{{ $feeder->id }}</p>
            </div>

        </x-card>
        <div class="flex justify-center items-center px-3 sm:px-5">

            <div class="bg-white max-w-3xl w-full rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

                <div class="px-6 py-2 flex justify-between items-center bg-gray-700">
                    <h3 class="font-bold text-white uppercase text-xs tracking-wider">
                        {{ __('dashboard.recent_history') }}
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left">

                        <thead>
                            <tr class="text-gray-800 text-xs text-nowrap uppercase bg-gray-300">
                                <th class="px-6 py-1.5 font-medium">
                                    {{ __('dashboard.date_time') }}
                                </th>
                                <th class="px-6 py-1 font-medium text-right">
                                    {{ __('dashboard.dose') }}
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-50 text-gray-600">

                            @forelse($feeder->feedingLogs(3) as $log)
                                <tr>
                                    <td class="px-6 py-2">
                                        <span class="px-2 py-1 bg-indigo-50 text-gray-400 text-xs rounded-md">
                                            {{ $log->date->format('d/m/Y') }}
                                        </span>
                                        <span class="px-2 py-1 bg-indigo-50 text-gray-400 text-xs rounded-md">
                                            {{ $log->hour }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-2">
                                        <span class="px-2 py-1 bg-indigo-50 text-gray-400 text-xs rounded-md">
                                            {{ $log->quantity }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="3" class="px-6 py-2">
                                        <span class="px-2 py-1 text-gray-400 text-xs md:text-base rounded-md">
                                            {{ __('dashboard.no_logs_yet') }}
                                        </span>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
