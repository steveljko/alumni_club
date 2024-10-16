<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
</head>
<body>
    <div class="flex">
      <aside class="w-64 flex flex-col h-screen sticky top-0 bg-gray-700 border-r border-gray-200">
        <h3 class="mx-4 py-4 text-sm font-medium text-white uppercase">Meni</h3>
        <ul class="flex flex-col mx-4 space-y-2">
            <a
              href="{{ route('dashboard.index') }}"
              @class([
                'inline-flex items-center px-4 py-2 text-white rounded',
                'bg-gray-600' => Route::is('dashboard.index')
              ])
            >
                @svg('heroicon-o-chart-bar', 'w-5 h-5 text-white-500 mr-2')
                {{ __('additional.dashboard.overview') }}
            </a>
            <a
              href="{{ route('dashboard.users') }}"
              @class([
                'inline-flex items-center px-4 py-2 text-white rounded',
                'bg-gray-600' => Route::is('dashboard.users')
              ])
          >
                @svg('heroicon-o-user', 'w-5 h-5 text-white-500 mr-2')
                {{ __('additional.dashboard.users') }}
            </a>
        </ul>
      </aside>
      <div class="w-full">
        <div class="w-[80%] mx-auto">
            @yield('content')
        </div>
      </div>
    </div>
</body>
</html>
