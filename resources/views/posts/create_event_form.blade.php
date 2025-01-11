<form hx-post="{{ route('post.create.execute', ['type' => 'event']) }}"
    hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'>
    <x-form-input name="title"
        label="Title" />
    <x-form-textarea name="description"
        limit="256"
        label="Description" />
    <x-form-input name="event_page_url"
        label="Event Page Url" />
    <x-form-input name="start_time"
        type="datetime-local"
        label="Start Time" />
    <x-form-input name="end_time"
        type="datetime-local"
        label="End Time" />
    <x-form-input name="address"
        label="Address" />
    <x-form-input name="city"
        label="City" />
    <button type="submit"
        class="rounded-md bg-[#4D5BFC] px-3 py-1 text-white">Publish</button>
</form>
