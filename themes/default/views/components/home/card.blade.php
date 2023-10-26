@props(['content', 'link'])

@php
  $fallbackImagePath = 'images/no-image.png';
  $imagePath = $content->cover ? 'storage/covers/' . $content->cover : null;
  $imageUrl = $imagePath ? asset($imagePath) : asset($fallbackImagePath);
@endphp
<div class="rounded-lg border-[1px] border-black/10 dark:border-none" id="card-loader">
  <figure class="group relative">
    <div class="h-56 w-full rounded-lg bg-white object-cover ring-slate-900/5 dark:bg-slate-800 sm:h-64"></div>
    <div class="absolute bottom-0 flex w-full animate-pulse flex-col gap-2 p-4">
      <div class="h-2 w-2/3 rounded bg-slate-200 dark:bg-slate-700"></div>
      <div class="h-2 rounded bg-slate-200 dark:bg-slate-700"></div>
    </div>
  </figure>
</div>
<div class="hidden rounded-lg" id="card-real">
  <a href="{{ $link }}">
    <figure class="group relative">
      <div class="absolute bottom-0 left-0 h-full w-full rounded-lg bg-gradient-to-b from-transparent to-black/50 transition">
      </div>
      <x-home.image data-src="{{ $imageUrl }}" alt="{{ $content->title }}" />
      <div class="absolute bottom-0 p-4">
        <p class="{{ !$content->description ?: 'group-hover:hidden' }} text-xs capitalize leading-[1rem] text-white text-opacity-60">
          {{ __($content->type) }}</p>
        <x-home.card-title
          class="{{ !$content->description ?: 'group-hover:hidden' }}">{{ Str::limit(strip_tags($content->title), 25, $end = '...') }}</x-home.card-title>
      </div>
      <div class="absolute bottom-0 p-2 md:p-4">
        <div
          class="{{ !$content->description ?: 'group-hover:scale-y-100 group-hover:opacity-100' }} flex scale-y-50 flex-col gap-2 text-xs font-medium text-white opacity-0 transition">
          <x-home.card-title>{{ Str::limit(strip_tags($content->title), 25, $end = '...') }}</x-home.card-title>
          @if ($content->description)
            <p>
              {{ Str::limit(strip_tags(html_entity_decode($content->description)), 100, $end = '...') }}
            </p>
          @endif
        </div>
      </div>
    </figure>
  </a>
</div>
