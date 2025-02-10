@extends('layouts.dashboard')

@section('content')
    @fragment('wrapper')
        <div class="w-full rounded-lg bg-white shadow" id="wrapper">
            <div class="flex items-center justify-between p-4">
                <h3 class="text-lg font-semibold">Posts</h3>
            </div>
            @fragment('table')
                <div id="posts-table">
                    <table class="min-w-full table-auto text-left text-sm">
                        <thead class="text-navyblue-500">
                            <tr class="border-b-2 leading-[20px]">
                                <th class="bg-gray-100" scope="col"></th>
                                <th class="bg-gray-100 px-4 py-2" scope="col">
                                    Date
                                </th>
                                <th class="bg-gray-100 px-4 py-2" scope="col">Status</th>
                                <th class="bg-gray-100 px-4 py-2" scope="col">Type</th>
                                <th class="bg-gray-100 px-4 py-2" scope="col">Published by</th>
                                <th class="bg-gray-100 px-4 py-2" scope="col">Comments</th>
                                <th class="bg-gray-100 px-4 py-2 text-right" scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($posts))
                                @foreach ($posts as $index => $post)
                                    <tr class="border-b border-gray-100 text-gray-700 hover:bg-gray-50" id="post-{{ $post->id }}">
                                        <td class="w-[1%] whitespace-nowrap p-4 text-center" scope="row">{{ $index + $posts->firstItem() }}</td>
                                        <td class="w-[1%] whitespace-nowrap p-4" scope="row">{{ $post->created_at->format('d M Y') }}</td>
                                        <td class="w-[1%] whitespace-nowrap p-4 capitalize" scope="row">
                                            {{ $post->status }}
                                        </td>
                                        <td class="w-[1%] whitespace-nowrap p-4 capitalize" scope="row">
                                            {{ $post->type }}
                                        </td>
                                        <td class="whitespace-nowrap p-4" scope="row">
                                            @if ($post->user != null)
                                                <a class="truncate break-all text-[#003366] hover:underline" href="{{ route('users.profile', $post->user) }}">
                                                    {{ $post->user?->name }}
                                                </a>
                                            @else
                                                <a class="text-gray-400">-</a>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap p-4" scope="row">
                                            {{ $post->comments_count }} comments
                                        </td>
                                        <td class="flex justify-end p-4" scope="row">
                                            <x-button
                                                id="view-post"
                                                hx-get="{{ route('admin.posts.show', $post) }}"
                                                hx-target="#wrapper"
                                                hx-swap="outerHTML"
                                                hx-push-url="true"
                                            >View</x-button>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>

                    <div
                        id="pagination-links"
                        class="px-4 py-2"
                        hx-boost="true"
                        hx-target="#wrapper"
                        hx-swap="outerHTML"
                    >
                        {{ $posts->links() }}
                    </div>
                </div>
            @endfragment
        </div>
    @endfragment
@endsection
