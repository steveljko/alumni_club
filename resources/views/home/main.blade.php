@extends('layouts.home')

@section('content')
    <div class="container mx-auto">
        <div class="my-6 flex items-center justify-between">
            <h3 class="text-xl">Feed</h3>

            <a class="rounded-md bg-[#4D5BFC] px-3 py-1 text-white"
                href="{{ route('post.create') }}">Create post</a>
        </div>
        <section class="w-full space-y-4 md:w-2/3">
            @foreach ($posts as $post)
                <x-post-card :post="$post" />
            @endforeach
        </section>
    </div>
@endsection
