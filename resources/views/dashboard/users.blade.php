@extends('layouts.dashboard')

@section('content')
<h2 class="text-xl my-8">{{ __('additional.dashboard.users') }}</h2>

<div class="px-6 py-3 text-xs text-gray-700 uppercase bg-gray-100 rounded">Pretraga</div>
<div class="p-6 border border-gray-200 shadow space-x-6">
    <form action="{{ route('dashboard.users') }}" method="GET">
      @csrf
      <div class="flex">
          <div class="flex flex-col w-full">
            <label for="name" class="text-sm font-semibold text-gray-600 uppercase mb-2">Ime i Prezime</label>
            <input
              class="p-2 border border-gray-200 rounded-md"
              type="text"
              name="name"
              value="{{ request('name') }}"
            >
          </div>
          <div class="flex flex-col w-full">
            <label for="uni_start_year" class="text-sm font-semibold text-gray-600 uppercase mb-2">Godina upisa</label>
            <select name="uni_start_year" class="p-2 bg-white border border-gray-200 rounded-md">
                <option value="2010">2010</option>
                <option value="2011">2011</option>
            </select>
          </div>
          <div>
          <button class="w-[240px] bg-blue-700 text-white rounded">Pretraži</button>
          </div>
      </div>
    </form>
</div>

<table class="table-auto text-left w-full shadow">
    <thead class="text-xs text-gray-700 uppercase bg-gray-100 rounded">
        <tr>
            <th scope="col" class="px-6 py-3">#</th>
            <th scope="col" class="px-6 py-3">Name</th>
            <th scope="col" class="px-6 py-3">Uni start year</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
          <td scope="row" class="w-[6%] px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $users->firstItem() + $loop->index }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->details->uni_start_year }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<x-pagination :model="$users"/>
@stop
