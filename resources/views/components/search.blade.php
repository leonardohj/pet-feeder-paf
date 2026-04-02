@props([
    'label' => null,
    'name' => 'search',
    'type' => 'text',
    'placeholder' => 'Search...',
    'value' => null,
])

<div class="w-full">
    @if(!empty($label))
        <label for="{{ $name }}" class="block mb-1 font-medium text-gray-700 text-sm">{{ $label }}</label>
    @endif

    <div class="rounded-full px-3 py-1 border-gray-200 border w-full @error($name) border-red-500 @enderror flex items-center gap-3">
        <input 
            name="{{ $name }}" 
            id="{{ $name }}" 
            type="{{ $type }}" 
            placeholder="{{ $placeholder }}" 
            value="{{ old($name, $value ?? '') }}" {{-- USE OLD OR VALUE --}}
            {{ $attributes->merge(['autocomplete' => 'off']) }}
            class="outline-0 w-full max-w-2xl py-1 bg-transparent"
        >

        @isset($slot)
            <div class="flex justify-center items-center">
                {{ $slot }}
            </div>
        @endisset
    </div>

    @if ($errors->has($name))
        <p class="text-red-500 text-sm mt-1">{{ $errors->first($name) }}</p>
    @endif
</div>