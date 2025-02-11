<form
    hx-put="{{ route('posts.update', $post) }}"
    hx-indicator="#spinner"
    id="modal-content"
>
    <x-modal.header>Edit post?</x-modal.header>
    <x-modal.body>
        <x-form-textarea
            label="Body"
            name="body"
            :value="$post->default->body"
        />
    </x-modal.body>
    <x-modal.footer>
        <x-modal.button variant="secondary" data-hide-modal="true">Cancel</x-modal.button>
        <x-modal.button type="submit">Edit post</x-modal.button>
    </x-modal.footer>
</form>
