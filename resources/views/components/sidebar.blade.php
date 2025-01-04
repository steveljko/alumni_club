<div class="sticky top-4 w-[15%] overflow-y-scroll">
    <ul>
        <li class="p-2"><a class="block rounded-md px-3 py-2 hover:bg-blue-400"
                href="{{ route('home') }}">Home</a></li>
        <div class="h-[1px] w-full bg-gray-200"></div>
        <li class="p-2"><a class="block rounded-md px-3 py-2 hover:bg-blue-400"
                hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'
                hx-delete="{{ route('auth.logout') }}">Logout</a></li>
    </ul>
    @auth
        <li>
            {{ auth()->user()->name }}
        </li>
    @endauth
</div>
