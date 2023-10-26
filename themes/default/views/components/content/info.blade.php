@props(['content', 'type' => 'manga'])
@if (isset($content))
  <div class="flex w-full shrink-0 flex-col gap-3 rounded-lg sm:w-[17rem]">
    <div class="relative">
      <div class="to-dark-primary absolute inset-0 -bottom-1 bg-gradient-to-b from-transparent sm:hidden"></div>
      <img class="h-full w-full rounded-lg object-cover object-bottom sm:max-h-[300px] md:max-h-[400px]"
        src="{{ asset('storage/covers/' . $content->cover) }}" alt="{{ $content->title }}">
    </div>
    <x-content.buttons isNovel="{{ $type === 'novel' ? 'true' : 'false' }}" :firstChapter="$content->first_chapter" :slug="$content->slug" :id="$content->id" />
    <div class="hidden sm:flex sm:flex-col sm:gap-1 sm:text-sm">
      {{ $slot ?? '' }}
    </div>
  </div>
@endif
