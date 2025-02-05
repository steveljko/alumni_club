<div class="h-screen w-1/6 overflow-y-scroll bg-white">
    <ul class="flex h-screen w-full flex-col justify-between p-4">
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
            <x-sidebar-nav-item route="auth.settings">
                <x-slot:icon><x-icon-gear /></x-slot:icon>
                Account Settings
            </x-sidebar-nav-item>
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
                </a>
            </li>
        </div>
    </ul>
</div>
