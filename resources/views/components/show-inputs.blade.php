@props([
    'label' => 'No label',
    'value' => 'No value',
    'way' => 'show',
    'name' => '',
    'type' => 'normal',
    'titleSize' => 'xl',
    'admin' => false, // FIX: definir prop
])

<div class="mb-2">
    @if ($type === 'title')
        @if ($way === 'show')
            <h1 class="font-bold text-gray-800 mb-2 sm:mb-3 text-lg sm:text-{{ $titleSize }}">
                {{ $value }}
            </h1>
        @else
            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">
                {{ $label }}
            </label>
            <div class="mt-1">
                <x-input :name="$name" :value="$value" />
            </div>
            
        @endif

    @elseif($type === 'normal')
        <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">
            {{ $label }}
        </label>

        @if ($way === 'show')
            <p class="mt-1 text-gray-800 capitalize text-wrap">
                {{ $value }}
            </p>
        @else
            @if(!$admin || auth()->user()->getRole() === 'admin')
                <div class="mt-1">
                    <x-input :name="$name" :value="$value" />
                </div>
                @else
                <p class="mt-1 text-gray-800 capitalize text-wrap">
                    {{ $value }}
                </p>
            @endif
            
        @endif
    @endif
</div>