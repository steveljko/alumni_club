@extends('layouts.default')

@section('content')
    <div class="h-screen w-full md:flex md:items-center md:justify-center">
        <div class="h-screen w-full md:h-auto md:w-[30%]">
            <div class="rounded-xl bg-white p-4 shadow">
                <div class="mb-4">
                    <h2 class="mb-2 font-semibold">Change Initial Password</h2>
                    <p class="text-sm leading-[1.5rem] text-gray-500">
                        To keep your account secure, please change your initial password. This ensures that only you have access to your information.
                    </p>
                </div>
                <form
                    hx-put="{{ route('auth.setup.step.1') }}"
                    hx-indicator="#nextButtonSpinner"
                    hx-swap="none"
                >
                    @csrf
                    <x-form-input
                        label="Password"
                        type="password"
                        name="password"
                    />
                    <x-form-input
                        label="Confirm Password"
                        type="password"
                        name="password_confirmation"
                    />
                    <div class="flex w-full justify-end">
                        <x-button
                            id="nextButton"
                            spinner="true"
                            type="submit"
                        >Next</x-button>
                    </div>
                </form>
            </div>
            <p class="my-4 text-center text-gray-500">Logged in as {{ auth()->user()->name }}</p>
        </div>
    </div>
@endsection
