@props(['type' => 'manga', 'chapter', 'slug'])

@php
  $link = $chapter ? route($type . '.chapter.show', [$slug, $chapter]) : null;
@endphp

<a {{ $link ? 'href=' . $link : '' }}>
  <button
    {{ $attributes->merge(['class' => (!isset($chapter) ? '!bg-opacity-40 cursor-not-allowed ' : '') . 'flex w-full items-center justify-center gap-2 rounded-md px-4 py-3 text-sm font-semibold text-white transition']) }}>
    {{ $slot ?? '' }}
  </button>
</a>
