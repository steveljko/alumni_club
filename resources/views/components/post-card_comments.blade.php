<div hx-target="this">
    <div id="postbox_footer" class="flex items-center border-y border-gray-100 py-4">
        <div class="mr-4 flex items-center">
            <x-icons.heart />
            <span class="text-sm">123</span>
        </div>
        <a
            hx-get="{{ route('posts.comments', $post) }}"
            hx-trigger="click, reloadComments.{{ $post->id }} from:body"
            hx-swap="outerHTML"
            class="flex cursor-pointer items-center"
        >
            <x-icons.chat-bubble />
            <span class="text-sm text-gray-800">{{ $post->comments_count }}</span>
        </a>
    </div>
    <div class="mt-4" id="comments">
        <h3>Comments ({{ $post->comments_count }})</h3>
        <div>
            <form hx-post="{{ route('posts.comments', $post) }}" hx-indicator="#post{{ $post->id }}commentSpinner">
                @csrf
                <x-form-textarea label="" name="content" />
                <div class="flex w-full justify-end">
                    <x-button
                        type="submit"
                        id="post{{ $post->id }}comment"
                        spinner="true"
                        size="sm"
                    >
                        Comment
                    </x-button>
                </div>
            </form>
        </div>
        <div class="space-y-4">
            @foreach ($post->comments as $comment)
                <div>
                    <div class="flex-start mb-1 flex items-center">
                        <img
                            class="mr-3 h-7 w-7 rounded-full"
                            src="{{ asset('storage/images/' . $comment->user->avatar) }}"
                            alt="User avatar"
                        >
                        <div class="flex w-full justify-between">
                            <div class="space-x-3">
                                <a href="{{ route('users.profile', $comment->user) }}"
                                    class="text-base font-medium text-gray-950 hover:text-blue-600 hover:underline"
                                >{{ $comment->user->name }}</a>
                                <span class="text-xs text-gray-400">
                                    @if ($comment->created_at == $comment->updated_at)
                                        <span>{{ $comment->created_at->diffForHumans() }}</span>
                                    @else
                                        <span>edited {{ $comment->updated_at->diffForHumans() }}</span>
                                    @endif
                                </span>
                            </div>

                            @if (auth()->user()->id == $comment->user_id || auth()->user()->can('edit any comment'))
                                <div class="inline-flex space-x-3">
                                    <a
                                        hx-get="{{ route('posts.comments.edit', $comment) }}"
                                        hx-target="#dialog"
                                        hx-swap="innerHTML"
                                        class="block cursor-pointer font-medium uppercase tracking-[0.03rem] text-navyblue-500"
                                    >Edit</a>
                                    <a
                                        hx-get="{{ route('posts.comments.delete', $comment) }}"
                                        hx-target="#dialog"
                                        hx-swap="innerHTML"
                                        class="block cursor-pointer font-medium uppercase tracking-[0.03rem] text-red-500"
                                    >Delete</a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <p class="ml-10 break-all text-sm leading-[24px] text-gray-500">{{ $comment->content }}</p>
                </div>
            @endforeach
        </div>
        @if ($post->comments_count > 5)
            <!-- TODO: Add load more -->
            <div class="mt-4">
                <a href="" class="font-medium uppercase tracking-[0.03rem] text-blue-500">Load More</a>
            </div>
        @endif
    </div>
</div>
