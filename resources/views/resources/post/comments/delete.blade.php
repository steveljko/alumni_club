<div id="modal-content">
    <x-modal.header>Delete comment?</x-modal.header>
    <x-modal.body>
        <p class="text-sm leading-6 text-gray-500">
            This action is permanent and cannot be undone.
            Please double-check that you want to proceed,
            as all associated data will be lost.
        </p>
    </x-modal.body>
    <x-modal.footer>
        <x-modal.button variant="secondary" data-hide-modal="true">Cancel</x-modal.button>
        <x-modal.button
            variant="danger"
            hx-delete="{{ route('posts.comments.destroy', $comment) }}"
            hx-indicator="#spinner"
        >Delete comment</x-modal.button>
    </x-modal.footer>
</div>
