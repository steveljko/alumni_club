@extends('layouts.default')

@section('content')
    <div class="h-screen w-full md:flex md:items-center md:justify-center">
        <div class="h-screen w-full rounded-xl bg-white p-4 shadow md:h-auto md:w-[30%]">
            <div class="mb-4">
                <h2 class="mb-2 font-semibold">Forgot Password?</h2>
                <p class="text-sm text-gray-500">
                    Please enter your registered email address below, and we will send you a link to reset your password.
                    Check your inbox for the email and follow the instructions to create a new password.
                </p>
            </div>
            <form hx-put="{{ route('auth.password.forgot.execute') }}"
                hx-swap="none">
                @csrf
                <x-form-input label="Email address"
                    name="email" />
                <button type="submit"
                    class="rounded-md bg-[#4D5BFC] px-3 py-1 text-white">Send Email</button>
            </form>
        </div>
    </div>
@endsection
