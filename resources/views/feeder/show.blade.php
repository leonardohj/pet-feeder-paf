@extends('layouts.app')

@section('breadcrumb')
    <x-breadcrumbs class="mb-4" :links="[
        __('breadcrumbs.feeders') => route('feeder.index'),
        $feeder->name => '',
    ]" />
@endsection

@section('body')
    <div class="space-y-4">

        <x-card titleSize="3xl">
            @if ($way === 'edit')
                <form action="{{ route('feeder.update', ['feeder_id' => $feeder->id]) }}" method="POST">
                    @csrf
            @endif
            <x-show-inputs type="title" :way="$way" name="name" :label="__('feeder.name')"
                :value="$feeder->name"></x-show-inputs>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                <div class="col-span-2 ">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Status</label>
                    <div class="mt-1">
                        @if ($feeder->status)
                            <span
                                class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold uppercase w-fit">
                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                Active
                            </span>
                        @else
                            <span
                                class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-200 text-gray-600 text-xs font-bold uppercase w-fit">
                                <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                Offline
                            </span>
                        @endif
                    </div>
                </div>
                <x-show-inputs :admin="true" :way="$way" name="device_code" :label="__('feeder.device_code')"
                    :value="$feeder->code"></x-show-inputs>

                <x-show-inputs name="pet_type" :label="__('feeder.pet_type')" :value="$feeder->pet_type"></x-show-inputs>
                <x-show-inputs name="last_fed_at" :label="__('feeder.last_fed_at')" :value="$feeder->last_fed_at"></x-show-inputs>
                <x-show-inputs name="associated_at" :label="__('feeder.associated_at')" :value="$feeder->updated_at"></x-show-inputs>
                @if (auth()->user()->getRole() == 'admin')
                    <x-show-inputs :way="$way" name="device_token" :label="__('feeder.device_token')"
                        :value="$feeder->device_token"></x-show-inputs>

                @endif
            </div>
            <div class="mt-2">
                @if ($way === 'show')
                    <a href="{{ route('feeder.edit', ['feeder_id' => $feeder->id]) }}">
                        <x-button>{{ __('feeder.edit_feeder') }}</x-button>
                    </a>
                    @else
                    <x-button type="submit">{{ __('feeder.complete') }}</x-button>

                    @endif

            </div>
            @if ($way === 'edit')
                </form>
            @endif



        </x-card>

        <div class="max-w-3xl mx-auto bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

            <div class="px-6 py-2 bg-gray-700">
                <h3 class="font-bold text-white uppercase text-xs tracking-wider">
                    {{ __('dashboard.recent_history') }}
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-gray-600 text-xs uppercase bg-gray-100">
                            <th class="px-6 py-2 font-medium">{{ __('dashboard.date_time') }}</th>
                            <th class="px-6 py-2 font-medium text-right">{{ __('dashboard.dose') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 text-gray-600">
                        @forelse($feeder->feedingLogs(3) as $log)
                            <tr>
                                <td class="px-6 py-2 space-x-1">
                                    <span class="px-2 py-1 bg-indigo-50 text-gray-400 text-xs rounded-md">
                                        {{ $log->date->format('d/m/Y') }}
                                    </span>
                                    <span class="px-2 py-1 bg-indigo-50 text-gray-400 text-xs rounded-md">
                                        {{ $log->hour }}
                                    </span>
                                </td>
                                <td class="px-6 py-2 text-right">
                                    <span class="px-2 py-1 bg-indigo-50 text-gray-400 text-xs rounded-md">
                                        {{ $log->quantity }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-gray-400 text-sm italic">
                                    {{ __('dashboard.no_logs_yet') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>
@endsection
