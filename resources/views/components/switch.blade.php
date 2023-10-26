<label class="relative inline-flex cursor-pointer items-center gap-3">
  <input type="checkbox" class="peer sr-only" {{ $attributes }}>

  @php
    $class = __('direction') == 'ltr' ? 'after:left-[2px]' : 'after:right-[22px]';
  @endphp
  <div
    class="{{ $class }} peer h-6 w-11 rounded-full bg-gray-200 after:absolute after:top-0.5 after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-blue-600 peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:ring-4 peer-focus:ring-blue-300 dark:border-gray-600 dark:bg-gray-700 dark:peer-focus:ring-blue-800">
  </div>
  <span class="text-sm font-medium text-gray-900 dark:text-gray-300">{{ $slot ?? '' }}</span>
</label>
