<x-modal title="Create"
    id="createWorkHistoryModal">
    <form class="w-full p-4"
        hx-swap="none"
        hx-target="#modal"
        hx-post="{{ route('workHistory.create') }}">
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
        <button type="submit"
            class="rounded-md bg-[#4D5BFC] px-3 py-1 text-white">Add</button>
    </form>
</x-modal>
