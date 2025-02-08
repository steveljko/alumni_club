<nav class="w-full border-b border-gray-200 bg-white">
    <div class="container mx-auto w-full py-3">
        <div class="flex items-center justify-between">
            <a href="{{ route('home') }}">{{ config('settings.site_name') }}</a>
            <div id="account" class="relative">
                <button
                    type="button"
                    class="flex rounded-full bg-gray-800 text-sm focus:ring-2 focus:ring-gray-300 md:me-0 dark:focus:ring-gray-600"
                    aria-expanded="false"
                >
                    <span class="sr-only">Open user menu</span>
                    <img
                        class="h-8 w-8 rounded-full"
                        src="{{ asset('storage/images/' . auth()->user()->avatar) }}"
                        alt="user photo"
                    >
                </button>
                <!-- primary nav -->
                <div
                    id="account_dropdown"
                    class="hidden w-full transition duration-500"
                    tabindex="-1"
                >
                    <div class="absolute right-0 z-50 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md border border-gray-200 bg-white shadow-lg outline-none"
                        role="menu"
                    >
                        <div class="px-4 py-3">
                            <p class="text-sm leading-5">Signed in as</p>
                            <p class="truncate text-sm font-medium leading-5 text-gray-900">{{ auth()->user()->name }}</p>
                        </div>
                        <div class="py-1">
                            <a
                                class="flex w-full cursor-pointer justify-between px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100"
                                role="menuitem"
                                href="{{ route('profile', auth()->user()) }}"
                            >Profile</a>
                            <a
                                class="flex w-full cursor-pointer justify-between px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100"
                                role="menuitem"
                                href="{{ route('auth.settings') }}"
                            >Account settings</a>
                            <a
                                class="flex w-full cursor-pointer justify-between px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100"
                                role="menuitem"
                                hx-delete="{{ route('auth.logout') }}"
                                hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'
                            >Sign out</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- mobile nav -->
        <div id="account_dropdown_mobile" class="hidden w-full border-t border-gray-200 transition duration-500 md:hidden">
            <div role="menu">
                <div>
                    <p class="text-sm leading-5">Signed in as</p>
                    <p class="truncate text-sm font-medium leading-5 text-gray-900">{{ auth()->user()->name }}</p>
                </div>
                <div class="py-1">
                    <a class="flex w-full cursor-pointer justify-between text-left text-sm leading-5 text-gray-700 hover:bg-gray-100"
                        role="menuitem">Account settings</a>
                    <a
                        class="flex w-full cursor-pointer justify-between text-left text-sm leading-5 text-gray-700 hover:bg-gray-100"
                        role="menuitem"
                        hx-delete="{{ route('auth.logout') }}"
                        hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'
                    >Sign out</a>
                </div>
            </div>
        </div>
    </div>
</nav>
