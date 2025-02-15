@extends('layouts.home')

@section('content')
    <div class="container mx-auto mt-4">
        <div class="mx-auto block w-full items-start space-y-4 lg:flex lg:space-x-4 lg:space-y-0">
            <div class="sticky top-4 flex h-auto w-full flex-col items-center space-y-8 rounded-md bg-white p-4 shadow lg:w-2/6">
                <img
                    class="h-[200px] w-[200px] rounded-full"
                    src="{{ asset('storage/images/' . $user->avatar) }}"
                    alt="user photo"
                >
                <h3 class="text-xl">{{ $user->name }}</h3>
                <div class="w-full">
                    @if ($user->bio)
                        <div class="p-2">
                            <span class="mb-2 block text-xs font-semibold uppercase text-gray-700">About</span>
                            <p class="text-sm text-gray-700">{{ $user->bio }}</p>
                        </div>
                    @endif
                    @if ($user->currentWork())
                        <div class="p-2">
                            <div class="flex items-center justify-between">
                                <span class="mb-2 block text-xs font-semibold uppercase text-gray-700">Current Job</span>
                                <a
                                    class="cursor-pointer text-sm hover:underline"
                                    hx-get="{{ route('users.workHistories.show', $user) }}"
                                    hx-target="#content"
                                >See History</a>
                            </div>
                            <div>
                                <p class="text-sm font-medium">{{ $user->currentWork()->position }}</p>
                                <a class="cursor-pointer text-xs text-gray-500">{{ $user->currentWork()->company_name }}</a>
                            </div>
                        </div>
                    @endif
                    <div class="p-2">
                        <span class="mb-2 block text-xs font-semibold uppercase text-gray-700">Statistics</span>
                        <div class="inline-flex w-full">
                            <div class="w-full">
                                <h3>Posts</h3>
                                <span>{{ $postCount }}</span>
                            </div>
                            <div class="w-full">
                                <h3>Comments</h3>
                                <span>{{ $commentCount }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full rounded-md bg-white shadow">
                <div class="flex space-x-2 p-4 pb-0">
                    <x-button
                        id="postsBtn"
                        size="sm"
                        hx-get="{{ route('users.profile.posts', $user) }}"
                        hx-target="#content"
                    >Posts</x-button>
                    <x-button
                        id="workHistoryBtn"
                        size="sm"
                        hx-get="{{ route('users.profile.workHistories', $user) }}"
                        hx-target="#content"
                    >Work History</x-button>
                </div>
                <div class="p-4" id="content">
                    @include('resources.post.show', [
                        'user' => $user,
                        'posts' => $user->posts,
                    ])
                </div>
            </div>
        </div>
    </div>
@endsection
