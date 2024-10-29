<div :id="$id" class="fixed inset-0 z-50 flex justify-end bg-black bg-opacity-50 hidden">
    <div class="bg-white rounded-tl-lg shadow-lg p-6 mt-2 w-1/3">
        <div>
            <span id="close" class="cursor-pointer text-gray-500 float-right">&times;</span>
            <h2 class="text-lg font-semibold mb-4">{{ $title }}</h2>
        </div>
        <div>
          {{ $slot }}
        </div>
    </div>
</div>
