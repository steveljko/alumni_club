<div class="fixed inset-0 z-50 flex hidden items-center justify-center bg-black bg-opacity-50"
    id="modal">
    <div class="mx-2 w-full rounded-lg bg-white shadow-lg md:mx-0 md:w-1/2 lg:w-1/3"
        tabindex="-1">
        <div class="p-4">
            <h2 class="text-lg font-semibold">Add work</h2>
        </div>

        <div class="inline-flex w-full space-x-2 border-t border-gray-200 p-4">
            <form class="w-full"
                hx-swap="none"
                hx-post="{{ route('auth.setup.step.3.add_work') }}">
                @csrf
                <x-form-input label="Comapny Name"
                    name="company_name" />
                <x-form-input label="Position"
                    name="position" />
                <x-form-input label="Start Date"
                    name="start_date" />
                <x-form-input label="End Date"
                    name="end_date" />
                <x-form-textarea label="Descritpion"
                    name="description"
                    limit="250" />
                <button type="submit"
                    class="rounded-md bg-[#4D5BFC] px-3 py-1 text-white">Add</button>
            </form>
        </div>
    </div>
</div>
