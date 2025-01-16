<div class="{{ $class }} fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
    id="{{ $id }}">
    <div id="modal-content"
        class="mx-2 w-full rounded-lg bg-white shadow-lg md:mx-0 md:w-1/2 lg:w-1/3"
        tabindex="-1">
        <div class="p-4">
            <h2 class="text-lg font-semibold">{{ $title }}</h2>
        </div>

        {{ $slot }}
    </div>
</div>
