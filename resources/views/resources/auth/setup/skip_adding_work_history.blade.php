<div id="modal-content">
    <x-modal.header>Wan't to skip?</x-modal.header>
    <x-modal.body>
        <p class="text-sm leading-6 text-gray-500">
            This action is not permanent. Later on you can publish work histories in account settings.
        </p>
    </x-modal.body>
    <x-modal.footer>
        <x-modal.button variant="secondary" data-hide-modal="true">Cancel</x-modal.button>
        <x-modal.button hx-patch="{{ route('auth.setup.step.3.skip') }}" hx-indicator="#spinner">Skip This Step</x-modal.button>
    </x-modal.footer>
</div>
