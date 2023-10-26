@section('title', __('Homepage'))
@extends('layout')
@section('content')
  @if (!request()->has('page') || request('page') == 1)
    @if (settings()->get('theme.slider'))
      @if ($sliders->count() > 0)
        <x-home.slider :sliders="$sliders" />
      @endif
    @endif

    <!-- Popular by views -->
    <x-ads.main identifier="above-popular-home" />
    @if ($popular->count() > 0)
      <section>
        <div class="flex items-center justify-between">
          <x-home.heading>{{ __('Most Popular') }}</x-home.heading>
          <a href="{{ route('manga.index') }}">
            <x-home.heading-more>{{ __('View More') }}</x-home.heading-more>
          </a>
        </div>
        <swiper-container id="popular-cards" class="max-h-lg cards-container pb-7">
          @foreach ($popular as $content)
            <swiper-slide class="manga-swipe">
              <x-home.card :content="$content" :link="route(($content->type ? $content->type : 'manga') . '.show', $content->slug)" />
            </swiper-slide>
          @endforeach
        </swiper-container>
      </section>
    @endif

    <!-- Latest Mangas -->
    <x-ads.main identifier="above-latest-home" />
    @if ($latest->count() > 0)
      <section>
        <div class="flex items-center justify-between">
          <x-home.heading>{{ __('Recently Added') }}</x-home.heading>
          <a href="{{ route('manga.index') }}">
            <x-home.heading-more>{{ __('View More') }}</x-home.heading-more>
          </a>
        </div>
        <swiper-container class="cards-container" id="latest-cards">
          @foreach ($latest as $content)
            <swiper-slide class="rounded-lg">
              <x-home.card :content="$content" :link="route(($content->type ? $content->type : 'manga') . '.show', $content->slug)" />
            </swiper-slide>
          @endforeach
        </swiper-container>
      </section>
    @else
      <x-info>
        {{ __('There is no content yet.') }}
        </x-alert.info>
    @endif
  @endif

  <!-- Latest Chapters -->
  <x-ads.main identifier="above-chapters-home" />
  @if ($chapters->count() > 0)
    <section>
      <div class="flex items-center justify-between">
        <x-home.heading>{{ __('Recent Chapters') }}</x-home.heading>
        <a href="{{ route('manga.index') }}">
          <x-home.heading-more>{{ __('View More') }}</x-home.heading-more>
        </a>
      </div>
      <div class="xlg:grid-cols-8 grid grid-cols-3 gap-[10px] sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6">
        @foreach ($chapters as $chapter)
          <div class="flex flex-col gap-2">
            <x-home.card :content="$chapter" :link="route(($chapter->type ? $chapter->type : 'manga') . '.show', $chapter->slug)" />
            <x-home.chapters :chapters="$chapter->chapters" :type="$chapter->type" :slug="$chapter->slug" />
          </div>
        @endforeach
      </div>
      <div class="mb-5 mt-5 flex justify-end">
        {{ $chapters->links('pagination.default') }}
      </div>
    </section>
  @endif

@endsection
