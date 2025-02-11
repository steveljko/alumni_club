<form
    hx-post="{{ route('users.workHistories.store') }}"
    hx-indicator="#spinner"
    id="modal-content"
>
    <x-modal.header>Create Work History</x-modal.header>
    <x-modal.body>
        <x-form-input label="Comapny Name" name="company_name" />
        <x-form-input label="Position" name="position" />
        <x-form-input
            type="date"
            label="Start Date"
            name="start_date"
        />
        <x-form-input
            type="date"
            label="End Date"
            name="end_date"
        />
        <x-form-textarea
            label="Descritpion"
            name="description"
            limit="250"
        />
    </x-modal.body>
    <x-modal.footer>
        <x-modal.button variant="secondary" data-hide-modal="true">Cancel</x-modal.button>
        <x-modal.button type="submit">Create Work History</x-modal.button>
    </x-modal.footer>
</form>
