@extends('layouts.default')

@section('content')
    <x-modal-add-work />

    <div class="h-screen w-full md:flex md:items-center md:justify-center">
        <div class="h-screen w-full md:h-auto md:w-[30%]">
            <div class="rounded-xl bg-white p-4 shadow">
                <div class="mb-4">
                    <h2 class="mb-2 font-semibold">Work History</h2>
                    <p class="text-sm text-gray-500">If you have previous work history, add it, it will later generate CV automaticly for you.</p>
                </div>
                <form hx-put="{{ route('auth.setup.step.3') }}"
                    hx-swap="none">
                    <div class="flex w-full items-center justify-between">
                        <p class="text-gray-700">{{ $work->count() }} previous jobs added.</p>
                        <button hx-get=""
                            hx-target="#modal"
                            class="rounded-md bg-[#4D5BFC] px-2 py-[2px] text-sm font-semibold uppercase text-white">Add</button>
                    </div>
                    <div class="my-3 space-y-2 rounded-xl border border-gray-200 bg-gray-50 p-4">
                        @foreach ($work as $job)
                            <div class="rounded-md border border-gray-200 bg-white px-2 py-1 shadow-sm">
                                <p class="flex justify-between">
                                    <span class="font-bold">{{ $job->position }}</span>
                                    <span class="text-sm text-gray-600">
                                        {{ $job->start_date }}
                                        <span>-</span>
                                        @if ($job->end_date)
                                            {{ $job->end_date }}
                                        @else
                                            Present
                                        @endif
                                    </span>
                                </p>

                                <p>{{ $job->company_name }}</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex w-full items-center justify-end">
                        <a class="mr-3 font-bold uppercase"
                            href="#">Skip</a>
                        <button type="submit"
                            class="rounded-md bg-[#4D5BFC] px-3 py-1 text-white">Next</button>
                    </div>
                </form>
            </div>
            <p class="my-4 text-center text-gray-500">Logged in as {{ auth()->user()->name }}</p>
        </div>
    </div>
@endsection
