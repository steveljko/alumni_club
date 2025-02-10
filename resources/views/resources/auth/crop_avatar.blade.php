<form
    hx-post="{{ route('users.settings.avatar') }}"
    hx-encoding="multipart/form-data"
    id="modal-content"
    class="crop_avatar"
>
    <x-modal.header>Resize Avatar</x-modal.header>
    <x-modal.body>
        <img
            src="{{ $image }}"
            id="image"
            class="mx-auto hidden rounded-full"
        />
        <div id="cropt_image"></div>
        <input
            type="file"
            name="avatar"
            class="hidden"
            accept="image/png, image/jpeg, image/jpg"
        />
        <x-button id="crop" size="full">Crop</x-button>
    </x-modal.body>
    <x-modal.footer>
        <x-modal.button variant="secondary" data-hide-modal="true">Cancel</x-modal.button>
        <x-modal.button id="submit" type="submit">Upload</x-modal.button>
    </x-modal.footer>
</form>
