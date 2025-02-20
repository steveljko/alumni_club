<div class="mb-3 w-full">
    <label for="{{ $name }}" class="mb-3 block text-sm font-medium text-gray-500">{{ $label }}</label>
    <select
        id="{{ $name }}"
        name="{{ $name }}"
        class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 focus:border-navyblue-500 focus:outline-none"
        hx-on:keydown="document.querySelector('#{{ $name }}-validation-message').classList.add('hidden')"
        autocomplete="off"
    >
        @foreach ($options as $option)
            <option value="{{ $option }}" @selected($option == $value)>{{ $option }}</option>
        @endforeach
    </select>
    <span id="{{ $name }}-validation-message" class="mt-2 block hidden text-sm text-red-500"></span>
</div>
