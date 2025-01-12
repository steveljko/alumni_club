<div class="mb-3 w-full">
    <div class="flex justify-between">
        <label for="{{ $name }}"
            class="mb-2 block text-gray-600">{{ $label }}</label>
        @if ($limit)
            <span class="block text-sm text-gray-500"><span id="current-letter-count">0</span> / {{ $limit }}</span>
        @endif
    </div>
    <textarea id="{{ $name }}"
        data-limit="{{ $limit }}"
        name="{{ $name }}"
        class="block w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-300 focus:outline-none"
        hx-on:keydown="document.querySelector('#{{ $name }}-validation-message').classList.add('hidden')">{{ $value ?? '' }}</textarea>
    <span id="{{ $name }}-validation-message"
        class="mt-2 block hidden text-sm text-red-500"></span>
</div>
