<div id="users-table"
    hx-get=""
    hx-trigger="loadUsers from:body">
    <table class="w-full min-w-max table-auto text-left">
        <thead>
            <tr>
                <th class="w-8 p-4">#</th>
                <th class="p-4">Name</th>
                <th class="p-4"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->name }}</td>
                    <td>
                        <a hx-get="{{ route('admin.users.edit', $user->id) }}"
                            hx-target="#modal"
                            class="cursor-pointer">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div id="pagination-links"
        hx-boost="true"
        hx-target="#users-table">
        {{ $users->links() }}
    </div>
</div>
