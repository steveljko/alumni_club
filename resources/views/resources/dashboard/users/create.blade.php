<form
    hx-post="{{ route('admin.users.create') }}"
    hx-indicator="#spinner"
    class="w-full"
    id="modal-content"
>
    <x-modal.header>Create User</x-modal.header>
    <x-modal.body>
        <x-form-input label="Name" name="name" />
        <x-form-input label="Email Address" name="email" />
    </x-modal.body>
    <x-modal.footer>
        <x-modal.button variant="secondary" data-hide-modal="true">Cancel</x-modal.button>
        <x-modal.button type="submit">Create User</x-modal.button>
    </x-modal.footer>
</form>
