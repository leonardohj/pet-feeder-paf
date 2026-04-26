@props([
    'title' => null,
    'titleSize' => '2xl', 
    'max_width' => true
])

<div class="px-3 sm:px-5 py-2 sm:py-4 w-full flex justify-center">
    <div class="w-full {{ $max_width ? 'max-w-3xl' : '' }} bg-white rounded-2xl shadow-sm sm:shadow-md p-4 sm:p-6">
        @if (!empty($title))
            <h1 class="font-bold text-gray-800 mb-2 sm:mb-3 text-lg sm:text-{{ $titleSize }}">
                {{ $title }}
            </h1>
        @endif
        {{ $slot }}
    </div>
</div>