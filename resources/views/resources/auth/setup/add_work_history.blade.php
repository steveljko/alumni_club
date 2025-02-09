@extends('layouts.default')

@section('content')
    <div class="h-screen w-full md:flex md:items-center md:justify-center">
        <div
            class="h-screen w-full md:h-auto md:w-[30%]"
            hx-get="{{ route('workHistory.show') }}"
            hx-swap="innerHTML"
            hx-trigger="reloadWorkHistories from:body"
        >
            <div class="rounded-xl bg-white p-4 shadow">
                <div class="mb-4">
                    <h2 class="mb-2 font-semibold">{{ __('setup.step3.title') }}</h2>
                    <p class="text-sm leading-[1.5rem] text-gray-500">{{ __('setup.step3.desc') }}</p>
                </div>
                <div class="flex w-full items-center justify-end">
                    <x-button
                        id="addWorkHistory"
                        size="sm"
                        class="cursor-pointer rounded bg-blue-500 px-2 py-2 text-sm font-medium text-white"
                        hx-get="{{ route('workHistory.create') }}"
                        hx-swap="innerHTML"
                        hx-target="#dialog"
                    >Add</x-button>
                </div>
                @fragment('workHistories')
                    <div
                        hx-get="{{ route('workHistory.show') }}"
                        hx-trigger="reloadWorkHistories from:body"
                        hx-swap="innerHTML"
                        class="my-3 h-[350px] space-y-2 overflow-y-auto rounded-xl border border-gray-200 bg-gray-50 p-4"
                        id="job_list"
                    >
                        @include('resources.user.workHistory.show', $workHistory)
                    </div>
                @endfragment
                <div class="flex w-full items-center justify-end space-x-2">
                    <x-button
                        id="skipButton"
                        variant="secondary"
                        hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'
                        hx-patch="{{ route('auth.setup.step.3.skip') }}"
                    >Skip</x-button>
                    <x-button
                        id="nextButton"
                        hx-put="{{ route('workHistory.publish') }}"
                        hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'
                        type="submit"
                    >Next</x-button>
                </div>
            </div>
            <p class="my-4 text-center text-gray-500">{{ __('setup.logged_in_as') }} {{ auth()->user()->name }}</p>
        </div>
    </div>
@endsection
