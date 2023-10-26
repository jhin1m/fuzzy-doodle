@props(['slug', 'chapters', 'type' => 'manga'])

<div id="chapters-list" class="w-full lg:w-3/4">
  <h2 class="mb-3 block text-lg font-bold leading-[1rem]">{{ __('Chapters List') }}</h2>
  @if ($chapters->count() == 0)
    <p class="text-sm !text-opacity-60 dark:text-white">{{ __('No data has been found') }}</p>
  @endif

  @foreach ($chapters as $chapter)
    <a href="{{ route($type . '.chapter.show', [$slug, $chapter->chapter_number]) }}">
      <div
        class="group mb-2 flex flex-wrap justify-between rounded-md border-[1px] border-black/10 bg-transparent p-3 transition dark:border-white/10 dark:hover:bg-white dark:hover:text-black">
        <div class="flex gap-2">
          <span>{{ __('Chapter') . ' ' . $chapter->chapter_number }}</span>
          @if ($chapter->title)
            <span>-</span>
            <span>{{ $chapter->title }}</span>
          @endif
        </div>
        <div class="flex justify-between gap-3">
          <span class="text-gray-500">{{ $chapter->created_at ? $chapter->created_at->locale(__('lang'))->diffForHumans() : '-' }}</span>
          <p class="flex items-center gap-1">
            <span>{{ $chapter->totalViews() }}</span>
            <x-fas-eye class="h-4 w-4 text-black text-opacity-60 dark:text-white group-hover:dark:text-black" />
          </p>
        </div>
      </div>
    </a>
  @endforeach
  <div class="mt-5 flex justify-end">
    {{ $chapters->links('pagination.default') }}
  </div>
</div>
