@php
  $class = __('direction') === 'rtl' ? 'left-4' : 'right-4';
@endphp

<form method="GET" action="{{ route('manga.index') }}" class="flex gap-3" id="search-form">
  <div class="relative w-full">
    <x-input id="search-input" name="title" class="w-full sm:bg-[#191919]" placeholder="{{ __('Search for content...') }}" required />
    <button class="{{ $class }} absolute top-1/2 -translate-y-1/2">
      <x-fas-search class="h-4 w-4 text-blue-500 transition-colors duration-200 hover:text-blue-600" />
    </button>
  </div>
</form>
