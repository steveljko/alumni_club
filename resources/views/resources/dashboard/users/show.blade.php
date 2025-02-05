<div id="modal-content">
    <x-modal.header>{{ $user->name }}</x-modal.header>
    <x-modal.body>
        <img
            class="mb-4 h-16 w-16 rounded-full"
            id="profileAvatar"
            src="{{ asset('storage/images/' . $user->avatar) }}"
            alt="Profile Avatar"
        >
        <div class="divide-y divide-gray-200">
            <div class="flex justify-between py-2">
                <label class="text-gray-500">Email Address</label>
                <span class="font-medium text-gray-800">{{ $user->email }}</span>
            </div>
            <div class="flex justify-between py-2">
                <label class="text-gray-500">Posts</label>
                <span class="font-medium text-gray-800">{{ $postCount }}</span>
            </div>
            <div class="flex justify-between py-2">
                <label class="text-gray-500">Comments</label>
                <span class="font-medium text-gray-800">{{ $commentCount }}</span>
            </div>
        </div>
    </x-modal.body>
    <x-modal.footer>
        <x-modal.button variant="secondary" href="{{ route('profile', $user->id) }}">View Profile</x-modal.button>
        <x-modal.button data-hide-modal="true">Close</x-modal.button>
    </x-modal.footer>
</div>
