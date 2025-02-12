<form
    class="w-full"
    hx-post="{{ route('posts.store', ['type' => 'job']) }}"
    hx-indicator="#jobFormSpinner"
    id="postbox_form"
>
    @csrf
    <div class="flex w-full items-start">
        <img
            class="mr-4 h-10 w-10 rounded-full"
            src="{{ asset('storage/images/' . auth()->user()->avatar) }}"
            alt="User avatar"
        >
        <div class="w-full">
            <x-form-input name="position" label="Position" />
            <x-form-textarea
                name="description"
                limit="256"
                label="Description"
            />
            <x-form-input-group>
                <x-form-input name="company_name" label="Company Name" />
                <x-form-input name="company_website_url" label="Company Website Link" />
            </x-form-input-group>
            <x-form-input-group>
                <x-form-input name="company_address" label="Company Address" />
                <x-form-input name="company_city" label="Company City" />
            </x-form-input-group>
            <x-form-input-group>
                <x-form-input
                    name="start_time"
                    type="datetime-local"
                    label="Start"
                />
                <x-form-input
                    name="end_time"
                    type="datetime-local"
                    label="End"
                />
            </x-form-input-group>
            <x-form-input name="job_page_url" label="Job Page Link" />
        </div>
    </div>
    <div class="mt-2 flex items-center justify-between">
        <x-postbox-type active="job" />
        <x-button
            type="submit"
            id="jobForm"
            spinner="true"
            size="sm"
        >Post</x-button>
    </div>
</form>
