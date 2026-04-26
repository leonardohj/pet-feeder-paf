@props([
    'type'     => 'success',
    'title'    => null,
    'message'  => '',
    'duration' => 4000,
])

@session('toast')
    @php
        $t       = $value['type']    ?? $type;
        $title   = $value['title']   ?? $title;
        $message = $value['message'] ?? $message;

        $styles = [
            'success' => [
                'wrapper' => 'border-l-emerald-500',
                'icon_bg' => 'bg-emerald-50',
                'icon'    => 'text-emerald-600',
                'bar'     => 'bg-emerald-500',
            ],
            'warning' => [
                'wrapper' => 'border-l-amber-400',
                'icon_bg' => 'bg-amber-50',
                'icon'    => 'text-amber-500',
                'bar'     => 'bg-amber-400',
            ],
            'error' => [
                'wrapper' => 'border-l-red-500',
                'icon_bg' => 'bg-red-50',
                'icon'    => 'text-red-500',
                'bar'     => 'bg-red-500',
            ],
            'info' => [
                'wrapper' => 'border-l-blue-500',
                'icon_bg' => 'bg-blue-50',
                'icon'    => 'text-blue-500',
                'bar'     => 'bg-blue-500',
            ],
        ];

        $s = $styles[$t] ?? $styles['success'];
    @endphp

    <div
        x-data="{ show: true }"
        x-show="show"
        x-init="setTimeout(() => show = false, {{ $duration }})"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-x-4"
        x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 translate-x-4"
        role="alert"
        aria-live="polite"
        class="relative flex items-start gap-3 w-80 overflow-hidden rounded-xl border border-gray-200 bg-white px-4 py-3 shadow-sm border-l-4 {{ $s['wrapper'] }}"
    >
        {{-- Icon --}}
        <div class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-full {{ $s['icon_bg'] }}">
            @if($t === 'success')
                <svg class="h-4 w-4 {{ $s['icon'] }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 13l4 4L19 7"/>
                </svg>
            @elseif($t === 'warning')
                <svg class="h-4 w-4 {{ $s['icon'] }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
            @elseif($t === 'error')
                <svg class="h-4 w-4 {{ $s['icon'] }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 18L18 6M6 6l12 12"/>
                </svg>
            @else
                <svg class="h-4 w-4 {{ $s['icon'] }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            @endif
        </div>

        {{-- Body --}}
        <div class="flex-1 min-w-0">
            @if($title)
                <p class="text-sm font-medium text-gray-900">{{ $title }}</p>
            @endif
            <p class="text-sm text-gray-500 {{ $title ? 'mt-0.5' : '' }}">{{ $message }}</p>
        </div>

        {{-- Dismiss --}}
        <button
            @click="show = false"
            aria-label="Dismiss"
            class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors"
        >
            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                <path d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        {{-- Progress bar --}}
        <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gray-100">
            <div
                class="h-full {{ $s['bar'] }}"
                x-init="$el.style.transition = 'width {{ $duration }}ms linear'; requestAnimationFrame(() => $el.style.width = '0%')"
                style="width: 100%"
            ></div>
        </div>
    </div>
@endsession