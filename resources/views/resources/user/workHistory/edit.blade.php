<form
    hx-patch="{{ route('users.workHistories.update', $workHistory->id) }}"
    hx-indicator="#spinner"
    id="modal-content"
>
    <x-modal.header>Edit Work History</x-modal.header>
    <x-modal.body>
        <x-form-input
            label="Comapny Name"
            name="company_name"
            :value="$workHistory->company_name"
        />
        <x-form-input
            label="Position"
            name="position"
            :value="$workHistory->position"
        />
        <x-form-input
            type="date"
            label="Start Date"
            name="start_date"
            :value="$workHistory->start_date->format('Y-m-d')"
        />
        <x-form-input
            type="date"
            label="End Date"
            name="end_date"
            :value="$workHistory->end_date ? $workHistory->end_date->format('Y-m-d') : null"
        />
        <x-form-textarea
            label="Descritpion"
            name="description"
            limit="250"
            :value="$workHistory->description"
        />
    </x-modal.body>
    <x-modal.footer>
        <x-modal.button variant="secondary" data-hide-modal="true">Cancel</x-modal.button>
        <x-modal.button type="submit">Edit Work History</x-modal.button>
    </x-modal.footer>
</form>
