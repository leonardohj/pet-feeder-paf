@props([
    'id' => null,
    'color' => 'bg-gray-900 hover:bg-gray-800',
    'borders' => '',
    'text_color' => 'text-white',
    'type' => 'button',
    'click' =>  null
])
<button id="{{$id}}" @if(!empty($click)) @click="{{ $click }}" @endif type="{{ $type }}" class="mt-5  p-3 rounded-xl {{ $text_color }} w-full {{ $borders  }} border max-w-3xl font-semibold cursor-pointer {{ $color }}">{{ $slot }}</button>