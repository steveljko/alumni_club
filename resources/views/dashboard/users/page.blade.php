@extends('layouts.dashboard')

@section('content')
    <div class="w-full p-4">
        <div class="w-full rounded bg-white p-4 shadow">
            <div class="mb-2 flex items-center justify-between">
                <h3 class="text-lg font-semibold">Users</h3>
                <x-button id="newUser"
                    hx-get="{{ route('admin.users.create') }}"
                    hx-target="#modal">New User</x-button>
            </div>
            @include('dashboard.users.partials.table')
        </div>
    </div>
@endsection
