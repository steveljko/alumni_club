@extends('layouts.dashboard')

@section('content')
<!-- Edit Modal -->
<div id="editModal" class="fixed inset-0 z-50 flex justify-end bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-tl-lg shadow-lg p-6 mt-2 w-1/3">
        <div>
            <span id="close" class="cursor-pointer text-gray-500 float-right">&times;</span>
            <h2 class="text-lg font-semibold mb-4">Izmeni korisnika</h2>
        </div>
        <div>
            <form id="editForm">
                @csrf
                <input type="hidden" name="id" id="itemId">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Ime</label>
                    <input type="text" name="name" id="modalName" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email adresa</label>
                    <input type="text" name="email" id="modalEmail" required class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                </div>

                <div class="w-full mb-4 flex space-x-4">
                  <div class="w-full">
                    <label for="name" class="block text-sm font-medium text-gray-700">Godina upisa</label>
                    <select
                        name="uni_start_year"
                        id="modalUniStartYear"
                        class="block w-full p-2 h-10 bg-white border border-gray-300 rounded-md"
                    >
                        <option selected disabled>Izaberite godinu upisa</option>
                        @foreach (range(1910, date('Y')) as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                  </div>
                  <div class="w-full">
                    <label for="name" class="block text-sm font-medium text-gray-700">Godina završetka</label>
                    <select
                        name="uni_finish_year"
                        id="modalUniFinishYear"
                        class="block w-full p-2 h-10 bg-white border border-gray-300 rounded-md"
                    >
                        <option selected disabled>Izaberite godinu završetka</option>
                        @foreach (range(1910, date('Y')) as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                  </div>
                </div>

                <button type="submit" class="w-full bg-blue-500 text-white rounded-md p-2 hover:bg-blue-600">Sačuvaj izmene</button>
            </form>

            <div class="w-full my-4 h-[1px] bg-gray-300"></div>

            <h2>Zatrazi promenu sifre</h2>
        </div>
    </div>
</div>

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
                  <a href="#" data-user="{{ $user }}" class="edit-button | px-2 py-1 bg-blue-700 font-semibold text-sm text-blue-950 uppercase rounded-md mr-2">Pogledaj</a>
                  <a href="#" class="px-2 py-1 bg-yellow-500 font-semibold text-sm text-yellow-950 uppercase rounded-md">Izmeni</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <x-pagination :model="$users"/>
</div>

<script>
const setField = (id, value) => document.getElementById(id).value = value;
const datasetAsJson = (doc, name) => JSON.parse(doc.dataset[name]);

document.querySelectorAll('.edit-button').forEach(button => {
    button.addEventListener('click', function() {
        const user = datasetAsJson(this, 'user');

        setField('modalName', user.name);
        setField('modalEmail', user.email);
        setField('modalUniStartYear', Number(user.details.uni_start_year));
        setField('modalUniFinishYear', Number(user.details.uni_finish_year));

        document.getElementById('editModal').classList.remove('hidden');
    });
});

document.getElementById('close').addEventListener('click', function () {
  document.getElementById('editModal').classList.add('hidden');
});
</script>
@stop
