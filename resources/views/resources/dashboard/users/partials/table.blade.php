<tbody id="user-table-body">
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
