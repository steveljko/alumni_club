<div class="sticky top-4 w-[15%] overflow-y-scroll">
    <ul>
        <li class="p-2"><a class="block rounded-md px-3 py-2 hover:bg-blue-400"
                href="{{ route('home') }}">Home</a></li>
        <div class="h-[1px] w-full bg-gray-200"></div>
    </ul>
    @auth
        <li>
            {{ auth()->user()->name }}
        </li>
    @endauth
</div>
