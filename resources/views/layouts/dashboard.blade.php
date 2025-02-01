<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
            content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="preconnect"
            href="https://fonts.googleapis.com">
        <link rel="preconnect"
            href="https://fonts.gstatic.com"
            crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
            rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'
        class="bg-[#e5eaef]">
        <x-htmx-error-handler />

        <x-toast />

        <div id="modal"
            hx-target="this"
            class="hidden"></div>

        <div class="flex flex-row">
            <x-sidebar />

            <div class="m-6 w-full">
                @yield('content')
            </div>
        </div>
    </body>
</html>
