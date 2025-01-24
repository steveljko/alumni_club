@extends('layouts.home')

@section('content')
    <div class="container mx-auto mt-4">
        <div class="mb-2">
            <label class="mb-2 block text-gray-600">Post Type</label>
            <div class="flex space-x-2">
                <button class="rounded border px-2 py-1 text-sm font-semibold uppercase"
                    hx-get="{{ route('post.create.form', ['type' => 'default']) }}"
                    hx-swap="innerHTML"
                    hx-target="#form_wrapper">Default</button>
                <button class="rounded border px-2 py-1 text-sm font-semibold uppercase"
                    hx-get="{{ route('post.create.form', ['type' => 'event']) }}"
                    hx-swap="innerHTML"
                    hx-target="#form_wrapper">Event</button>
                <button class="rounded border px-2 py-1 text-sm font-semibold uppercase"
                    hx-get="{{ route('post.create.form', ['type' => 'job']) }}"
                    hx-swap="innerHTML"
                    hx-target="#form_wrapper">Job</button>
            </div>
        </div>
        <div id="form_wrapper">
            @include('posts.create_default_form')
        </div>
    </div>
@endsection
