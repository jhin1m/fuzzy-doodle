@props(['type' => 'manga', 'chapter', 'chapters', 'prevChapter', 'nextChapter'])

<div class="relative my-5 flex w-full flex-col gap-5 rounded-md bg-red-200/30 px-6 py-4 shadow-md dark:bg-zinc-900 lg:w-3/4">
  <div class="flex w-full flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div class="flex flex-col items-start">
      <h3 class="text-md font-bold !text-opacity-60 transition hover:text-opacity-80 dark:dark:text-white">
        <a href="{{ route($type . '.show', $chapter->{$type}->slug) }}">{{ $chapter->{$type}->title }}</a>
      </h3>

      <span class="block">
        {{ __(':manga - Chapter :chapter', ['manga' => $chapter->{$type}->title, 'chapter' => $chapter->chapter_number]) }}
        <span>{{ $chapter->title ? '(' . $chapter->title . ')' : '' }}</span>
      </span>
    </div>

    <div class="w-full sm:w-1/3">
      <x-select class="w-full" id="chapter-select" name="type" selected="{{ $chapter->id }}" :options="$chapters"></x-select>
    </div>

    <div class="grid grid-cols-2 gap-3">
      <x-chapter.buttons.previous :slug="$chapter->manga->slug" :chapter="$chapter->previous_chapter" :type="$type" />
      <x-chapter.buttons.next :slug="$chapter->manga->slug" :chapter="$chapter->next_chapter" :type="$type" />
    </div>
  </div>
</div>
