<table id="users_table" class="w-full min-w-full table-auto select-none">
    <thead class="bg-gray-100 text-xs text-gray-700 border-b border-gray-200 uppercase">
        <tr>
            <th scope="col" class="py-3 text-center">#</th>
            <th scope="col" class="px-6 py-3 text-left">Ime</th>
            <th scope="col" class="px-6 py-3 text-left">Godina upisa</th>
            <th scope="col" class="px-6 py-3 text-left"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $key => $user)
        <tr
          class="hover:bg-gray-100 hover:cursor-pointer"
          data-index="{{ $key }}"
        >
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
