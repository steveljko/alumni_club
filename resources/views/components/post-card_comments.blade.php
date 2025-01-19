<div hx-target="this"
    class="flex items-center border-y border-gray-100 py-4">
    <div class="mr-4 flex items-center">
        <svg xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="mr-2 size-[24px]">
            <path stroke-linecap="round"
                stroke-linejoin="round"
                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
        </svg>
        <span class="text-sm">123</span>
    </div>
    <div hx-get="{{ route('post.comment', $post) }}"
        hx-trigger="click"
        hx-swap="innerHTML"
        class="flex items-center">
        <svg width="24"
            height="24"
            fill="none"
            viewBox="0 0 24 24"
            class="mr-2"
            xmlns="http://www.w3.org/2000/svg">
            <path
                d="M2.25 12.76C2.25 14.36 3.373 15.754 4.957 15.987C6.044 16.147 7.142 16.27 8.25 16.356V21L12.326 16.924C12.6024 16.6493 12.9735 16.4909 13.363 16.481C15.2644 16.4284 17.161 16.2634 19.043 15.987C20.627 15.754 21.75 14.361 21.75 12.759V6.741C21.75 5.139 20.627 3.746 19.043 3.513C16.711 3.17072 14.357 2.99926 12 3C9.608 3 7.256 3.175 4.957 3.513C3.373 3.746 2.25 5.14 2.25 6.741V12.759V12.76Z"
                stroke="#828282"
                stroke-width="1.5"
                stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
        <span class="text-sm text-gray-800">{{ $post->comments_count }}</span>
    </div>
</div>
<div class="mt-4"
    id="comments">
    <h3>Comments ({{ $post->comments_count }})</h3>
    <div>
        <form hx-post="{{ route('post.comment.create', $post) }}">
            @csrf
            <x-form-textarea label=""
                name="content" />
            <div class="flex w-full justify-end">
                <button class="rounded-md bg-[#DCEBFF] px-3 py-2 text-sm font-medium text-[#2F80ED]"
                    type="submit">Post</button>
            </div>
        </form>
    </div>
    <div class="space-y-4">
        @foreach ($post->comments as $comment)
            <div>
                <div class="flex-start mb-1 flex items-center">
                    <img class="mr-3 h-7 w-7 rounded-full"
                        src="{{ asset('storage/images/' . $comment->user->avatar) }}"
                        alt="User avatar">
                    <div class="space-x-3">
                        <a href="{{ route('profile', $comment->user) }}"
                            class="text-base font-medium text-gray-950 hover:text-blue-600 hover:underline">{{ $comment->user->name }}</a>
                        <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <p class="ml-10 break-all text-sm leading-[24px] text-gray-500">{{ $comment->content }}</p>
            </div>
        @endforeach
    </div>
    @if ($post->comments_count > 5)
        <div class="mt-4">
            <a href=""
                class="font-medium uppercase tracking-[0.03rem] text-blue-500">Load More</a>
        </div>
    @endif
</div>
