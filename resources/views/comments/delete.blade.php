<x-modal id="deleteCommentModal"
    title="Delete Comment">
    <div class="px-4 pb-4">
        <p class="mb-3 text-sm text-gray-500">Are you sure you wan't to delete comment?</p>
        <div class="flex items-center justify-end space-x-2">
            <button class="rounded bg-gray-100 px-3 py-1 text-gray-700">Cancel</button>
            <button class="rounded bg-red-500 px-3 py-1 text-white"
                hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'
                hx-delete="{{ route('post.comment.delete', $comment) }}">Confirm</button>
        </div>
    </div>
</x-modal>
