@extends('layouts.default')

@section('content')
<div class="flex items-center justify-center min-h-screen">
    <div class="w-1/4 mx-auto p-6 border border-gray-200 shadow-sm rounded-xl">
        <form method="POST" action="{{ route('web.auth.login.handle') }}">
          @csrf
          <div class="block mb-3">
              <label for="email" class="block text-xs font-semibold text-gray-600 uppercase mb-2">Email adresa</label>
              <input
                type="email"
                name="email"
                class="w-full px-2 py-1 border border-gray-300 rounded mb-2"
                placeholder="Email address"
                value="{{ old('email') }}"
            >
            @error('email')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
          </div>
          <div class="block mb-3">
              <label for="password" class="block text-xs font-semibold text-gray-600 uppercase mb-2">Šifra</label>
              <input
                type="password"
                name="password"
                class="w-full px-2 py-1 border border-gray-300 rounded mb-2"
                placeholder="Password"
                value="{{ old('password') }}"
            >
            @error('password')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
          </div>
          <div class="block">
            <button type="submit" class="w-full py-2 bg-blue-500 font-semibold text-blue-950 rounded">Sign In</button>
          </div>
        </form>
    </div>
</div>
@stop
