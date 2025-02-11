@extends('layouts.default')

@section('content')
    <div class="h-screen w-full md:flex md:items-center md:justify-center">
        <div class="h-screen w-full md:h-auto md:w-[30%]">
            <div class="rounded-xl bg-white p-4 shadow">
                <div class="mb-4">
                    <h2 class="mb-2 font-semibold">{{ __('setup.step3.title') }}</h2>
                    <p class="text-sm leading-[1.5rem] text-gray-500">{{ __('setup.step3.desc') }}</p>
                </div>
                <div class="flex w-full items-center justify-end">
                    <x-button
                        id="addWorkHistory"
                        size="sm"
                        hx-get="{{ route('users.workHistories.create') }}"
                        hx-target="#dialog"
                        hx-swap="innerHTML"
                    >Add</x-button>
                </div>
                @fragment('workHistories')
                    <div
                        hx-get="{{ route('users.workHistories') }}"
                        hx-trigger="loadWorkHistories from:body"
                        hx-swap="innerHTML"
                        class="my-3 h-[350px] space-y-2 overflow-y-auto rounded-xl border border-gray-200 bg-gray-50 p-4"
                    >
                        @include('resources.user.workHistory.show', $workHistory)
                    </div>
                @endfragment
                <div class="flex w-full items-center justify-end space-x-2">
                    <x-button
                        id="skipButton"
                        variant="secondary"
                        hx-get="{{ route('auth.setup.step.3.skip') }}"
                        hx-target="#dialog"
                        hx-swap="innerHTML"
                    >Skip</x-button>
                    <x-button
                        id="nextButton"
                        hx-put="{{ route('users.workHistories.publish') }}"
                        type="submit"
                    >Next</x-button>
                </div>
            </div>
            <p class="my-4 text-center text-gray-500">{{ __('setup.logged_in_as') }} {{ auth()->user()->name }}</p>
        </div>
    </div>
@endsection
