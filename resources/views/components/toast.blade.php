<div id="toast"
    role="status"
    class="{{ session('toast') ? 'block' : 'hidden' }} fixed bottom-8 left-1/2 z-10 min-w-[250px] -translate-x-1/2 transform rounded-md bg-gray-800 p-4 text-center text-white">
    @if (session('toast'))
        {{ session('toast') }}
    @endif
</div>
