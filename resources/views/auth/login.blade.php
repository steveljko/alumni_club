@extends('layouts.default')

@section('content')
<div class="w-1/4 mx-auto p-6 border border-gray-200 rounded">
    <form method="POST" action="{{ route('web.auth.login.handle') }}">
      @csrf
      <div class="block mb-3">
          <input
            type="email"
            name="email"
            class="w-full px-2 py-1 border border-gray-300 rounded"
            placeholder="Email address"
        >
      </div>
      <div class="block mb-3">
          <input
            type="password"
            name="password"
            class="w-full px-2 py-1 border border-gray-300 rounded"
            placeholder="Password"
        >
      </div>
      <div class="block">
        <button type="submit" class="w-full py-2 bg-blue-500 rounded">Sign In</button>
      </div>
    </form>
</div>
@stop
