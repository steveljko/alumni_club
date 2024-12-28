@extends('layouts.default')

@section('content')
    <div class="h-screen w-full md:flex md:items-center md:justify-center">
        <div class="h-screen w-full md:h-auto md:w-[30%]">
            <div class="rounded-xl bg-white p-4 shadow">
                <div class="mb-4">
                    <h2 class="mb-2 font-semibold">Change Initial Password</h2>
                    <p class="text-sm text-gray-500">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nam magni ut nulla sed fugit, vitae
                        consequuntur
                        rem blanditiis ipsum a, optio incidunt corrupti rerum repellat earum reiciendis deserunt obcaecati impedit?</p>
                </div>
                <form hx-put="{{ route('auth.setup.step.1') }}"
                    hx-swap="none">
                    @csrf
                    <x-form-input label="Password"
                        type="password"
                        name="password" />
                    <x-form-input label="Confirm Password"
                        type="password"
                        name="password_confirmation" />
                    <div class="flex w-full justify-end">
                        <button type="submit"
                            class="rounded-md bg-[#4D5BFC] px-3 py-1 text-white">Next</button>
                    </div>
                </form>
            </div>
            <p class="my-4 text-center text-gray-500">Logged in as {{ auth()->user()->name }}</p>
        </div>
    </div>
@endsection
