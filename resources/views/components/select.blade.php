@props([
    'label' => 'No label',
    'name' => 'none',
    'placeholder' => __('index.selectOneOption'),
    'options' => [], 
    'selected' => '',
    'onchange' => ''
])
<div class="w-full">
    @if (!empty($label))
        <label for="{{ $name ?? '' }}" class="block mb-1 font-medium text-gray-700 text-sm">{{ $label }}</label>
    @endif
    <select onchange="{{ $onchange }}" name="{{ $name }}"
        {{ $attributes->merge(['class' => 'outline-0 w-full max-w-2xl py-1 bg-transparent']) }}>
        <option selected disabled value=""> {{ $placeholder }}</option>
        @foreach ($options as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : ''}}>{{ $label }}</option>
        @endforeach
    </select>
</div>

@if ($errors->has($name))
    <p class="text-red-500 text-sm">{{ $errors->first($name) }}</p>
@endif
</div>
