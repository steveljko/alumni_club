  <section
      hx-get="{{ route('posts.show', $post) }}"
      hx-target="this"
      hx-swap="outerHTML"
      hx-trigger="reloadPost.{{ $post->id }} from:body"
      class="w-full rounded-lg bg-white px-4 py-5 shadow"
      id="post-{{ $post->id }}"
  >
      <div class="{{ !$post->isEventOrJob() ? 'items-start' : 'items-end relative' }} flex justify-between">
          @if ($post->isEventOrJob())
              <span
                  class="absolute right-[-1rem] top-[-1.25rem] block rounded-bl-md rounded-tr-lg bg-navyblue-500 px-3 py-1.5 text-sm font-semibold uppercase tracking-[0.08em] text-white"
              >{{ $post->type }}</span>
          @endif
          <div class="flex-start flex items-center">
              <img
                  class="mr-3 h-10 w-10 rounded-full"
                  src="{{ asset('storage/images/' . $post->user->avatar) }}"
                  alt="User Avatar"
              >
              <a href="{{ route('users.profile', $post->user) }}"
                  class="text-base font-medium text-gray-950 hover:text-blue-600 hover:underline">{{ $post->user->name }}</a>
          </div>
          <span class="text-sm text-gray-400">{{ $post->created_at->diffForHumans() }}</span>
      </div>
      @if ($post->isDefault())
          <div class="my-4">
              <p class="break-all leading-8 text-gray-800">{{ $post->default->body }}</p>
          </div>
      @elseif ($post->isEvent())
          <div class="my-4">
              <div class="block lg:flex lg:items-center lg:justify-between">
                  <h3 class="mb-2 text-lg font-semibold lg:mb-0">{{ $post->event->title }}</h3>
                  <div class="block space-y-2 md:flex md:space-x-2 md:space-y-0">
                      <span class="block rounded-full border border-gray-200 px-1.5 py-0.75 text-xs font-medium">
                          {{ $post->event->address }}, {{ $post->event->city }}</span>
                      <x-badge-date :start="$post->event->start_time" :end="$post->event->end_time" />
                      <x-badge-time :start="$post->event->start_time" :end="$post->event->end_time" />
                  </div>
              </div>
              <p class="text-sm leading-8 text-gray-800">{{ $post->event->description }}</p>
              <div class="flex w-full justify-end">
                  <a
                      hx-get="{{ route('redirect', ['url' => $post->event->url()]) }}"
                      hx-target="#dialog"
                      hx-swap="innerHTML"
                      class="cursor-pointer text-sm font-semibold uppercase tracking-[0.03em] text-navyblue-500 hover:underline"
                  >Attend Event</a>
              </div>
          </div>
      @elseif ($post->isJob())
          <div class="my-4">
              <div class="block lg:flex lg:items-center lg:justify-between">
                  <div class="mb-2">
                      <h3 class="mb-2 text-lg font-semibold text-gray-900">{{ $post->job->position }}</h3>
                      <a href="{{ $post->job->company_website_url }}"
                          class="cursor-pointer text-sm font-medium text-gray-500 hover:text-blue-500">{{ $post->job->company_name }}</a>
                  </div>
                  <div class="block space-y-2 md:flex md:space-x-2 md:space-y-0">
                      <span class="block rounded-full border border-gray-200 px-1.5 py-0.75 text-xs font-medium">
                          {{ $post->job->company_address }}, {{ $post->job->company_city }}
                      </span>
                      <x-badge-date :start="$post->job->start_time" :end="$post->job->start_time" />
                      <x-badge-time :start="$post->job->end_time" :end="$post->job->end_time" />
                  </div>
              </div>
              <p class="text-sm leading-8 text-gray-800">{{ $post->job->description }}</p>
              <div class="flex w-full justify-end">
                  <a
                      hx-get="{{ route('redirect', ['url' => $post->job->url()]) }}"
                      hx-target="#dialog"
                      hx-swap="innerHTML"
                      class="cursor-pointer text-sm font-semibold uppercase tracking-[0.03em] text-navyblue-500 hover:underline"
                  >Apply for Job</a>
              </div>
          </div>
      @endif
      <div hx-target="this">
          <div class="flex items-center justify-between border-t border-gray-100 pt-4">
              <div class="inline-flex">
                  <div class="mr-4 flex items-center">
                      <x-icons.heart />
                      <span class="text-sm">123</span>
                  </div>
                  <a
                      hx-get="{{ route('posts.comments', $post) }}"
                      hx-trigger="click"
                      hx-swap="outerHTML"
                      class="flex cursor-pointer items-center"
                  >
                      <x-icons.chat-bubble />
                      <span class="text-sm">{{ $post->comments_count }}</span>
                  </a>
              </div>
              <div class="space-x-2">
                  @if (auth()->user()->can('edit', $post))
                      <a
                          hx-get="{{ route('posts.edit', $post) }}"
                          hx-target="#dialog"
                          hx-swap="innerHTML"
                          class="cursor-pointer font-medium uppercase tracking-[0.02rem] text-navyblue-500"
                      >Edit</a>
                  @endif
                  @if (auth()->user()->can('delete', $post))
                      <a
                          hx-get="{{ route('posts.delete', $post) }}"
                          hx-target="#dialog"
                          hx-swap="innerHTML"
                          class="cursor-pointer font-medium uppercase tracking-[0.02rem] text-red-500"
                      >Delete</a>
                  @endif
              </div>
          </div>
      </div>
  </section>
