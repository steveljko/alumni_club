@extends('layouts.dashboard')

@section('content')
    @fragment('wrapper')
        <div class="w-full rounded-lg bg-white p-4 shadow"
            id="wrapper">
            <div class="mb-4 flex items-center justify-between">
                <div class="inline-flex items-center space-x-3">
                    <x-icon-arrow-left hx-get="{{ route('admin.posts') }}"
                        hx-target="#wrapper"
                        hx-swap="outerHTML"
                        hx-push-url="true"
                        class="h-4 w-4 cursor-pointer" />
                    <h3 class="text-lg font-semibold">Posts</h3>
                </div>
                <x-button id="editPost"
                    size="sm">Edit</x-button>
            </div>
            <div class="space-y-4">
                <div class="flex space-x-8">
                    <div>
                        <label class="mb-2 block text-sm font-medium uppercase text-gray-700">Type</label>
                        <span
                            class="inline-block rounded-full bg-[#A3CEFF] bg-blue-400 px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.08em] text-[#0B417D]">{{ $post->type }}</span>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium uppercase text-gray-700">Status</label>
                        <span
                            class="inline-block rounded-full bg-[#A3CEFF] bg-blue-400 px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.08em] text-[#0B417D]">{{ $post->status }}</span>
                    </div>
                </div>


                @if ($post->isDefault())
                    <div class="my-4">
                        <label class="mb-2 block text-sm font-medium uppercase text-gray-700">Body</label>
                        <p class="break-all text-sm leading-8 text-gray-800">{{ $post->default->body }}</p>
                    </div>
                @elseif ($post->isEvent())
                    <div class="my-4 space-y-4">
                        <div>
                            <label class="mb-2 block text-sm font-medium uppercase text-gray-700">Title</label>
                            <span class="text-sm">{{ $post->event->title }}</span>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium uppercase text-gray-700">Description</label>
                            <span>{{ $post->event->description }}</span>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium uppercase text-gray-700">Start and End time</label>
                            <span>{{ $post->event->start_time }}</span>
                            <span>{{ $post->event->end_time }}</span>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium uppercase text-gray-700">Address and City</label>
                            <span>{{ $post->event->address }}, {{ $post->event->city }}</span>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium uppercase text-gray-700">Event Page URL</label>
                            <span>{{ urldecode($post->event->url()) }}</span>
                        </div>
                    </div>
                @elseif ($post->isJob())
                    <div class="my-4 space-y-4">
                        <div>
                            <label class="mb-2 block text-sm font-medium uppercase text-gray-700">Position</label>
                            <span class="text-sm">{{ $post->job->position }}</span>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium uppercase text-gray-700">Description</label>
                            <span class="text-sm">{{ $post->job->description }}</span>
                        </div>
                        <div class="flex space-x-10">
                            <div>
                                <label class="mb-2 block text-sm font-medium uppercase text-gray-700">Company Name</label>
                                <span class="text-sm">{{ $post->job->company_name }}</span>
                            </div>
                            <div>
                                <label class="mb-2 block text-sm font-medium uppercase text-gray-700">Company Website URL</label>
                                <span class="text-sm">{{ $post->job->company_website_url }}</span>
                            </div>
                            <div>
                                <label class="mb-2 block text-sm font-medium uppercase text-gray-700">Company Address and City</label>
                                <span class="text-sm">{{ $post->job->company_address }}, {{ $post->job->company_city }}</span>
                            </div>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium uppercase text-gray-700">Start and End time</label>
                            <span class="text-sm">{{ $post->job->start_time->format('d M y h:i A') }} -
                                {{ $post->job->end_time->format('d M y h:i A') }}</span>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium uppercase text-gray-700">Job Page URL</label>
                            <span class="text-sm">{{ urldecode($post->job->url()) }}</span>
                        </div>
                    </div>
                @endif

                <div class="mb-2">
                    <label class="mb-2 block text-sm font-medium uppercase text-gray-700">Published By</label>
                    @if ($post->user != null)
                        <a class="block cursor-pointer truncate break-all text-sm text-blue-500 hover:underline"
                            href="{{ route('profile', $post->user) }}">
                            {{ $post->user?->name }}
                        </a>
                    @else
                        <a class="block text-gray-400">-</a>
                    @endif
                </div>

                <ul class="block">
                    <label class="mb-2 block text-sm font-medium uppercase text-gray-700">Comments</label>
                    <div class="divide-y divide-gray-200">
                        @if ($post->comments_count >= 1)
                            @foreach ($post->comments as $comment)
                                <li class="py-2">
                                    <span class="mb-2 block">{{ $comment->content }}</span>
                                    <span class="block text-sm text-gray-700">by {{ $comment->user->name }} in
                                        {{ $comment->created_at->diffForHumans() }}</span>
                                </li>
                            @endforeach
                        @else
                            <p>No comments found!</p>
                        @endif
                    </div>
                </ul>
            </div>
        </div>
    @endfragment
@endsection
