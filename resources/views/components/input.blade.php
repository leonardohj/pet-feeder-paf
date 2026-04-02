@props([
    'label' => 'No label',
    'name' => 'none',
    'type' => 'text',
    'placeholder' => '',
    ])
<div class="w-full">
    @if(!empty($label))
        <label for="{{ $name ?? '' }}" class="block mb-1 font-medium text-gray-700 text-sm">{{ $label }}</label>
    @endif

    <div class="@if($type == 'password') flex items-center gap-3 @endif rounded-full px-3 py-1 border-gray-200 border w-full max-w-2xl @error($name) border-red-500 @enderror">
        <input 
            name="{{ $name ?? '' }}" 
            id="{{ $name ?? '' }}" 
            type="{{ $type ?? 'text' }}" 
            placeholder="{{ $placeholder ?? '' }}" 
            value="{{ old($name) }}" 
            {{ $attributes->merge(['autocomplete' => $autocomplete ?? '']) }}
            {{ $attributes->merge(['class' => 'outline-0 w-full max-w-2xl py-1 bg-transparent']) }}
        >
        @if($type == 'password')
            <div id="toggle-{{ $name }}" class="cursor-pointer flex justify-center items-center">
                <x-radix-eye-closed class="h-5 w-5 text-black" />
            </div>
        @endif
    </div>

    @if ($errors->has($name))
        <p class="text-red-500 text-sm">{{ $errors->first($name) }}</p>
    @endif
</div>

@if($type == 'password')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const input = document.getElementById('{{ $name }}');
        const toggle = document.getElementById('toggle-{{ $name }}');
        let visible = false;

        toggle.addEventListener('click', function() {
            visible = !visible;
            input.type = visible ? 'text' : 'password';

            
            toggle.innerHTML = visible
                ? '<x-radix-eye-open class="h-5 w-5 text-black" />'
                : '<x-radix-eye-closed class="h-5 w-5 text-black" />';
        });
    });
</script>
@endif
