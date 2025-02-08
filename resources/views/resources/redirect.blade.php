<div id="modal-content">
    <x-modal.header>You are leaving app</x-modal.header>
    <x-modal.body>
        <p class="mb-2 break-all text-gray-700">You are being redirected to <strong>{{ $url }}</strong>.</p>
        <p class="text-sm text-gray-500">Please click <i>'Continue'</i> to continue or <i>'Stay on App'</i> to cancel redirection.</p>
    </x-modal.body>
    <x-modal.footer>
        <x-modal.button variant="secondary" data-hide-modal="true">Stay on App</x-modal.button>
        <x-modal.button href="{{ $url }}">Continue</x-modal.button>
    </x-modal.footer>
</div>
