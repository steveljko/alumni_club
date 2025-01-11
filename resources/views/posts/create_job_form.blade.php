<form hx-post="{{ route('post.create.execute', ['type' => 'job']) }}"
    hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'>
    <x-form-input name="position"
        label="Position" />
    <x-form-textarea name="description"
        limit="256"
        label="Description" />
    <x-form-input name="company_name"
        label="Company Name" />
    <x-form-input name="company_city"
        label="Company City" />
    <x-form-input name="opening_start"
        type="datetime-local"
        label="Start" />
    <x-form-input name="opening_end"
        type="datetime-local"
        label="End" />
    <x-form-input name="job_page_url"
        label="Job Page Url" />
    <button type="submit"
        class="rounded-md bg-[#4D5BFC] px-3 py-1 text-white">Publish</button>
</form>
