@extends('layouts.home')

@section('content')
    <div class="mt-4 h-screen rounded-xl bg-white p-4 shadow-lg">
        <textarea class="mb-2 block w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-300 focus:outline-none"></textarea>
        <button type="submit"
            class="rounded-md bg-[#4D5BFC] px-3 py-1 text-white">Post</button>
    </div>
@endsection
