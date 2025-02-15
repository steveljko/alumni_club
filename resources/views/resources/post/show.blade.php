<div>
    <div class="mb-4 flex items-center justify-between">
        <h3 class="text-lg font-semibold">Posts</h3>
        <select
            name="type"
            hx-get="{{ route('users.profile.posts', $user) }}"
            hx-trigger="change"
            hx-include="[name='type']"
            hx-target="#posts"
            hx-swap="innerHTML"
            class="cursor-pointer rounded border border-gray-200 bg-transparent p-2 text-sm text-gray-700 shadow"
            autocomplete="off"
        >
            <option value="" selected>All</option>
            <option value="default">Default</option>
            <option value="event">Events</option>
            <option value="job">Jobs</option>
        </select>
    </div>
    <div class="space-y-4" id="posts">
        @fragment('posts')
            @if (count($posts))
                @foreach ($posts as $post)
                    <x-post-card :post="$post" />
                @endforeach
            @else
                @if (request()->query('type') === 'event' || request()->query('type') === 'job')
                    <p class="text-sm leading-6 text-gray-500">User hasn't yet added any {{ request()->query('type') }} post.</p>
                @else
                    <p class="text-sm leading-6 text-gray-500">User hasn't yet added any post.</p>
                @endif
            @endif
        @endfragment
    </div>
</div>
