<div
    id="user-profile-menu"
    class="hidden transition duration-500"
    tabindex="-1"
>
    <div
        class="absolute right-0 z-50 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md border border-gray-200 bg-white shadow-lg outline-none"
        role="menu"
        tabindex="-1"
        id="user-profile-menu-content"
    >
        <div class="px-4 py-3">
            <p class="truncate text-sm font-medium leading-5 text-gray-900">{{ auth()->user()->name }}</p>
            <p class="text-sm leading-5 text-gray-600">{{ auth()->user()->email }}</p>
        </div>
        <div class="py-1">
            <a
                class="flex w-full cursor-pointer justify-between px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100"
                role="menuitem"
                href="{{ route('users.profile', auth()->user()) }}"
            >Profile</a>
            <a
                class="flex w-full cursor-pointer justify-between px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100"
                role="menuitem"
                href="{{ route('users.settings') }}"
            >Account Settings</a>
            @role('admin')
                <a
                    class="flex w-full cursor-pointer justify-between px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100"
                    role="menuitem"
                    href="{{ route('admin.dashboard') }}"
                >Admin Dashboard</a>
            @endrole
            <a
                class="flex w-full cursor-pointer justify-between px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100"
                role="menuitem"
                hx-delete="{{ route('auth.logout') }}"
            >Sign out</a>
        </div>
    </div>
</div>
