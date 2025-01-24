<x-modal id="editWorkHistoryModal"
    title="Edit Work History">
    <div class="container inline-flex w-full space-x-2 border-t border-gray-200 bg-white p-4">
        <form class="w-full"
            hx-target="#modal"
            hx-patch="{{ route('workHistory.edit', $workHistory->id) }}">
            @csrf
            <x-form-input label="Comapny Name"
                name="company_name"
                :value="$workHistory->company_name" />
            <x-form-input label="Position"
                name="position"
                :value="$workHistory->position" />
            <x-form-input type="date"
                label="Start Date"
                name="start_date"
                :value="$workHistory->start_date->format('Y-m-d')" />
            <x-form-input type="date"
                label="End Date"
                name="end_date"
                :value="$workHistory->end_date ? $workHistory->end_date->format('Y-m-d') : null" />
            <x-form-textarea label="Descritpion"
                name="description"
                limit="250"
                :value="$workHistory->description" />
            <button type="submit"
                class="rounded-md bg-[#4D5BFC] px-3 py-1 text-white">Update</button>
        </form>
    </div>
</x-modal>
