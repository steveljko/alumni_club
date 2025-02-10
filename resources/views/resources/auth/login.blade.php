@extends('layouts.default')

@section('content')
    <div class="h-screen w-full md:flex md:items-center md:justify-center">
        <div class="h-screen w-full rounded-xl bg-white p-4 shadow md:h-auto md:w-[30%]">
            <form hx-indicator="#loginSpinner" hx-post="{{ route('auth.login') }}">
                @csrf
                <x-form-input label="Email Address" name="email" />
                <x-form-input
                    label="Password"
                    type="password"
                    name="password"
                />
                <div class="inline-flex w-full items-center justify-between text-gray-600">
                    <x-button
                        type="submit"
                        id="login"
                        spinner="true"
                        size="md"
                    >
                        Sign In
                    </x-button>
                    <a href="{{ route('auth.password.forgot') }}" class="text-sm hover:underline">Forgot Password?</a>
                </div>
            </form>
        </div>
    </div>
@endsection
