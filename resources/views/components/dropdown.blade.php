@props(['nav' => false])

@php
  $mainClassesList = $nav ? 'dropdown-menu hidden sm:z-20 sm:absolute sm:top-6 sm:left-0 sm:bg-white sm:border-black/10 sm:dark:bg-[#09090b] sm:border-[1px] sm:dark:border-white/10 sm:p-2 sm:rounded-md text-sm sm:min-w-[200px] max-w-fit' : 'dropdown-menu absolute left-0 top-6 z-20 hidden min-w-[200px] max-w-fit rounded-md border-[1px] border-black/10 bg-white p-2 text-sm dark:border-white/10 dark:bg-[#09090b]';
  $childClassesList = $nav ? 'flex flex-col px-2 sm:px-0 sm:pt-0' : 'flex flex-col px-0 pt-0';
@endphp

<div {{ $attributes->merge(['class' => $mainClassesList]) }}>
  <div class="{{ $childClassesList }}">
    {{ $slot ?? '' }}
  </div>
</div>
