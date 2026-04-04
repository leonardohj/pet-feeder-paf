@extends('layouts.app')

@section('body')

<div class="px-5 py-2 w-full">
  <div class="flex w-full flex-wrap flex-row justify-center md:justify-start gap-3">

    @if(isset($feeders))
      @foreach($feeders as $feeder)

        <div class="items-center w-full max-w-xs border-gray-50 border justify-between gap-6 p-4 bg-white rounded-2xl shadow-md">

          <img src="{{ asset('img/img.webp') }}" alt="img" class="h-60 w-full scale-x-[-1]">

          <div class="text-lg uppercase text-gray-500 text-center my-1">
            IMAGEM ILUSTRATIVA
          </div>

          <div class="border-t border-gray-300 pt-3">

            {{-- Show every feeder attribute --}}
            @foreach($feeder->toArray() as $key => $value)

              <div class="text-sm flex justify-between border-b border-gray-100 py-1">
                <span class="font-medium text-gray-600">
                  {{ ucfirst(str_replace('_',' ',$key)) }}
                </span>

                <span class="text-gray-800">
                  {{ $value === null || $value === '' ? 'null' : $value }}
                </span>
              </div>

            @endforeach

          </div>

        </div>

      @endforeach
    @endif

  </div>


  <div class="flex justify-center items-center mt-6">

    <div class="flex flex-col md:flex-row items-center max-w-3xl border-gray-50 border justify-between gap-6 p-4 bg-white rounded-2xl shadow-md">

      <form action="{{ route('feeder.create') }}" method="POST">
        @csrf

        <button class="bg-black hover:bg-gray-800 transition-colors w-full text-white font-medium px-6 py-3 rounded-xl">
          + Criar feeder
        </button>

      </form>

    </div>

  </div>
</div>

<script>
  const buttonAssociateFeeder = document.getElementById('buttonAssociateFeeder');

  if(buttonAssociateFeeder){
    buttonAssociateFeeder.addEventListener('click', openModalAssociateFeeder);
  }
</script>

@endsection