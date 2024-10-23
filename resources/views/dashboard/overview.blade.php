@extends('layouts.dashboard')

@section('content')
<h2 class="text-xl my-4">{{ __('additional.dashboard.overview') }}</h2>
{{ Auth::user()->name }}
@stop
