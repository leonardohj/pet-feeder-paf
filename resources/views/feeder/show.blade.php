@extends('layouts.app')

@section('breadcrumb')
<x-breadcrumbs class="mb-4" :links="[
    __('breadcrumbs.feeders') => route('feeder.index'),
    $feeder->name => ''
]" />
@endsection

@section('body')
<div class="px-5 py-6 w-full flex justify-center">
    <div class="w-full max-w-3xl bg-white rounded-2xl shadow-md p-6 flex flex-col gap-6">

        <!-- Feeder Header -->
        <div class="flex flex-col items-center gap-4">
            <img src="{{ asset('img/en/placeholder.jpg') }}" alt="Feeder Image" class="w-full max-h-60 rounded-xl object-cover">
            <div class="text-2xl font-semibold text-gray-800">{{ $feeder->name }}</div>
            <div class="flex gap-6 text-gray-600 font-medium">
                <div><span class="font-semibold">ID:</span> {{ $feeder->id }}</div>
                <div class="flex items-center gap-2">
                    <span class="font-semibold">Status:</span>
                    <div class="flex items-center gap-1">
                        <div class="h-3 w-3 rounded-full bg-green-500 animate-pulse"></div>
                        <span class="text-green-600 font-semibold">Online</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Horários Button -->
        <a href="{{ route('schedule', ['search' => $feeder->name]) }}"class="flex items-center justify-between w-full bg-gray-900 hover:bg-gray-800 text-white font-medium px-6 py-3 rounded-xl transition">
            <span>Horários</span>
            <x-radix-arrow-right class="h-5 w-5 text-white" />
        </a>

        <!-- Feeding Logs Table -->
        <div class="flex flex-col gap-3">
            <div class="font-semibold text-gray-800 text-lg">Histórico de Alimentações</div>
            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
                <table class="min-w-full text-sm text-gray-700">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-4 text-left font-medium border-b border-gray-300 rounded-tl-lg">Data</th>
                            <th class="py-2 px-4 text-left font-medium border-b border-gray-300">Hora</th>
                            <th class="py-2 px-4 text-left font-medium border-b border-gray-300 rounded-tr-lg">Quantidade (g)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($feeder->feedingLogs as $log)
                        <tr>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $log->date->format('d/m/Y') }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $log->date->format('H:i') }}</td>
                            <td class="py-2 px-4 border-b border-gray-200">{{ $log->quantity }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="py-4 text-center text-gray-400">Nenhum histórico disponível</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        {{-- <a href="{{ route('feeding_log.store') }}">Criar Histórico</a> --}}

    </div>
</div>
@endsection