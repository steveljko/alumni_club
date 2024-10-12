<div class="flex items-center justify-center space-x-2 py-4">
    <a
      href="{{ $model->url(1) }}"
      class="w-8 h-8 flex items-center justify-center text-gray-700 bg-blue-700 rounded hover:bg-gray-300 transition"
    > @svg('heroicon-s-chevron-double-left', 'w-5 h-5 text-white')</a>

    <a
      href="{{ $model->previousPageUrl() }}"
      class="w-8 h-8 flex items-center justify-center bg-blue-700 rounded hover:bg-gray-300 transition"
    >@svg('heroicon-o-chevron-left', 'w-5 h-5 text-white')</a>

    @php
        $currentPage = $model->currentPage();
        $lastPage = $model->lastPage();
        $range = 2;
    @endphp

    @for($i = max(1, $currentPage - $range); $i <= min($lastPage, $currentPage + $range); $i++)
        @if($i == $currentPage)
            <span class="w-8 h-8 flex items-center justify-center text-center text-white bg-blue-700 rounded hover:bg-blue-900 transition cursor-pointer">{{ $i }}</span>
        @else
            <a
              href="{{ $model->url($i) }}"
              class="w-8 h-8 flex items-center justify-center text-center text-gray-700 bg-gray-50 shadow rounded hover:bg-gray-200 transition cursor-pointer">
                {{ $i }}
          </a>
        @endif
    @endfor

    @if($currentPage > 1)
        <a
          href="{{ $model->nextPageUrl() }}"
          class="w-8 h-8 flex items-center justify-center bg-blue-700 shadow rounded hover:bg-gray-300 transition"
        >
          @svg('heroicon-o-chevron-right', 'w-5 h-5 text-white')
        </a>
    @endif

    @if($currentPage < $lastPage)
        <a
          href="{{ $model->url($lastPage) }}"
          class="w-8 h-8 flex items-center justify-center text-white bg-blue-700 rounded hover:bg-gray-300 transition"
        >@svg('heroicon-s-chevron-double-right', 'w-5 h-5 text-white')</a>
    @endif
</div>
