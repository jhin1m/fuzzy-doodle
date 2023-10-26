@props(['type' => 'manga', 'chapter'])

<h2 class="text-lg font-bold">
  {{ __(':manga - Chapter :chapter', ['manga' => $chapter->{$type}->title, 'chapter' => $chapter->chapter_number]) }}
  <span>{{ $chapter->title ? '(' . $chapter->title . ')' : '' }}</span>
</h2>
<span class="text-xs text-gray-500">
  {{ __('All chapter are in') }}
  <a class="text-black transition hover:text-opacity-60 dark:text-gray-300"
    href="{{ route($type . '.show', $chapter->{$type}->slug) }}">{{ $chapter->{$type}->title }}</a>
</span>
