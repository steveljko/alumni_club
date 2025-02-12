<form
    class="w-full"
    hx-post="{{ route('posts.store', ['type' => 'event']) }}"
    hx-indicator="#eventFormSpinner"
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
            <x-form-input name="title" label="Title" />
            <x-form-textarea
                name="description"
                limit="256"
                label="Description"
            />
            <x-form-input name="event_page_url" label="Event Page Url" />
            <x-form-input-group>
                <x-form-input
                    name="start_time"
                    type="datetime-local"
                    label="Start Time"
                />
                <x-form-input
                    name="end_time"
                    type="datetime-local"
                    label="End Time"
                />
            </x-form-input-group>
            <x-form-input-group>
                <x-form-input name="address" label="Address" />
                <x-form-input name="city" label="City" />
            </x-form-input-group>
        </div>
    </div>
    <div class="mt-2 flex items-center justify-between">
        <x-postbox-type active="event" />
        <x-button
            type="submit"
            id="eventForm"
            spinner="true"
            size="sm"
        >Post</x-button>
    </div>
</form>
