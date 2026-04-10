@props([
    'title' => 'no title',
    'text' => 'no text',
    'click' => null,
    'button_text' => 'no button text',
])
<x-card>
    <div class="flex flex-col m-2 p-2 justify-between items-center text-center md:text-left md:items-start flex-1">
        <h2 class="text-lg font-semibold text-gray-800">
            {{ $title }}
        </h2>
        <p class="text-gray-600 mb-4">
            {{ $text }}
        </p>
        <x-button :click="$click" class="bg-black hover:bg-gray-800 transition-colors w-full text-white font-medium px-6 py-3 rounded-xl">
            {{ $button_text }}
        </x-button>
    </div>
</x-card>
