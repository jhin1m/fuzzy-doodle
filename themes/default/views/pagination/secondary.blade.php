@php
  $class = __('direction') == 'ltr' ? 'rotate-180' : 'rotate-0';
@endphp

@if ($paginator->hasPages())
  <ul class="flex gap-2">
    @if ($paginator->onFirstPage())
      <li>
        <x-fas-angle-double-right class="text-white text-opacity-40 {{ $class }} w-4" />
      </li>
    @else
      <li>
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev">
          <x-fas-angle-double-right class="{{ $class }} w-4" />
        </a>
      </li>
    @endif

    @if ($paginator->hasMorePages())
      <li>
        <a href="{{ $paginator->nextPageUrl() }}" rel="next">
          <x-fas-angle-double-left class="{{ $class }} w-4" />
        </a>
      </li>
    @else
      <li>
        <span>
          <x-fas-angle-double-left class="text-white text-opacity-40 {{ $class }} w-4" />
        </span>
      </li>
    @endif
  </ul>
@endif
