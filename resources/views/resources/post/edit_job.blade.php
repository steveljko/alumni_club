<form
    hx-put="{{ route('post.edit', $post) }}"
    hx-indicator="#spinner"
    id="modal-content"
>
    <x-modal.header>Edit post?</x-modal.header>
    <x-modal.body>
        <x-form-input
            name="position"
            label="Position"
            :value="$post->job->position"
        />
        <x-form-textarea
            name="description"
            limit="256"
            label="Description"
            :value="$post->job->description"
        />
        <x-form-input-group>
            <x-form-input
                name="company_name"
                label="Company Name"
                :value="$post->job->company_name"
            />
            <x-form-input
                name="company_website_url"
                label="Company Website Link"
                :value="$post->job->company_website_url"
            />
        </x-form-input-group>
        <x-form-input-group>
            <x-form-input
                name="company_address"
                label="Company Address"
                :value="$post->job->company_address"
            />
            <x-form-input
                name="company_city"
                label="Company City"
                :value="$post->job->company_city"
            />
        </x-form-input-group>
        <x-form-input-group>
            <x-form-input
                name="start_time"
                type="datetime-local"
                label="Start"
                :value="$post->job->start_time"
            />
            <x-form-input
                name="end_time"
                type="datetime-local"
                label="End"
                :value="$post->job->end_time"
            />
        </x-form-input-group>
        <x-form-input
            name="job_page_url"
            label="Job Page Link"
            :value="$post->job->job_page_url"
        />
    </x-modal.body>
    <x-modal.footer>
        <x-modal.button variant="secondary" data-hide-modal="true">Cancel</x-modal.button>
        <x-modal.button type="submit">Edit post</x-modal.button>
    </x-modal.footer>
</form>
