@section('title', strtr(settings()->get('seo.chapter.title'), [':manga' => $chapter->manga->title, ':chapter' => $chapter->chapter_number]))
@section('description', strtr(settings()->get('seo.chapter.description'), [':manga' => $chapter->manga->title, ':chapter' =>
  $chapter->chapter_number]))
  @extends('layout')
@section('content')
  <section class="flex flex-col items-center">
    <x-chapter.header :chapter="$chapter" />
    <x-chapter.info :chapter="$chapter" :chapters="$options" />
    <div class="mx-auto max-w-3xl" id="chapter-container">
      <x-ads.main identifier="above-images-chapter" />
      @if (count($chapter->content) > 0)
        @foreach ($chapter->content as $index => $image)
          @if (settings()->get('chapter.lazyload'))
            <img class="lazyload chapter-image w-full cursor-pointer" data-id="{{ $index }}"
              data-src="{{ asset('storage/content/' . $chapter->manga->slug . '/' . $chapter->chapter_number . '/' . $image) }}"
              alt="{{ $chapter->manga->title }} - {{ $chapter->chapter_number }} - {{ $image }}" />
          @else
            <img class="chapter-image w-full cursor-pointer" data-id="{{ $index }}"
              src="{{ asset('storage/content/' . $chapter->manga->slug . '/' . $chapter->chapter_number . '/' . $image) }}"
              alt="{{ $chapter->manga->title }} - {{ $chapter->chapter_number }} - {{ $image }}" />
          @endif
        @endforeach
      @else
        <p>{{ __('Empty Chapter') }}</p>
      @endif
      <x-ads.main identifier="below-images-chapter" />
    </div>
    <x-chapter.info :chapter="$chapter" :chapters="$options" />
    <div class="container mx-auto mt-10 flex justify-center px-3 sm:px-0 md:px-0">
      <div id="comments-list" class="w-full lg:w-3/4">
        @include('comments.index', [
            'comments' => $chapter->comments,
            'model' => $chapter,
            'type' => \App\Models\Chapter::class,
        ])
      </div>
    </div>
  </section>
  <div class="group fixed bottom-[3vh] right-[5vw] cursor-pointer rounded-full p-2 opacity-50 hover:opacity-100">
    <a id="chapter-modal">
      <svg width="48" height="48" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
        class="h-9 w-9 transition group-hover:fill-blue-500">
        <path fill-rule="evenodd"
          d="M13.788 3.804c-.456-1.872-3.12-1.872-3.576 0a1.839 1.839 0 0 1-2.743 1.138c-1.647-1.004-3.53.88-2.527 2.527a1.84 1.84 0 0 1-1.137 2.744c-1.873.455-1.873 3.12 0 3.574a1.838 1.838 0 0 1 1.137 2.744c-1.004 1.647.88 3.53 2.527 2.527a1.839 1.839 0 0 1 2.744 1.137c.455 1.873 3.12 1.873 3.574 0a1.84 1.84 0 0 1 2.744-1.137c1.647 1.004 3.53-.88 2.527-2.527a1.839 1.839 0 0 1 1.137-2.744c1.873-.455 1.873-3.12 0-3.574a1.838 1.838 0 0 1-1.137-2.744c1.004-1.647-.88-3.53-2.527-2.527a1.838 1.838 0 0 1-2.744-1.137l.001-.001ZM12 15.6a3.6 3.6 0 1 0 0-7.2 3.6 3.6 0 0 0 0 7.2Z"
          clip-rule="evenodd"></path>
      </svg>
    </a>
  </div>
  <x-chapter.settings />

@endsection
