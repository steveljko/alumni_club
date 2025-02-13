@extends('layouts.dashboard')

@section('content')
    <div class="w-full rounded bg-white shadow">
        <div class="p-4">
            <h3 class="mb-4 text-lg font-semibold">Statistics</h3>
            <div class="flex space-x-4">
                <div class="w-full rounded border border-gray-200 p-4 shadow-sm">
                    <p class="mb-2 block text-sm font-medium text-gray-500">Users count</p>
                    <span>{{ $stats['users_count'] }}</span>
                </div>
                <div class="w-full rounded border border-gray-200 p-4 shadow-sm">
                    <p class="mb-2 block text-sm font-medium text-gray-500">Posts count</p>
                    <span>{{ $stats['posts_count'] }}</span>
                </div>
                <div class="w-full rounded border border-gray-200 p-4 shadow-sm">
                    <p class="mb-2 block text-sm font-medium text-gray-500">Comments count</p>
                    <span>{{ $stats['comments_count'] }}</span>
                </div>
            </div>
        </div>

        <div>
            <h3 class="mb-4 ml-4 text-lg font-semibold">Latest Activities</h3>
            <table class="min-w-full table-auto text-left text-sm">
                <thead class="text-navyblue-500">
                    <tr class="border-b-2 leading-[20px]">
                        <th class="bg-gray-100 px-4 py-2" scope="col">Event</th>
                        <th class="bg-gray-100 px-4 py-2" scope="col">Model</th>
                        <th class="bg-gray-100 px-4 py-2" scope="col">User</th>
                        <th class="bg-gray-100 px-4 py-2" scope="col">Done at</th>
                        <th class="bg-gray-100 px-4 py-2" scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($activities as $index => $activity)
                        <tr class="border-b border-gray-100 text-gray-700 hover:bg-gray-50" id="user-{{ $activity->id }}">
                            <td class="w-[10%] whitespace-nowrap p-4" scope="row">{{ $activity->event }}</td>
                            <td class="w-[10%] whitespace-nowrap p-4" scope="row">{{ $activity->model_name }}</td>
                            <td class="w-[1%] whitespace-nowrap p-4" scope="row">
                                <a href="{{ route('users.profile', $activity->user) }}" class="text-navyblue-500 hover:underline">
                                    {{ $activity->user->name }}
                                </a>
                            </td>
                            <td class="p-4" scope="row">{{ $activity->created_at->diffForHumans() }}</td>
                            <td class="flex justify-end space-x-2 p-4" scope="row">
                                <x-button
                                    id="view-user"
                                    hx-get="{{ route('admin.dashboard.activity.show', $activity) }}"
                                    hx-target="#dialog"
                                    hx-swap="innerHTML"
                                >View</x-button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
