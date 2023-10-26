@props(['chapters', 'type' => 'manga', 'slug' => ''])

<div class="flex flex-col">
  @foreach ($chapters as $chapter)
    <div class="mb-1 flex items-center justify-between text-sm">
      <a class="boder-black/10 w-fit rounded-md border-[1px] bg-transparent px-3 py-1 text-center text-xs transition hover:bg-black hover:text-white dark:border-white/10 dark:text-white dark:hover:bg-white dark:hover:text-black"
        href="{{ route($type . '.chapter.show', [$slug, $chapter->chapter_number]) }}">
        <span class="hidden sm:inline-block">{{ __('Chapter') }}</span>
        <span class="sm:hidden">{{ __('Chp') }}</span>
        <b>{{ $chapter->chapter_number }}</b>
      </a>
      <span
        class="text-xs text-gray-500 dark:text-gray-300 sm:block">{{ $chapter->created_at ? $chapter->created_at->locale(__('lang'))->diffForHumans(['short' => true]) : '-' }}</span>
    </div>
  @endforeach
</div>
