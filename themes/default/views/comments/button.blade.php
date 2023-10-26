@php
  $class = __('direction') === 'rtl' ? 'left-4' : 'right-4';
@endphp

<button class="{{ $class }} absolute top-1/2 -translate-y-1/2" type="submit">
  <x-fas-paper-plane class="h-5 w-5 text-blue-500" />
</button>
