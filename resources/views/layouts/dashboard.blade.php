<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link
            rel="preconnect"
            href="https://fonts.gstatic.com"
            crossorigin
        >
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/speed-highlight/core/dist/themes/default.css">
    </head>
    <body hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}' class="bg-[#fcfcfc]">
        <x-htmx-error-handler />

        <x-toast />

        <x-modal.container />
        <x-modal.backdrop />

        <div class="flex flex-row">
            <x-sidebar />

            <div class="w-full">
                <div class="sticky top-0 w-full border-b border-gray-200 bg-white">
                    <div class="container mx-auto flex justify-end py-3">
                        <div class="relative">
                            <button
                                type="button"
                                class="flex rounded-full bg-gray-800 text-sm focus:ring-2 focus:ring-gray-300 md:me-0 dark:focus:ring-gray-600"
                                id="user-profile-menu-toggle"
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

                <div class="m-6">
                    @yield('content')
                </div>
            </div>
        </div>
    </body>
</html>
