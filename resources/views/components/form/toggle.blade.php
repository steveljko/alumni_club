<label class="mb-3 block cursor-pointer">
    <label for="{{ $name }}" class="mb-3 block text-sm font-medium text-gray-500">{{ $label }}</label>
    <div class="inline-flex items-center">
        <input
            type="checkbox"
            name="{{ $name }}"
            class="peer sr-only"
            @checked($value)
            value="1"
            autocomplete="off"
        >
        <div
            class="peer relative h-6 w-11 rounded-full bg-gray-200 after:absolute after:start-[2px] after:top-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-navyblue-500 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rtl:peer-checked:after:-translate-x-full">
        </div>
        <span class="ms-3 text-sm font-medium text-gray-900">{{ $placeholder }}</span>
    </div>
    <span id="{{ $name }}-validation-message" class="mt-2 block hidden text-sm text-red-500"></span>
</label>
