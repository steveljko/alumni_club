<div class="w-full overflow-y-scroll bg-white md:w-[320px]">
    <ul class="flex h-screen flex-col justify-between p-4">
        <div>
            <x-sidebar-nav-item route="admin.dashboard">
                <x-slot:icon><x-icon-house /></x-slot:icon>
                Dashobard
            </x-sidebar-nav-item>
            <x-sidebar-nav-item route="admin.users">
                <x-slot:icon><x-icon-user /></x-slot:icon>
                Users
            </x-sidebar-nav-item>
            <x-sidebar-nav-item route="admin.posts">
                <x-slot:icon><x-icon-post /></x-slot:icon>
                Posts
            </x-sidebar-nav-item>
            <x-sidebar-nav-item route="admin.settings">
                <x-slot:icon><x-icon-settings /></x-slot:icon>
                App Settings
            </x-sidebar-nav-item>
            <div class="my-2 h-[1px] w-full bg-gray-200"></div>
            <li><a class="flex cursor-pointer items-center rounded-md p-3 text-start font-semibold leading-tight text-gray-600 transition duration-500 hover:bg-gray-200 hover:text-blue-700"
                    hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'
                    hx-delete="{{ route('auth.logout') }}">
                    <x-icon-logout />
                    Logout
                </a></li>
        </div>
        <div>
            <li class="flex items-center justify-between p-2">
                <span class="truncate">{{ auth()->user()->name }}</span>
                <a href="{{ route('auth.settings') }}">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.25"
                        stroke="currentColor"
                        class="size-[24px] text-gray-600">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M10.343 3.94c.09-.542.56-.94 1.11-.94h1.093c.55 0 1.02.398 1.11.94l.149.894c.07.424.384.764.78.93.398.164.855.142 1.205-.108l.737-.527a1.125 1.125 0 0 1 1.45.12l.773.774c.39.389.44 1.002.12 1.45l-.527.737c-.25.35-.272.806-.107 1.204.165.397.505.71.93.78l.893.15c.543.09.94.559.94 1.109v1.094c0 .55-.397 1.02-.94 1.11l-.894.149c-.424.07-.764.383-.929.78-.165.398-.143.854.107 1.204l.527.738c.32.447.269 1.06-.12 1.45l-.774.773a1.125 1.125 0 0 1-1.449.12l-.738-.527c-.35-.25-.806-.272-1.203-.107-.398.165-.71.505-.781.929l-.149.894c-.09.542-.56.94-1.11.94h-1.094c-.55 0-1.019-.398-1.11-.94l-.148-.894c-.071-.424-.384-.764-.781-.93-.398-.164-.854-.142-1.204.108l-.738.527c-.447.32-1.06.269-1.45-.12l-.773-.774a1.125 1.125 0 0 1-.12-1.45l.527-.737c.25-.35.272-.806.108-1.204-.165-.397-.506-.71-.93-.78l-.894-.15c-.542-.09-.94-.56-.94-1.109v-1.094c0-.55.398-1.02.94-1.11l.894-.149c.424-.07.765-.383.93-.78.165-.398.143-.854-.108-1.204l-.526-.738a1.125 1.125 0 0 1 .12-1.45l.773-.773a1.125 1.125 0 0 1 1.45-.12l.737.527c.35.25.807.272 1.204.107.397-.165.71-.505.78-.929l.15-.894Z" />
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </a>
            </li>
        </div>
    </ul>
</div>
