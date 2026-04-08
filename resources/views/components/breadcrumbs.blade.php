@props(['links' => []])
<nav class="hidden lg:flex" aria-label="Breadcrumb">
    <ol role="list" class="flex items-center space-x-4">
        @foreach ($links as $label => $link)
            <li>
                <div class="flex items-center">
                    <x-radix-chevron-right class="h-7 w-7 flex-shrink-0 text-gray-400" />
                    <a href="{{ $link }}"
                        class="ml-4 text-sm text-gray-500 hover:text-gray-700">{{ $label }}</a>
                </div>
            </li>
        @endforeach
    </ol>
</nav>
