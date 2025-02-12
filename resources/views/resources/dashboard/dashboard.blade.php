@extends('layouts.dashboard')

@section('content')
    <div class="w-full rounded bg-white p-4 shadow">
        <h3 class="mb-2 text-lg font-semibold">Statistics</h3>
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
@endsection
