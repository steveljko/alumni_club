@extends('layouts.default')

@section('content')
    <x-add-work-modal />

    <div class="h-screen w-full md:flex md:items-center md:justify-center">
        <div class="h-screen w-full md:h-auto md:w-[30%]"
            hx-get=""
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
                            id="job_count">{{ __('setup.step3.jobs_added', ['count' => $work->count()]) }}</p>
                    @endfragment
                    <button hx-get=""
                        hx-swap="none"
                        hx-target="#modal"
                        class="rounded-md bg-[#4D5BFC] px-2 py-[2px] text-sm font-semibold uppercase text-white">{{ __('setup.step3.add') }}</button>
                </div>
                @fragment('workHistories')
                    <div class="my-3 h-[350px] space-y-2 overflow-y-auto rounded-xl border border-gray-200 bg-gray-50 p-4"
                        id="job_list">
                        @if (count($work))
                            @foreach ($work as $job)
                                <div class="rounded-md border border-gray-200 bg-white px-2 py-1 shadow-sm">
                                    <p class="flex justify-between">
                                        <span class="font-bold">{{ $job->position }}</span>
                                        <span class="text-sm text-gray-600">
                                            {{ $job->start_date }}
                                            <span>-</span>
                                            @if ($job->end_date)
                                                {{ $job->end_date }}
                                            @else
                                                Present
                                            @endif
                                        </span>
                                    </p>

                                    <p>{{ $job->company_name }}</p>
                                </div>
                            @endforeach
                        @else
                            <p>{{ __('setup.step3.no_jobs_added') }}</p>
                        @endif
                    </div>
                @endfragment
                <div class="flex w-full items-center justify-end">
                    <a class="mr-3 cursor-pointer font-bold uppercase text-gray-700"
                        hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'
                        hx-patch="{{ route('auth.setup.step.3.skip') }}">Skip</a>
                    <button hx-patch="{{ route('auth.setup.step.3') }}"
                        hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'
                        type="submit"
                        class="rounded-md bg-[#4D5BFC] px-3 py-1 text-white">Next</button>
                </div>
            </div>
            <p class="my-4 text-center text-gray-500">{{ __('setup.logged_in_as') }} {{ auth()->user()->name }}</p>
        </div>
    </div>
@endsection
