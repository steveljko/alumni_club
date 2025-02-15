@extends('layouts.default')

@section('content')
    <div class="h-screen w-full md:flex md:items-center md:justify-center">
        <div class="h-screen w-full rounded-xl border border-gray-200 bg-white p-4 shadow-sm md:h-auto md:w-[60%] lg:w-[30%]">
            <form
                hx-indicator="#loginSpinner"
                hx-post="{{ route('auth.login') }}"
                hx-swap="none"
            >
                <x-form-input label="Email Address" name="email" />
                <x-form-input
                    label="Password"
                    type="password"
                    name="password"
                />
                <div class="inline-flex w-full items-center justify-between text-gray-600">
                    <a href="{{ route('auth.password.forgot') }}" class="text-sm hover:underline">Forgot Password?</a>
                    <x-button
                        type="submit"
                        id="login"
                        spinner="true"
                        size="md"
                    >
                        Sign In
                    </x-button>
                </div>
            </form>
        </div>
    </div>
@endsection
