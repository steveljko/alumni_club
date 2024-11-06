@extends('layouts.dashboard')

@section('content')
<x-right-sidebar id="updateUser" title="Izmeni korisnika">{!! $updateForm !!}</x-right-sidebar>

<h2 class="text-xl my-8">{{ __('additional.dashboard.users') }}</h2>

<div class="border border-gray-200 rounded mb-6">
    <div class="px-6 py-3 bg-gray-100 text-xs font-semibold text-gray-700 uppercase rounded">Pretraga</div>
    <div class="p-6 shadow space-x-6">
        <form action="{{ route('web.dashboard.users') }}" method="GET">
          @csrf
          <div class="flex space-x-4">
              <div class="flex flex-col w-full">
                <label for="name" class="text-xs font-semibold text-gray-600 uppercase mb-2">Ime i Prezime</label>
                <input
                  class="p-2 h-10 border border-gray-300 rounded-md"
                  type="text"
                  name="name"
                  value="{{ request('name') }}"
                >
              </div>
              <div class="flex flex-col w-full">
                <label for="uni_start_year" class="uppercase text-xs font-semibold text-gray-600 uppercase mb-2">Godina upisa</label>
                <select
                  name="uni_start_year"
                  class="p-2 h-10 bg-white border border-gray-300 rounded-md"
                >
                    <option selected disabled>Izaberite godinu upisa</option>
                    @foreach (range(1910, date('Y')) as $year)
                        <option value="{{ $year }}" {{ request('uni_start_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
              </div>
              <div class="flex items-end">
                  <button class="w-[200px] h-10 bg-blue-700 text-white rounded">Pretraži</button>
              </div>
          </div>
        </form>
    </div>
</div>

<div class="border border-gray-200 rounded mb-6">
    <table class="w-full min-w-full table-auto select-none">
        <thead class="bg-gray-100 text-xs text-gray-700 border-b border-gray-200 uppercase">
            <tr>
                <th scope="col" class="py-3 text-center">#</th>
                <th scope="col" class="px-6 py-3 text-left">Ime</th>
                <th scope="col" class="px-6 py-3 text-left">Godina upisa</th>
                <th scope="col" class="px-6 py-3 text-left"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr class="hover:bg-gray-100 hover:cursor-pointer">
                <td scope="row" class="w-[2.5rem] py-4 font-medium text-gray-900 whitespace-nowrap text-center">{{ $users->firstItem() + $loop->index }}</td>
                <td scope="row" class="px-6 py-4 text-left">{{ $user->name }}</td>
                <td scope="row" class="px-6 py-4 text-left">{{ $user->details->uni_start_year }}</td>
                <td scope="row" class="px-6 py-4 text-right">
                    <a href="#" data-user="{{ $user }}" class="edit-button | inline-flex items-center font-medium text-sm text-yellow-500">
                        @svg('far-edit', 'w-4 h-4 text-yellow-500 mr-1')
                        Izmeni
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <x-pagination :model="$users"/>
</div>
@stop

@section('js')
const datasetAsJson = (doc, name) => JSON.parse(doc.dataset[name]);

const updateForm = window.Form.getByName('updateUser');

# TODO: Good idea for making this possible
updateForm.describe([]);
updateForm.populate(user);

document.querySelectorAll('.edit-button').forEach(button => {
    button.addEventListener('click', function() {
        const user = datasetAsJson(this, 'user');

        sessionStorage.setItem('user', JSON.stringify(user));

        updateForm.setField('name', user.name);
        updateForm.setField('email', user.email);
        updateForm.setField('role', user.role);

        updateForm.toggleFormModal();
    });
});

const user = JSON.parse(sessionStorage.getItem('user'));
const visible = new URL(window.location.href).searchParams.get('v');

if (user && visible) {
  updateForm.setField('name', user.name);
  updateForm.setField('email', user.email);
  updateForm.setField('role', user.role);

  updateForm.toggleFormModal();
}
@endsection
