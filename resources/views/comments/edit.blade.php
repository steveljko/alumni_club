<x-modal id="editCommentModal"
    title="Edit Comment">
    <div class="container inline-flex w-full space-x-2 border-t border-gray-200 bg-white p-4">
        <form class="w-full"
            hx-put="{{ route('post.comment.edit', $comment) }}"
            hx-indicator="#editCommentSpinner">
            @csrf
            <x-form-textarea label="Content"
                name="content"
                limit="256"
                :value="$comment->content" />
            <x-button type="submit"
                id="editComment"
                spinner="true"
                size="sm">Edit</x-button>
        </form>
    </div>
</x-modal>
