<x-modal title="Create"
    id="createWorkHistoryModal">
    <form class="w-full p-4"
        hx-post="{{ route('workHistory.create') }}"
        hx-indicator="#createWorkHistorySpinner">
        @csrf
        <x-form-input label="Comapny Name"
            name="company_name" />
        <x-form-input label="Position"
            name="position" />
        <x-form-input type="date"
            label="Start Date"
            name="start_date" />
        <x-form-input type="date"
            label="End Date"
            name="end_date" />
        <x-form-textarea label="Descritpion"
            name="description"
            limit="250" />
        <x-button type="submit"
            id="createWorkHistory"
            spinner="true"
            size="sm">
            Add
        </x-button>
    </form>
</x-modal>
