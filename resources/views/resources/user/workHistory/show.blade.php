<div hx-get="{{ route('users.profile.workHistories', $user) }}" hx-trigger="loadWorkHistories from:body">
    @if (count($user->workHistory))
        <ol class="relative space-y-8 border-s border-gray-500">
            @foreach ($user->workHistory as $wh)
                <li class="ms-6">
                    <div class="absolute -start-1.5 mt-1.5 h-3 w-3 rounded-full border border-gray-500 bg-gray-500">
                    </div>
                    <div class="mb-2 space-y-1">
                        <time class="mb-1 text-sm font-medium leading-none text-gray-800">
                            {{ $wh->start_date->format('d M y') }} -
                            @if ($wh->end_date)
                                {{ $wh->end_date->format('d M y') }}
                            @else
                                Current
                            @endif
                            <span class="text-xs italic text-gray-400">({{ $wh->calcYearsInCompany() }})</span>
                            @if ($wh->is_draft)
                                <span>Unpublished</span>
                            @endif
                        </time>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $wh->position }}</h3>
                        <p class="text-sm font-medium uppercase text-gray-600">{{ $wh->company_name }}</p>
                    </div>
                    <div class="flex space-x-3">
                        @can('update', $wh)
                            <button
                                hx-get="{{ route('users.workHistories.edit', $wh->id) }}"
                                hx-target="#dialog"
                                hx-swap="innerHTML"
                                class="flex cursor-pointer items-center font-semibold uppercase tracking-[0.03rem] text-navyblue-500"
                            >
                                Edit
                            </button>
                        @endcan
                        @can('delete', $wh)
                            <button
                                hx-get="{{ route('users.workHistories.delete', $wh->id) }}"
                                hx-target="#dialog"
                                hx-swap="innerHTML"
                                class="flex cursor-pointer items-center font-semibold uppercase tracking-[0.03rem] text-red-500"
                            >
                                Delete
                            </button>
                        @endcan
                    </div>
                </li>
            @endforeach
        </ol>
    @else
        <div>
            @if (request()->routeIs('users.settings'))
                <p class="text-sm leading-6 text-gray-500">You have not yet added any work history.</p>
            @else
                <p class="text-sm leading-6 text-gray-500">User haven't yet added any work history.</p>
            @endif
        </div>
    @endif
</div>
