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
    <body class="bg-[#fcfcfc]">
        <x-htmx-error-handler />

        <x-toast />

        <div>
            <x-home-nav />

            @yield('content')
        </div>
    </body>
</html>
