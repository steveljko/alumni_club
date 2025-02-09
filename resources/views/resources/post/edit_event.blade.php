<form
    hx-put="{{ route('post.edit', $post) }}"
    hx-indicator="#spinner"
    id="modal-content"
>
    <x-modal.header>Edit post?</x-modal.header>
    <x-modal.body>
        <x-form-input
            name="title"
            label="Title"
            :value="$post->event->title"
        />
        <x-form-textarea
            name="description"
            limit="256"
            label="Description"
            :value="$post->event->description"
        />
        <x-form-input
            name="event_page_url"
            label="Event Page Url"
            :value="$post->event->event_page_url"
        />
        <x-form-input-group>
            <x-form-input
                name="start_time"
                type="datetime-local"
                label="Start Time"
                :value="$post->event->start_time"
            />
            <x-form-input
                name="end_time"
                type="datetime-local"
                label="End Time"
                :value="$post->event->end_time"
            />
        </x-form-input-group>
        <x-form-input-group>
            <x-form-input
                name="address"
                label="Address"
                :value="$post->event->address"
            />
            <x-form-input
                name="city"
                label="City"
                :value="$post->event->city"
            />
        </x-form-input-group>
    </x-modal.body>
    <x-modal.footer>
        <x-modal.button variant="secondary" data-hide-modal="true">Cancel</x-modal.button>
        <x-modal.button type="submit">Edit post</x-modal.button>
    </x-modal.footer>
</form>
