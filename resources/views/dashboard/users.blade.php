@extends('layouts.dashboard')

@section('content')
<x-right-sidebar id="updateUser" title="Izmeni korisnika">{!! $updateForm !!}</x-right-sidebar>

<div class="border border-gray-200 rounded mb-6">
    <div class="px-6 py-3 bg-gray-100 text-xs font-semibold text-gray-700 uppercase rounded">Pretraga</div>
    <div class="p-6 shadow space-x-6">
      {!! $searchForm !!}
    </div>
</div>

<h2 class="text-xl my-8">{{ __('additional.dashboard.users') }}</h2>

<div class="border border-gray-200 rounded mb-6">
    @include('markup/users_table')
    <x-pagination :model="$users"/>
</div>
@stop

@section('js')
const updateForm = window.Form.get('updateUser');

function load() {
    document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', (e) => {
            const user = JSON.parse(e.currentTarget.dataset.user);
            sessionStorage.setItem('user', JSON.stringify(user));

            updateForm.populate({
              id: user.id,
              name: user.name,
              email: user.email,
              role: user.role,
              uni_start_year: user.details.uni_start_year,
              uni_finish_year: user.details.uni_finish_year,
            });

            updateForm.toggleModal();
        });
    });
}

load();

updateForm.setOnSuccess(data => {
  document.querySelector('#users_table').innerHTML = data;
  load();
})

const searchForm = window.Form.get('searchForm');

searchForm.setOnSuccess(data => {
  document.querySelector('#users_table').innerHTML = data;
  load();
})
@endsection
