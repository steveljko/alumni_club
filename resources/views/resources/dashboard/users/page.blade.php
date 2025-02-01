@extends('layouts.dashboard')

@section('content')
    <div class="w-full rounded-lg bg-white p-4 shadow"
        id="wrapper">
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-lg font-semibold">Users</h3>
            <x-button id="newUser"
                hx-get="{{ route('admin.users.create') }}"
                hx-target="#modal">New User</x-button>
        </div>
        <label for="simple-search"
            class="sr-only">Search</label>
        <div class="relative w-full">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <svg aria-hidden="true"
                    class="h-5 w-5 text-gray-500 dark:text-gray-400"
                    fill="currentColor"
                    viewbox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd" />
                </svg>
            </div>
            <input name="q"
                class="focus:ring-primary-500 focus:border-primary-500 mb-4 block w-full rounded-lg border border-gray-300 bg-gray-50 p-2 pl-10 text-sm text-gray-900"
                placeholder="Search for user..."
                hx-get="{{ route('admin.users') }}"
                hx-push-url="true"
                hx-target="#users-table"
                hx-swap="outerHTML"
                hx-trigger="keyup changed delay:1s">
        </div>
        <div class="relative flex h-full w-full flex-col overflow-scroll rounded-xl border border-gray-300 bg-white bg-clip-border text-gray-700">
            @fragment('table')
                <div id="users-table"
                    hx-get=""
                    hx-trigger="loadUsers from:body"
                    hx-target="#users-table"
                    hx-swap="outerHTML">
                    <table class="w-full table-fixed text-left text-sm">
                        <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                            <tr>
                                <th class="w-8 p-4">#</th>
                                <th class="p-4">Name</th>
                                <th class="p-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($users))
                                @foreach ($users as $index => $user)
                                    <tr class="border-b odd:bg-white even:bg-gray-50"
                                        id="user-{{ $user->id }}">
                                        <td class="p-4">{{ $index + $users->firstItem() }}</td>
                                        <td class="p-4">{{ $user->name }}</td>
                                        <td class="p-4">
                                            <a hx-get="{{ route('admin.users.edit', $user->id) }}"
                                                hx-target="#modal"
                                                class="cursor-pointer">Edit</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                    <div id="pagination-links"
                        hx-boost="true"
                        hx-target="#users-table"
                        hx-swap="outerHTML"
                        class="p-4">
                        {{ $users->links() }}
                    </div>
                </div>
            @endfragment
        </div>
    </div>
@endsection
