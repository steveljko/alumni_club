<x-modal title="Create New User"
    id="createUser">
    <form hx-post="{{ route('admin.users.create') }}"
        hx-indicator="#createUserSpinner"
        class="w-full p-4">
        <x-form-input label="Name"
            name="name" />
        <x-form-input label="Email Address"
            name="email" />
        <x-button type="submit"
            id="createUser"
            spinner="true">
            Create User
        </x-button>
    </form>
</x-modal>
