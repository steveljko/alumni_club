@extends('layouts.home')

@section('content')
    <div class="container mx-auto">
        <section class="mt-6 w-full space-y-4 md:w-2/3">
            @can('create post')
                <x-postbox />
                <div class="my-6 h-[1px] w-full bg-gray-200"></div>
            @endcan
            @foreach ($posts as $post)
                <x-post-card :post="$post" />
            @endforeach
        </section>
    </div>
@endsection
