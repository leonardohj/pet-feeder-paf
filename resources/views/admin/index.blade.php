@extends('layouts.app')

@section('body')

<div class="px-5 py-2 w-full">
  <div class="flex w-full flex-wrap flex-row  justify-center md:justify-start gap-3" >
    @if(isset($feeders))
       @foreach($feeders as $feeder)
        <div class="items-center w-full max-w-xs border-gray-50 border justify-between gap-6 p-4 bg-white rounded-2xl shadow-md">
          <img src="{{ asset('img/img.webp') }}" alt="img" class="h-60 w-full scale-x-[-1]">
          <div class="text-lg uppercase text-gray-500 text-center my-1">IMAGEM ILUSTRATIVA</div>
          <div class="border-t cursor-pointer border-gray-300 flex"> {{-- href="{{route('feeder.show')}}" --}}
            <div class="w-full ">
              <div class="text-lg mt-1">{{ $feeder->nome }}</div>
              <div class="flex gap-2 items-center text-sm">Status: <div class="bg-green-500 h-4 w-4 rounded-full"></div></div>
              <div class="text-sm">Ultima vez ativado: nunca</div>
              <div class="text-sm">Id do utilizador: {{empty($feeder->id_user) ? 'nenhum' : $feeder->id_user}} </div>
              <div class="text-sm">Id do feeder: {{$feeder->id}} </div>
              <div class="text-sm">Código de associação: {{$feeder->code}} </div>
            </div>
            <div class="flex items-center justify-center">
              <x-radix-chevron-right class="h-6 w-6 "/>
            </div>
          </div>
            </div>
        @endforeach
    @endif
  </div>

<div class="flex justify-center items-center">
  
<div class="flex flex-col md:flex-row items-center max-w-3xl border-gray-50 border justify-between gap-6 p-4 bg-white rounded-2xl shadow-md">


  <form action="{{route('feeder.create')}}" method="POST">
    @csrf
    <button class="bg-black hover:bg-gray-800 transition-colors  w-full text-white font-medium px-6 py-3 rounded-xl"> + Criar feeder</button>
  </form>
</div>
</div>
</div>

<script>
  const buttonAssociateFeeder = document.getElementById('buttonAssociateFeeder');
  buttonAssociateFeeder.addEventListener('click', openModalAssociateFeeder);
</script>
@endsection