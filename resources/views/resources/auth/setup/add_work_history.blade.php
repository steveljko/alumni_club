@extends('layouts.default')

@section('content')
    <div class="h-screen w-full md:flex md:items-center md:justify-center">
        <div class="h-screen w-full md:h-auto md:w-[30%]"
            hx-get="{{ route('workHistory.show') }}"
            hx-select-oob="#job_count:innerHTML,#job_list:innerHTML"
            hx-swap="none"
            hx-trigger="loadWorkHistories from:body">
            <div class="rounded-xl bg-white p-4 shadow">
                <div class="mb-4">
                    <h2 class="mb-2 font-semibold">{{ __('setup.step3.title') }}</h2>
                    <p class="text-sm text-gray-500">{{ __('setup.step3.desc') }}</p>
                </div>
                <div class="flex w-full items-center justify-between">
                    @fragment('job_count')
                        <p class="text-gray-700"
                            id="job_count">{{ __('setup.step3.jobs_added', ['count' => $workHistory->count()]) }}</p>
                    @endfragment
                    <a class="cursor-pointer rounded bg-blue-500 px-2 py-2 text-sm font-medium text-white"
                        hx-get="{{ route('workHistory.create') }}"
                        hx-swap="innerHTML"
                        hx-target="#modal">Add</a>
                </div>
                @fragment('workHistories')
                    <div class="my-3 h-[350px] space-y-2 overflow-y-auto rounded-xl border border-gray-200 bg-gray-50 p-4"
                        id="job_list">
                        @if (!empty($workHistory))
                            @include('resources.user.workHistory.show', $workHistory)
                        @else
                            <p>{{ __('setup.step3.no_jobs_added') }}</p>
                        @endif
                    </div>
                @endfragment
                <div class="flex w-full items-center justify-end">
                    <a class="mr-3 cursor-pointer font-bold uppercase text-gray-700"
                        hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'
                        hx-patch="{{ route('auth.setup.step.3.skip') }}">Skip</a>
                    <button hx-put="{{ route('workHistory.publish') }}"
                        hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'
                        type="submit"
                        class="rounded-md bg-[#4D5BFC] px-3 py-1 text-white">Next</button>
                </div>
            </div>
            <p class="my-4 text-center text-gray-500">{{ __('setup.logged_in_as') }} {{ auth()->user()->name }}</p>
        </div>
    </div>
@endsection
