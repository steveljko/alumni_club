<li>
    <a @class([
        'flex cursor-pointer items-center rounded-md p-3 text-start font-semibold leading-tight text-gray-600 transition duration-250 hover:bg-gray-100 border border-transparent hover:border-gray-200 hover:text-[#003366]',
        'bg-[#003366] shadow text-white border border-gray-50' =>
            url()->current() == route($route),
    ])
        href="{{ route($route) }}">
        {{ $icon }}
        {{ $slot }}
    </a>
</li>
