@extends('layouts.home')

@section('content')
    <div class="container mx-auto mt-4 space-y-4">
        <div class="w-full rounded-md p-4 shadow">
            <h3 class="text-lg font-semibold">Account Settings</h3>
            <form hx-put="{{ route('auth.settings.update') }}"
                hx-swap="none">
                @csrf
                <x-form-input label="Name"
                    name="name"
                    :value="$user->name" />
                <x-form-inline>
                    <x-form-select label="University Start Year"
                        name="uni_start_year"
                        between="2000,current"
                        :value="$user->uni_start_year" />
                    <x-form-select label="University Finish Year"
                        name="uni_finish_year"
                        between="2000,current"
                        :value="$user->uni_finish_year" />
                </x-form-inline>
                <x-form-textarea label="Biography"
                    name="bio"
                    :value="$user->bio"
                    limit="256" />
                <button type="submit"
                    class="rounded-md bg-[#4D5BFC] px-3 py-1 text-white">Change</button>
            </form>
        </div>

        <div class="w-full rounded-md p-4 shadow">
            <h3 class="text-lg font-semibold">Change Avatar</h3>
        </div>

        <div class="w-full rounded-md p-4 shadow">
            <h3 class="text-lg font-semibold">Change Password</h3>
        </div>

        <div class="w-full rounded-md p-4 shadow">
            <h3 class="text-lg font-semibold">Manage Work History</h3>
        </div>
    </div>
@endsection
