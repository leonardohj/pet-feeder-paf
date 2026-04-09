@props([
    'label' => 'No label',
    'name' => 'none',
    'placeholder' => __('index.selectOneOption'),
    'options' => [], 
    'selected' => '',
    'onchange' => '',
    'x_model' => ''
])

<div class="w-full">
    @if (!empty($label))
        <label for="{{ $name }}" class="block mb-1 font-medium text-gray-700 text-sm">{{ $label }}</label>
    @endif

    <div class="rounded-full border border-gray-200 w-full max-w-2xl px-3 py-1 @error($name) border-red-500 @enderror">
        <select 
            name="{{ $name }}" 
            @if(!empty($x_model)) x-model="{{ $x_model }}" @endif
            @if($onchange) onchange="{{ $onchange }}" @endif
            class="outline-none w-full bg-transparent py-1"
        >
            <option value="" disabled>{{ $placeholder }}</option>
            @foreach ($options as $value => $optionLabel)
            <option value="{{ $value }}" {{ trim((string)$selected) === trim((string)$value) ? 'selected' : '' }}>{{ $optionLabel }}</option>            @endforeach
        </select>
    </div>

    @if ($errors->has($name))
        <p class="text-red-500 text-sm mt-1">{{ $errors->first($name) }}</p>
    @endif
</div>