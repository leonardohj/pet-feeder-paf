@extends('layouts.app')

@section('body')
<div class="px-5 py-2 w-full">
  <div class="flex w-full flex-wrap flex-row justify-center gap-3">

    @if ($feeders->isEmpty())
      <!-- No feeders -->
      <div class="items-center w-full max-w-2xl border-gray-50 border justify-between gap-6 p-4 bg-white rounded-2xl shadow-md">
        <div class="flex flex-col m-2 p-2 justify-between items-center text-center md:text-left md:items-start flex-1">
          <h2 class="text-lg font-semibold text-gray-800">
            Não tens um alimentador associado à tua conta?
          </h2>
          <p class="text-gray-600 mb-4">
            Associa um alimentador para começares a monitorizar e gerir a alimentação facilmente.
          </p>
          <button 
            class="bg-black hover:bg-gray-800 transition-colors w-full text-white font-medium px-6 py-3 rounded-xl"
            @click="$dispatch('open-modal-associate-feeder')"
          >
            Associar alimentador
          </button>
        </div>
      </div>
    @else
      <!-- Feeders list -->
      <div class="flex w-full flex-wrap flex-row justify-center md:justify-start gap-6">
        @foreach ($feeders as $feeder)
          <div class="items-center w-full max-w-xs border-gray-50 border justify-between gap-6 p-4 bg-white rounded-2xl shadow-md">
            <!-- Feeder Image -->
            <img src="{{ asset('img/img.webp') }}" alt="img" class="h-60 w-full mb-1 scale-x-[-1]">

            <!-- Feeder Info Link -->
            <a href="{{ route('feeder.show', ['feeder_id' => $feeder->id]) }}" class="border-t border-gray-300 flex flex-col gap-2">
              <div class="text-lg mt-1">{{ $feeder->name }}</div>

              <!-- Status Indicator -->
              <div class="flex gap-2 items-center text-sm">
                Status:
                <div class="{{ $feeder->status ? 'bg-green-500' : 'bg-red-500' }} h-4 w-4 rounded-full"></div>
              </div>

              <!-- Last Activation -->
              <div class="text-sm">Última vez ativado: {{ $feeder->last_fed_at?->format('d/m/Y H:i') ?? 'nunca' }}</div>

              <!-- Arrow -->
              <div class="flex justify-end mt-2">
                <x-radix-chevron-right class="h-5 w-5 text-gray-700"/>
              </div>
            </a>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</div>


@endsection