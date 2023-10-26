@if ($paginator->hasPages())
  <nav class="flex items-center gap-5">
    <h3 class="hidden sm:block">
      {{ __('Page :page of :last', ['page' => $paginator->currentPage(), 'last' => $paginator->lastPage()]) }}
    </h3>
    <ul class="pagination flex gap-1">
      {{-- Previous Page Link --}}
      @if ($paginator->onFirstPage())
        <li class="pagination-link pagination-disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
          <x-icons.left-arrow class="{{ __('direction') === 'rtl' ? '-scale-x-100' : '' }} block h-4 w-4" />
        </li>
      @else
        <li class="pagination-link" onclick="window.location.href='{{ $paginator->previousPageUrl() }}'">
          <x-icons.left-arrow class="{{ __('direction') === 'rtl' ? '-scale-x-100' : '' }} block h-4 w-4" />
        </li>
      @endif

      {{-- First Page --}}
      @if ($paginator->currentPage() > 3)
        <li class="pagination-link" onclick="window.location.href='{{ $paginator->url(1) }}'">
          <x-icons.left-arrows class="{{ __('direction') === 'rtl' ? '-scale-x-100' : '' }} block h-4 w-4" />
        </li>
      @endif

      {{-- Middle Pages --}}
      @if ($paginator->lastPage() > 1)
        @php
          $visiblePages = min(4, $paginator->lastPage());
          $startPage = max(1, $paginator->currentPage() - floor($visiblePages / 2));
          $endPage = $startPage + $visiblePages - 1;
          $endPage = min($endPage, $paginator->lastPage());
        @endphp

        @for ($page = $startPage; $page <= $endPage; $page++)
          @if ($paginator->currentPage() == $page)
            <li class="pagination-link pagination-active" aria-current="page"><span>{{ $page }}</span></li>
          @else
            <li class="pagination-link" onclick="window.location.href='{{ $paginator->url($page) }}'">{{ $page }}</li>
          @endif
        @endfor
      @endif

      {{-- Last Page --}}
      @if ($paginator->currentPage() < $paginator->lastPage() - 2)
        @if ($paginator->lastPage() > $endPage + 1)
          <li class="disabled flex items-center justify-center rounded-md border-[1px] border-white/10 px-3 py-2" aria-disabled="true">
            <span>&hellip;</span>
          </li>
        @endif

        <li class="pagination-link" onclick="window.location.href='{{ $paginator->url($paginator->lastPage()) }}'">
          <x-icons.right-arrows class="{{ __('direction') === 'rtl' ? '-scale-x-100' : '' }} h-4 w-4" />
        </li>
      @endif

      {{-- Next Page Link --}}
      @if ($paginator->hasMorePages())
        <li class="pagination-link" onclick="window.location.href='{{ $paginator->nextPageUrl() }}'">
          <x-icons.right-arrow class="{{ __('direction') === 'rtl' ? '-scale-x-100' : '' }} h-4 w-4" />
        </li>
      @else
        <li class="pagination-link pagination-disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
          <x-icons.right-arrow class="{{ __('direction') === 'rtl' ? '-scale-x-100' : '' }} h-4 w-4" />
        </li>
      @endif
    </ul>
  </nav>
@endif
