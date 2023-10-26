@props(['type' => 'manga', 'chapter', 'slug'])

<x-chapter.buttons.wrapper :slug="$slug" :type="$type" :chapter="$chapter"
  class="bg-blue-600 shadow-sm hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
  <span>{{ __('Next') }}</span>
  @if (__('direction') === 'ltr')
    <x-icons.chapter-forward />
  @else
    <x-icons.chapter-back />
  @endif
</x-chapter.buttons.wrapper>
