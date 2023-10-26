@section('title', __('Bookmarks'))
@extends('layout')
@section('content')
  <h2 class="mb-3 text-lg font-bold">{{ __('Bookmarks') }} - {{ auth()->user()->username }}</h2>
  @if ($paginatedBookmarks->count() == 0)
    <p class="mt-5 text-sm !text-opacity-60 dark:text-white">
      {{ __('No bookmarks found! try to add one and try again.') }}</p>
  @endif
  <div class="xlg:grid-cols-8 grid grid-cols-3 gap-[10px] sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6">
    @foreach ($paginatedBookmarks as $bookmark)
      <div class="rounded-lg">
        <a href="{{ route('manga.show', $bookmark->slug) }}">
          <figure class="relative">
            <div
              class="absolute bottom-0 left-0 h-full w-full rounded-lg bg-gradient-to-b from-transparent to-black/50 transition hover:opacity-0">
            </div>
            <img class="h-56 w-full rounded-lg object-cover sm:h-64" src="{{ asset('storage/covers/' . $bookmark->cover) }}"
              alt="{{ $bookmark->title }}">

            <div class="absolute bottom-0 p-4">
              <p class="text-xs font-semibold capitalize leading-[1rem] text-gray-300">
                {{ $bookmark->type == 'manga' ? __('Manga') : __('Novel') }}
              </p>
              <h2 class="text-sm font-semibold text-white">
                {{ \Illuminate\Support\Str::limit(strip_tags($bookmark->title), 25, $end = '...') }}
              </h2>
            </div>
          </figure>
        </a>
      </div>
    @endforeach
  </div>
  <div class="mb-5 mt-5 flex justify-end">
    {{ $paginatedBookmarks->links('pagination.default') }}
  </div>
@endsection
