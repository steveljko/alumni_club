<button type="{{ $type }}"
    id="{{ $id }}"
    @class([
        'font-medium flex items-center text-white rounded',
        'px-3 py-2 text-sm' => $size == 'sm',
        'px-4 py-1.5' => $size == 'md',
        'bg-blue-600 hover:bg-blue-700' => $style == 'normal',
        'bg-red-500 hover:bg-red-600 text-white' => $style == 'danger',
    ])
    {{ $attributes }}>
    @if ($spinner)
        <x-icon-spinner class="htmx-indicator mr-3 inline hidden h-4 w-4 animate-spin text-white [&.htmx-request]:block"
            id="{{ $id }}Spinner"></x-icon-spinner>
    @endif
    {{ $slot }}
</button>
