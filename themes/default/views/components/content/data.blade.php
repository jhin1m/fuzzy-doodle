@props(['content', 'comments', 'type' => 'manga', 'modelClass' => \App\Models\Manga::class])

@if (isset($content))
  <div {{ $attributes->merge(['class' => 'flex w-full flex-col gap-3']) }}>
    <x-ads.main identifier="above-title-manga" />
    <x-content.share :link="route($type . '.show', $content->id)" />
    @if (count($content->genres) > 0)
      <x-content.genres :genres="$content->genres" :type="$type" />
    @endif
    <div class="flex flex-col gap-1">
      <h2 class="text-2xl font-bold leading-[1.5rem]">{{ $content->title }}
        <span class="text-sm capitalize !text-opacity-50 dark:text-white">
          [{{ $content->type_title ?? '-' }}]
        </span>
      </h2>
      @if ($content->alternative_titles)
        <div class="flex gap-1">
          <span class="font-semibold">{{ __('Alternative Titles:') }}</span>
          <span class="block text-sm text-gray-700 dark:text-gray-400">{{ $content->alternative_titles }}</span>
        </div>
      @endif
    </div>

    <div class="flex flex-col gap-1">
      <div class="flex flex-col gap-1">
        <span class="font-semibold underline">{{ __('Story of: :title', ['title' => $content->title]) }}</span>
        <p class="text-black dark:text-gray-100" id="description">
          {!! $content->description ?? '' !!}
        </p>
        <span id="show-more" class="hidden cursor-pointer transition hover:text-gray-400">...{{ __('Show more') }}</span>
      </div>
    </div>
    <div class="-mb-3 mt-3 flex gap-3">
      <x-content.data-icon :text="$content->views">
        <x-fas-eye class="h-4 w-4 text-black text-opacity-60 dark:text-white" />
      </x-content.data-icon>
      <x-content.data-icon :text="$content->bookmarks_count">
        <x-fas-bookmark class="h-4 w-4 text-red-500" />
      </x-content.data-icon>
      <x-content.data-icon :text="$content->rate">
        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
          class="h-5 w-5 text-yellow-500">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
        </svg>

      </x-content.data-icon>
    </div>
    <x-ads.main identifier="below-information-manga" />
    <div class="-mb-3 mt-4 flex gap-3">
      <button id="showChapters" class="tab-active px-3 py-3">{{ __('Chapters') . " ({$content->chapters_number})" }}</button>
      <button id="showInfo" class="px-3 py-3">{{ __('Comments') }} ({{ $comments->count() }})</button>
    </div>
    <hr class="h-px border-0 bg-gray-500 bg-opacity-10" />
    <div class="mt-3 block lg:flex lg:gap-5">
      <x-content.chapters :slug="$content->slug" :chapters="$content->chapters" :type="$type" />
      <div id="comments-list" class="hidden w-full lg:w-3/4">
        @include('comments.index', [
            'comments' => $comments,
            'model' => $content,
            'type' => $modelClass,
        ])
      </div>
      <x-content.uploader :user="$content->user" />
    </div>
  </div>
@endif
