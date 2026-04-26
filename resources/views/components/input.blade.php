@props([
    'label' => '',
    'name' => 'none',
    'type' => 'text',
    'placeholder' => '',
    'value' => ''
])
<div class="w-full">
    @if(!empty($label))
        <label for="{{ $name ?? '' }}" class="block font-medium text-gray-700 text-sm">{{ $label }}</label>
    @endif

    <div class="@if($type == 'password') mt-1 flex items-center gap-3 @endif rounded-full px-3 py-1 border-gray-200 border w-full max-w-2xl @error($name) border-red-500 @enderror">
        <input 
            name="{{ $name ?? '' }}" 
            id="{{ $name ?? '' }}" 
            type="{{ $type ?? 'text' }}" 
            placeholder="{{ $placeholder ?? '' }}" 
            value="{{ old($name) ?? $value }}" 
            {{ $attributes->merge(['autocomplete' => $autocomplete ?? '']) }}
            {{ $attributes->merge(['class' => 'outline-0 w-full max-w-2xl py-1 bg-transparent placeholder-gray-400']) }}
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

<!-- Autocomplete styling -->
<style>
    input:-webkit-autofill {
        -webkit-box-shadow: 0 0 0px 1000px white inset !important; /* background color */
        -webkit-text-fill-color: #111827 !important; /* text color */
        transition: background-color 5000s ease-in-out 0s;
    }

    input:-webkit-autofill::first-line {
        font-family: inherit;
        font-size: inherit;
        color: #111827;
    }

    input:-webkit-autofill:focus {
        -webkit-box-shadow: 0 0 0px 1000px white inset !important;
        -webkit-text-fill-color: #111827 !important;
    }
</style>