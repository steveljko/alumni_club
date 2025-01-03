<div class="mb-3 w-full">
    <label for="{{ $name }}"
        class="mb-2 block text-gray-600">{{ $label }}</label>
    <select id="{{ $name }}"
        name="{{ $name }}"
        class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 focus:border-blue-300 focus:outline-none"
        hx-on:keydown="document.querySelector('#{{ $name }}-validation-message').classList.add('hidden')">
        {{ $slot }}
    </select>
    <span id="{{ $name }}-validation-message"
        class="mt-2 block hidden text-sm text-red-500"></span>
</div>
