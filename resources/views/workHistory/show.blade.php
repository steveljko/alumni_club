<ol hx-get="{{ route('workHistory.show') }}"
    hx-trigger="loadWorkHistories from:body"
    hx-swap="outerHTML"
    class="relative space-y-8 border-s border-gray-500">
    @foreach ($workHistory as $wh)
        <li class="ms-6">
            <div class="absolute -start-1.5 mt-1.5 h-3 w-3 rounded-full border border-gray-500 bg-gray-500">
            </div>
            <div class="mb-2 space-y-1">
                <time class="mb-1 text-sm font-medium leading-none text-gray-800">
                    {{ $wh->start_date->format('d M y') }} - {{ $wh->end_date->format('d M y') }}
                    <span class="text-xs italic text-gray-400">({{ $wh->calcYearsInCompany() }})</span>
                </time>
                <h3 class="text-lg font-semibold text-gray-900">{{ $wh->position }}</h3>
                <p class="text-sm font-medium uppercase text-gray-600">{{ $wh->company_name }}</p>
            </div>
            <div class="flex space-x-3">
                <button hx-get="{{ route('workHistory.edit', $wh->id) }}"
                    hx-target="#modal"
                    hx-swap="innerHTML"
                    class="flex cursor-pointer items-center font-semibold uppercase tracking-[0.03rem] text-blue-500">
                    Edit
                </button>
                <button hx-delete="{{ route('workHistory.delete', $wh->id) }}"
                    hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'
                    hx-swap="none"
                    class="flex cursor-pointer items-center font-semibold uppercase tracking-[0.03rem] text-red-500">
                    Delete
                </button>
            </div>
        </li>
    @endforeach
</ol>
