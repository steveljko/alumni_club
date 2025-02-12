@extends('layouts.home')

@section('content')
    <div class="container mx-auto">
        <section
            hx-get=""
            hx-trigger="loadPosts from:body"
            hx-target="#posts"
            hx-swap="innerHTML"
            class="mt-6 w-full space-y-4 md:w-2/3"
        >
            @can('create post')
                <x-postbox />
                <div class="my-6 h-[1px] w-full bg-gray-200"></div>
            @endcan
            <section class="space-y-4" id="posts">
                @fragment('posts')
                    @foreach ($posts as $post)
                        <x-post-card :post="$post" />
                    @endforeach
                    @if ($posts->hasMorePages())
                        <span
                            hx-get="{{ $posts->nextPageUrl() }}"
                            hx-target="#posts"
                            hx-swap="beforeend"
                            hx-trigger="revealed"
                            hx-indicator="#spinner"
                        ></span>
                        <x-icons.spinner class="htmx-indicator mx-auto hidden h-5 w-5 animate-spin [&.htmx-request]:block" id="spinner" />
                    @endif
                @endfragment
            </section>
        </section>
    </div>
@endsection
