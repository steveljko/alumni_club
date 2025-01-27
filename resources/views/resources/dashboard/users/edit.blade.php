<x-modal title="Edit User"
    id="updateUserModal">
    <div>
        <form hx-put="{{ route('admin.users.edit', $user) }}"
            hx-indicator="#updateUserSpinner"
            hx-swap="none"
            class="w-full p-4 pt-0">
            <x-form-input label="Name"
                name="name"
                :value="$user->name" />
            <x-form-input label="Email Address"
                name="email"
                :value="$user->email" />
            <x-form-input-group>
                <x-form-select label="University Start Year"
                    name="uni_start_year"
                    between="2000,current"
                    :value="$user->uni_start_year" />
                <x-form-select label="University Finish Year"
                    name="uni_finish_year"
                    between="2000,current"
                    :value="$user->uni_finish_year" />
            </x-form-input-group>
            <x-button type="submit"
                id="updateUser"
                spinner="true">Update User</x-button>
        </form>
        <div class="h-[1px] w-full bg-gray-100"></div>
        <div class="p-4">
            <div class="mb-4">
                <h3 class="mb-2 text-lg font-semibold">Delete User</h3>
                <p class="text-sm leading-6 text-gray-500">This action is permanent and cannot be undone.
                    Please double-check that
                    you want to proceed,
                    as all associated data will be lost.</p>
            </div>
            <x-button id="deleteUser"
                hx-delete="{{ route('admin.users.delete', $user) }}"
                hx-indicator="#deleteUserSpinner"
                style="danger"
                spinner="true">Delete</x-button>
        </div>
    </div>
</x-modal>
