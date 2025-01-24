<div id="users-table">
    <table class="w-full table-fixed text-left">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->name }}</td>
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
