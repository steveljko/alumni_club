<div>
    <x-modal id="resizeAvatarModal"
        class="hidden"
        title="Resize Avatar">
        <div class="p-4">
            <div id="cropt_image"></div>
            <button id="confirmCropBtn"
                autocomplete="off"
                class="w-full rounded-md bg-[#4D5BFC] px-3 py-1 text-white">Crop</button>
        </div>
    </x-modal>
    <h4 class="mb-4 text-base font-medium text-gray-700">Avatar</h4>
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <img class="h-20 w-20 rounded-full"
                id="profileAvatar"
                src="{{ asset('storage/images/' . auth()->user()->avatar) }}"
                alt="Profile Avatar">
            <div>
                <h3 class="mb-1 text-base font-medium text-gray-900">Profile picture</h3>
                <p class="text-sm text-gray-600">PNG, JPEG under 2MB</p>
                <span id="avatar-validation-message"
                    class="mt-2 block hidden text-sm text-red-500"></span>
            </div>
        </div>
        <div id="controls"
            class="flex justify-end space-x-2">
            <button hx-post="{{ route('auth.settings.avatar') }}"
                hx-include="[name='avatar']"
                hx-encoding="multipart/form-data"
                hx-indicator="#spinner"
                id="uploadBtn"
                class="flex hidden items-center rounded-md bg-[#4D5BFC] px-3 py-1 text-white">
                <x-icon-spinner id="spinner" />
                Upload
            </button>
            <x-button id="selectBtn">
                Upload New Avatar
            </x-button>
            <input type="file"
                id="avatarUploadInput"
                name="avatar"
                class="hidden"
                accept="image/png, image/jpeg, image/jpg" />
            <x-button id="deleteBtn"
                spinner="true"
                style="danger"
                hx-indicator="#deleteBtnSpinner"
                hx-patch="{{ route('auth.settings.avatarReset') }}">Delete</x-button>
            <button class="hidden rounded-md bg-gray-200 px-3 py-1 text-gray-900"
                id="cancelBtn">Cancel</button>
        </div>
    </div>
</div>
