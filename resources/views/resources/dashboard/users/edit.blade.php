<x-modal title="Edit User"
    id="updateUserModal">
    <form hx-put="{{ route('admin.users.edit', $user) }}"
        hx-indicator="#updateUserSpinner"
        class="w-full p-4">
        <span>ID: {{ $user->id }}</span>
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
    <!-- Add delete part -->
</x-modal>
