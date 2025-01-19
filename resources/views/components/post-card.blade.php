  <section class="w-full rounded-lg px-4 py-5 shadow"
      id="post-{{ $post->id }}">
      <div class="{{ !$post->isEventOrJob() ? 'items-start' : 'items-end relative' }} flex justify-between">
          @if ($post->isEventOrJob())
              <span
                  class="absolute right-[-1rem] top-[-1.25rem] block rounded-bl-lg rounded-tr-lg bg-[#A3CEFF] bg-blue-400 px-3 py-1.5 text-sm font-semibold uppercase tracking-[0.08em] text-[#0B417D]">{{ $post->type }}</span>
          @endif
          <div class="flex-start flex items-center">
              <img class="mr-3 h-10 w-10 rounded-full"
                  src="{{ asset('storage/images/' . $post->user->avatar) }}"
                  alt="User Avatar">
              <a href="{{ route('profile', $post->user) }}"
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
                      <x-badge-date :start="$post->event->start_time"
                          :end="$post->event->end_time" />
                      <x-badge-time :start="$post->event->start_time"
                          :end="$post->event->end_time" />
                  </div>
              </div>
              <p class="text-sm leading-8 text-gray-800">{{ $post->event->description }}</p>
              <div class="flex w-full justify-end">
                  <a href="{{ $post->event->event_page_url }}"
                      class="text-sm font-semibold uppercase tracking-[0.03em] text-blue-600 hover:underline">Attend Event</a>
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
                      <x-badge-date :start="$post->job->start_time"
                          :end="$post->job->start_time" />
                      <x-badge-time :start="$post->job->end_time"
                          :end="$post->job->end_time" />
                  </div>
              </div>
              <p class="text-sm leading-8 text-gray-800">{{ $post->job->description }}</p>
              <div class="flex w-full justify-end">
                  <a href="{{ $post->job->job_page_url }}"
                      class="text-sm font-semibold uppercase tracking-[0.03em] text-blue-600 hover:underline">Apply for Job</a>
              </div>
          </div>
      @endif
      <div hx-target="this">
          <div class="flex items-center border-t border-gray-100 pt-4">
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
                  hx-swap="outerHTML"
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
                  <span class="text-sm">{{ $post->comments_count }}</span>
              </div>
          </div>
      </div>
  </section>
