<form
    hx-put="{{ route('posts.comments.update', $comment) }}"
    hx-indicator="#spinner"
    id="modal-content"
>
    <x-modal.header>Edit comment?</x-modal.header>
    <x-modal.body>
        <x-form-textarea
            label="Content"
            name="content"
            limit="256"
            :value="$comment->content"
        />
    </x-modal.body>
    <x-modal.footer>
        <x-modal.button variant="secondary" data-hide-modal="true">Cancel</x-modal.button>
        <x-modal.button type="submit">Edit comment</x-modal.button>
    </x-modal.footer>
</form>
