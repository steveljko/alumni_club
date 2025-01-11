<section class="w-full rounded border border-gray-300"
    id="post-{{ $post->id }}">
    <div class="flex items-center justify-between border-b border-gray-300 p-2">
        <div class="flex items-center">
            <img class="mr-2 h-6 w-6 rounded-full"
                src="https://ui-avatars.com/api/?name=John+Doe"
                alt="user photo">
            <a href="{{ route('profile', $post->user) }}"
                class="text-sm">{{ $post->user->name }}</a>
        </div>
        <span class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</span>
    </div>
    @if ($post->type == \App\Enums\Post\PostType::DEFAULT)
        <div class="px-2 py-4">
            <p class="text-gray-700">{{ $post->default->body }}</p>
        </div>
    @elseif ($post->type == \App\Enums\Post\PostType::EVENT)
        <div class="px-2 py-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold">{{ $post->event->title }}</h3>
                <div>
                    <span class="block rounded-full border border-gray-300 px-2 py-1 text-xs font-medium leading-[16px]">
                        @if ($post->event->start_time->isSameDay($post->event->end_time))
                            {{ $post->event->start_time->format('d M H:i') }} - {{ $post->event->end_time->format('H:i') }}
                        @else
                            {{ $post->event->start_time->format('d M H:i') }} - {{ $post->event->end_time->format('d M H:i') }}
                        @endif
                    </span>
                </div>
            </div>
            <p class="text-sm leading-6 text-gray-700">{{ $post->event->description }}</p>
            <div class="flex w-full justify-end">
                <a href="{{ $post->event->event_page_url }}"
                    class="rounded-full bg-[#4D5BFC] p-1 px-3 text-sm text-white">Attend Event</a>
            </div>
        </div>
    @elseif ($post->type == \App\Enums\Post\PostType::JOB)
        <div class="px-2 py-3">
            <div class="flex items-start justify-between">
                <div class="mb-2">
                    <h3 class="text-lg font-semibold">{{ $post->job->position }}</h3>
                    <p class="mb-2 text-sm font-semibold text-blue-700">{{ $post->job->company_name }}</p>
                    <p class="flex items-center text-sm font-medium text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="mr-1 size-5">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        @if ($post->job->opening_start->isSameDay($post->job->opening_end))
                            <span>{{ $post->job->opening_start->format('d M H:i') }} - {{ $post->job->opening_end->format('H:i') }}</span>
                        @else
                            <span>{{ $post->job->opening_end->format('d M H:i') }} - {{ $post->job->opening_end->format('d M H:i') }}</span>
                        @endif
                    </p>
                </div>
                <span
                    class="block rounded-full border border-gray-300 px-2 py-1 text-xs font-medium leading-[16px]">{{ $post->job->company_city }}</span>
            </div>
            <p class="text-sm leading-6 text-gray-700">{{ $post->job->description }}</p>
            <div class="flex w-full justify-end">
                <a href="{{ $post->job->job_page_url }}"
                    class="rounded-full bg-[#4D5BFC] p-1 px-3 text-sm text-white">Apply for Job</a>
            </div>
        </div>
    @endif
    <div class="flex items-center border-t border-gray-300 px-2 py-2">
        <svg xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="size-5">
            <path stroke-linecap="round"
                stroke-linejoin="round"
                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
        </svg>
        <span>{{ $post->likes_count }}</span>
    </div>

</section>
