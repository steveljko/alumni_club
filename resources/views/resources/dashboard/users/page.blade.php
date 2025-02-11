@extends('layouts.dashboard')

@section('content')
    <div class="w-full rounded-lg bg-white shadow" id="wrapper">
        <div class="p-4">
            <div class="mb-2 flex items-center justify-between">
                <h3 class="text-lg font-semibold">Users</h3>
                <x-button
                    id="newUser"
                    hx-get="{{ route('admin.users.create') }}"
                    hx-target="#dialog"
                    hx-swap="innerHTML"
                >New User</x-button>
            </div>
            <div>
                <label for="simple-search" class="sr-only">Search</label>
                <div class="relative w-1/3">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg
                            aria-hidden="true"
                            class="h-5 w-5 text-gray-500 dark:text-gray-400"
                            fill="currentColor"
                            viewbox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </div>
                    <input
                        name="q"
                        class="focus:ring-primary-500 focus:border-primary-500 mb-4 block w-full rounded border border-gray-300 bg-gray-50 p-2 pl-10 text-sm text-gray-900"
                        placeholder="Search for user..."
                        hx-get="{{ route('admin.users') }}"
                        hx-push-url="true"
                        hx-target="#users-table"
                        hx-swap="outerHTML"
                        hx-trigger="keyup changed delay:1s"
                    >
                </div>
            </div>
        </div>
        @fragment('table')
            <div
                id="users-table"
                hx-get=""
                hx-trigger="loadUsers from:body"
                hx-target="#users-table"
                hx-swap="outerHTML"
            >
                <table class="min-w-full table-auto text-left text-sm">
                    <thead class="text-navyblue-500">
                        <tr class="border-b-2 leading-[20px]">
                            <th class="bg-gray-100 px-4 py-2" scope="col"></th>
                            <th class="bg-gray-100 px-4 py-2" scope="col">Name</th>
                            <th class="bg-gray-100 px-4 py-2" scope="col">Start / Finish year</th>
                            <th class="bg-gray-100 px-4 py-2" scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($users))
                            @foreach ($users as $index => $user)
                                <tr class="border-b border-gray-100 text-gray-700 hover:bg-gray-50" id="user-{{ $user->id }}">
                                    <td class="w-[1%] whitespace-nowrap p-4 text-center" scope="row">{{ $index + $users->firstItem() }}</td>
                                    <td class="p-4" scope="row">{{ $user->name }}</td>
                                    <td class="p-4" scope="row">{{ $user->uni_start_year }} / {{ $user->uni_finish_year }}</td>
                                    <td class="flex justify-end space-x-2 p-4" scope="row">
                                        <x-button
                                            id="view-user"
                                            hx-get="{{ route('admin.users.show', $user->id) }}"
                                            hx-target="#dialog"
                                            hx-swap="innerHTML"
                                        >View</x-button>
                                        <x-button
                                            id="editUser"
                                            hx-get="{{ route('admin.users.edit', $user->id) }}"
                                            hx-target="#dialog"
                                            hx-swap="innerHTML"
                                        >Edit</x-button>
                                        <x-button
                                            id="deleteUser"
                                            style="danger"
                                            hx-get="{{ route('admin.users.delete', $user->id) }}"
                                            hx-target="#dialog"
                                            hx-swap="innerHTML"
                                        >Delete</x-button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>

                <div
                    id="pagination-links"
                    hx-boost="true"
                    hx-target="#users-table"
                    hx-swap="outerHTML"
                    class="px-4 py-2"
                >
                    {{ $users->links() }}
                </div>
            @endfragment
        </div>
    </div>
@endsection
