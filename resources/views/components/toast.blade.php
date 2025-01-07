<div id="toast"
    role="status"
    class="{{ session('toast') ? 'block' : 'hidden' }} fixed bottom-8 left-1/2 z-10 min-w-[250px] -translate-x-1/2 transform rounded-md bg-white text-center text-blue-50 shadow">
    <div class="py-3 text-gray-700">
        @if (session('toast'))
            {{ session('toast') }}
        @endif
    </div>
    <div class="animate-shrink h-[4px] rounded-b-md bg-blue-300"></div>
</div>
