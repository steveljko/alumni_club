<div id="modal-content">
    <x-modal.header>Activity Log</x-modal.header>
    <x-modal.body>
        <div class="flex justify-between border-b border-gray-200 py-2">
            <span class="font-semibold">Event</span>
            <span class="text-gray-600">{{ $activity->event }}</span>
        </div>
        <div class="flex justify-between border-b border-gray-200 py-2">
            <span class="font-semibold">Model</span>
            <span class="text-gray-600">{{ $activity->model_name }}</span>
        </div>
        <div class="flex justify-between border-b border-gray-200 py-2">
            <span class="font-semibold">Table</span>
            <span class="text-gray-600">{{ $activity->table_name }}</span>
        </div>
        <div class="flex justify-between border-b border-gray-200 py-2">
            <span class="font-semibold">User</span>
            <span class="text-gray-600">
                <a href="{{ route('users.profile', $activity->user) }}" class="text-navyblue-500 hover:underline">{{ $activity->user->name }}</a>
            </span>
        </div>
        <div class="flex justify-between border-b border-gray-200 py-2">
            <span class="font-semibold">IP Address</span>
            <span class="text-gray-600">{{ $activity->ip_address }}</span>
        </div>
        <div class="py-2">
            <span class="font-semibold">Data</span>
            <div class="shj-lang-json shj-multiline" style="font-size: .8rem">{{ collect($activity->data)->toJson(JSON_PRETTY_PRINT) }}</div>
        </div>
    </x-modal.body>
    <x-modal.footer>
        <x-modal.button variant="secondary" data-hide-modal="true">Close</x-modal.button>
    </x-modal.footer>
</div>
