<nav class="w-full border-b border-gray-200 bg-white">
    <div class="container mx-auto w-full py-3">
        <div class="flex items-center justify-between">
            <a href="{{ route('home') }}">{{ config('settings.site_name') }}</a>
            <div id="account" class="relative">
                <button
                    type="button"
                    id="user-profile-menu-toggle"
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
                <x-user-profile-menu />
            </div>
        </div>
    </div>
</nav>
