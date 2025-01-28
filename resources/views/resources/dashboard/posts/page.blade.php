@extends('layouts.dashboard')

@section('content')
    @fragment('wrapper')
        <div class="w-full p-4"
            id="wrapper">
            <div class="w-full rounded bg-white p-4 shadow">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-lg font-semibold">Posts</h3>
                </div>
                <div class="relative flex h-full w-full flex-col overflow-scroll rounded-xl border border-gray-200 bg-white bg-clip-border text-gray-700">
                    @fragment('table')
                        <div id="users-table"
                            hx-get=""
                            hx-trigger="loadUsers from:body"
                            hx-target="#users-table"
                            hx-swap="outerHTML">
                            <table class="w-full table-fixed text-left text-sm">
                                <thead class="border-b bg-gray-50 text-xs uppercase text-gray-700">
                                    <tr>
                                        <th class="w-8 p-4">#</th>
                                        <th class="w-1/6 p-4">Status</th>
                                        <th class="w-1/6 p-4">Type</th>
                                        <th class="w-1/6 p-4">Published by</th>
                                        <th class="p-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($posts))
                                        @foreach ($posts as $index => $post)
                                            <tr class="border-b odd:bg-white even:bg-gray-50"
                                                id="post-{{ $post->id }}">
                                                <td class="p-4">{{ $index + $posts->firstItem() }}</td>
                                                <td class="p-4 text-xs font-semibold uppercase">{{ $post->status }}</td>
                                                <td class="p-4 text-xs font-semibold uppercase">{{ $post->type }}</td>
                                                <td class="p-4">
                                                    @if ($post->user != null)
                                                        <a class="truncate break-all text-blue-500 hover:underline"
                                                            href="{{ route('profile', $post->user) }}">
                                                            {{ $post->user?->name }}
                                                        </a>
                                                    @else
                                                        <a class="text-gray-400">-</a>
                                                    @endif
                                                </td>
                                                <td class="p-4">
                                                    <a hx-get="{{ route('admin.posts.show', $post) }}"
                                                        hx-target="#wrapper"
                                                        hx-swap="outerHTML"
                                                        hx-push-url="true"
                                                        class="cursor-pointer font-semibold uppercase">View</a>
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
                                {{ $posts->links() }}
                            </div>
                        </div>
                    @endfragment
                </div>
            </div>
        </div>
    @endfragment
@endsection
