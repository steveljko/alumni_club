<div class="mb-3 w-full">
    <label for="{{ $name }}"
        class="mb-2 block text-gray-600">{{ $label }}</label>
    <input type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ $value }}"
        class="block w-full rounded-md border border-gray-300 px-3 py-2 text-a focus:border-navyblue-500 focus:outline-none"
        hx-on:keydown="document.querySelector('#{{ $name }}-validation-message').classList.add('hidden')"
        autocomplete="off"
        {{ $attributes }}>
    <span id="{{ $name }}-validation-message"
        class="mt-2 block hidden text-sm text-red-500"></span>
</div>
