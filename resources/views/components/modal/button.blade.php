@props(['type' => 'button', 'variant' => 'primary', 'closeModal' => false])

<button
    type="{{ $type }}"
    @class([
        'flex items-center rounded border px-3 py-1 focus:ring-1',
        'border-navyblue-500 bg-navyblue-500 text-white' => $variant == 'primary',
        'border-gray-300 bg-white text-black shadow-sm' => $variant == 'secondary',
    ])
    @if ($attributes['data-hide-modal']) {{ 'data-hide-modal' }} @endif
>
    @if ($variant == 'primary')
        <x-icon-spinner class="htmx-indicator mr-3 inline hidden h-4 w-4 animate-spin text-white [&.htmx-request]:block" id="spinner" />
    @endif
    {{ $slot }}
</button>
