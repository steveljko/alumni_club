@extends('layouts.default')

@section('content')
    <div class="flex h-screen w-full items-center justify-center">
        <div class="w-1/3 space-y-6 rounded-lg bg-white px-4 py-6 shadow">
            <div class="text-center">
                <p class="mb-2 break-all text-gray-700">You are being redirected to <strong>{{ $url }}</strong>.</p>
                <p class="text-sm text-gray-500">Please click <i>'Proceed to Url'</i> to continue or <i>'Back to Previous Page'</i> to return to the
                    previous
                    page.</p>
            </div>
            <div class="flex items-center justify-center space-x-4">
                <a href="{{ url()->previous() }}"
                    class="rounded bg-gray-100 px-3 py-1 text-gray-700">Back to Previous Page</a>
                <a href="{{ $url }}"
                    class="rounded bg-blue-500 px-3 py-1 text-white">Proceed to Url</a>
            </div>
        </div>
    </div>
@endsection
