@props(['href'])

<tr
    {{ $attributes->merge([
        'data-clickable-href' => $href,
        'role' => 'button',
        'tabindex' => '0',
        'class' => 'cursor-pointer hover:bg-gray-50 transition-colors ' . ($attributes->get('class') ?? ''),
    ]) }}
>
    {{ $slot }}
</tr>

@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.body.addEventListener('click', function (e) {
                    const row = e.target.closest('tr[data-clickable-href]');
                    if (!row) return;
                    if (e.target.closest('a, button, [type="submit"], input, select, textarea')) return;
                    e.preventDefault();
                    window.location = row.dataset.clickableHref;
                });
                document.body.addEventListener('keydown', function (e) {
                    if (e.key !== 'Enter') return;
                    const row = e.target.closest('tr[data-clickable-href]');
                    if (!row) return;
                    if (e.target.closest('a, button, input, select, textarea')) return;
                    e.preventDefault();
                    window.location = row.dataset.clickableHref;
                });
            });
        </script>
    @endpush
@endonce
