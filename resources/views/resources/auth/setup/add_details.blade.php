@extends('layouts.default')

@section('content')
    <div class="h-screen w-full md:flex md:items-center md:justify-center">
        <div class="h-screen w-full md:h-auto md:w-[30%]">
            <div class="rounded-xl bg-white p-4 shadow">
                <div class="mb-4">
                    <h2 class="mb-2 font-semibold">Add Details</h2>
                    <p class="text-sm text-gray-500">You're just a step away from completing your profile—please provide a few more details!</p>
                </div>
                <form
                    hx-put="{{ route('auth.setup.step.2') }}"
                    hx-indicator="#nextButtonSpinner"
                    hx-swap="none"
                >
                    @csrf
                    <div class="flex w-full space-x-4">
                        <x-form-select
                            label="University Start Year"
                            name="uni_start_year"
                            between="2000,current"
                        >
                        </x-form-select>
                        <x-form-select
                            label="University Finish Year"
                            name="uni_finish_year"
                            between="2000,current"
                        />
                    </div>
                    <div>
                        <x-form-textarea
                            label="Biography"
                            name="bio"
                            limit="250"
                        />
                    </div>
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
