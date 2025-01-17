<span class="block rounded-full border border-gray-200 px-1.5 py-0.75 text-xs font-medium text-gray-900">
    @if (!$start->isSameMonth($end))
        {{ $start->format('d M') }} - {{ $end->format('d M y') }}
    @else
        {{ $start->format('d') }} - {{ $end->format('d M y') }}
    @endif
</span>
