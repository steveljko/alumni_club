<li>
    <a @class([
        'flex cursor-pointer items-center rounded-md p-3 text-start font-semibold leading-tight text-gray-600 transition duration-500 hover:bg-gray-100 hover:text-blue-700',
        'bg-white shadow border border-gray-50' =>
            url()->current() == route($route),
    ])
        href="{{ route($route) }}">
        {{ $icon }}
        {{ $slot }}
    </a>
</li>
