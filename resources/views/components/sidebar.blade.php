<div class="sticky top-0 h-screen w-1/6 overflow-y-scroll border-r bg-white shadow">
    <ul class="flex h-screen w-full flex-col justify-between p-4">
        <div class="space-y-2">
            <x-sidebar-nav-item route="admin.dashboard">
                <x-slot:icon><x-icons.house /></x-slot:icon>
                Dashobard
            </x-sidebar-nav-item>
            <x-sidebar-nav-item route="admin.users">
                <x-slot:icon><x-icons.user /></x-slot:icon>
                Users
            </x-sidebar-nav-item>
            <x-sidebar-nav-item route="admin.posts">
                <x-slot:icon><x-icons.post /></x-slot:icon>
                Posts
            </x-sidebar-nav-item>
            <x-sidebar-nav-item route="admin.settings">
                <x-slot:icon><x-icons.settings /></x-slot:icon>
                App Settings
            </x-sidebar-nav-item>
            <div class="my-2 h-[1px] w-full bg-gray-200"></div>
            <x-sidebar-nav-item route="home">
                <x-slot:icon><x-icons.house /></x-slot:icon>
                Home
            </x-sidebar-nav-item>
        </div>
    </ul>
</div>
