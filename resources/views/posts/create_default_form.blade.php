<form hx-post="{{ route('post.create.execute', ['type' => 'default']) }}"
    hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'>
    <x-form-textarea name="body"
        limit="256"
        label="Content" />
    <button type="submit"
        class="rounded-md bg-[#4D5BFC] px-3 py-1 text-white">Publish</button>
</form>
