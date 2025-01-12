@extends('layouts.home')

@section('content')
    <div class="container mx-auto mt-4">
        <div class="flex w-full items-start space-x-4">
            <div class="flex h-auto w-2/6 flex-col items-center space-y-[32px] rounded-md bg-white p-4 shadow">
                <img class="h-[200px] w-[200px] rounded-full"
                    src="{{ asset('storage/images/' . $user->avatar) }}"
                    alt="user photo">
                <h3 class="text-xl">{{ $user->name }}</h3>
                <div class="w-full border border-gray-200">
                    <div class="p-2">
                        <span class="text-xs font-semibold uppercase text-gray-700">About</span>
                        <p class="text-gray-700">{{ $user->bio }}</p>
                    </div>
                    <div class="p-2">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-semibold uppercase text-gray-700">Current Job</span>
                            <a href="#"
                                class="text-sm hover:underline">See History</a>
                        </div>
                        <p class="text-gray-700">{{ $user->bio }}</p>
                    </div>
                    <div class="p-2">
                        <span class="text-xs font-semibold uppercase text-gray-700">Statistics</span>
                        <div>
                            <h3>Posts</h3>
                            <span>{{ $user->posts->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full rounded-md bg-white p-4 shadow">
                <div class="mb-4 flex items-center justify-between">
                    @fragment('posts-count')
                        <h3 id="count"
                            class="text-lg font-semibold">
                            Previous Posts
                            <span class="font-medium text-gray-500">({{ $user->posts->count() }})</span>
                        </h3>
                    @endfragment
                    <select name="type"
                        hx-get=""
                        hx-trigger="change"
                        hx-include="[name='type']"
                        hx-target="#posts"
                        hx-select-oob="#count:outerHTML,#posts:innerHTML"
                        autocomplete="off">
                        <option value=""
                            selected>All</option>
                        <option value="default">Default</option>
                        <option value="event">Events</option>
                        <option value="job">Jobs</option>
                    </select>
                </div>

                <div class="space-y-4"
                    id="posts">
                    @fragment('posts')
                        @foreach ($user->posts as $post)
                            <x-post-card :post="$post" />
                        @endforeach
                    @endfragment
                </div>
            </div>
        </div>
    </div>
@endsection
