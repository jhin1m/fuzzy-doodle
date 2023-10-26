@props(['headings'])

@php
  $class = __('direction') === 'rtl' ? 'text-right' : 'text-left';
  $class_dir = __('direction') === 'rtl' ? 'pr-4' : 'pl-4';
@endphp

<thead class="bg-transparent">
  <tr class="border-b-[1px] border-black/10 dark:border-white/10">
    @foreach ($headings as $heading)
      <th scope="col"
        class="{{ $class }} {{ $class_dir }} py-2 text-[13px] text-sm font-medium text-black text-opacity-60 dark:text-white">
        <div class="group flex cursor-pointer items-center gap-1">
          <span>{{ $heading }}</span>
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
          </svg>
        </div>
      </th>
    @endforeach
  </tr>
</thead>
