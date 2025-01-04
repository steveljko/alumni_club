<x-modal title="Add work">
    <div class="inline-flex w-full space-x-2 border-t border-gray-200 p-4">
        <form class="w-full"
            hx-swap="none"
            hx-target="#modal"
            hx-post="{{ route('auth.setup.step.3.add_work') }}">
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
    </div>
</x-modal>
