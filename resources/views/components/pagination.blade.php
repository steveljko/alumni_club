<div id="pagination" class="flex items-center justify-center space-x-2 py-4">
    <a
      class="control control-prev-page-full"
      data-action="first-page"
    >@svg('heroicon-s-chevron-double-left', 'w-5 h-5 text-white')</a>

    <a
      class="control control-prev-page"
      data-action="prev"
    >@svg('heroicon-o-chevron-left', 'w-5 h-5 text-white')</a>

    <div class="numbers | inline-flex space-x-2"></div>

    <a
      class="control control-next-page"
      data-action="next"
    >@svg('heroicon-o-chevron-right', 'w-5 h-5 text-white')</a>

    <a
      class="control control-next-page-full"
      data-action="last-page"
      data-page="{{ $model->lastPage() }}"
    >@svg('heroicon-s-chevron-double-right', 'w-5 h-5 text-white')</a>
</div>
