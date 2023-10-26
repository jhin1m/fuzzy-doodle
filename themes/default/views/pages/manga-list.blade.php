@section('title', settings()->get('seo.mangas.title'))
@section('description', settings()->get('seo.mangas.description'))
@extends('layout')
@section('content')
  <form action="{{ route('manga.index') }}" method="GET" class="mb-4">
    <x-search.shared />
  </form>

  <h2 class="mb-3 text-lg font-bold">{{ __('Mangas List') }}</h2>

  @if ($mangas->count() == 0)
    <p class="mt-5 text-sm !text-opacity-60 dark:text-white">{{ __('No data has been found') }}</p>
  @endif

  <div class="xlg:grid-cols-8 grid grid-cols-3 gap-[10px] sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6">
    @foreach ($mangas as $manga)
      <div class="rounded-lg">
        <x-home.card :content="$manga" :link="route('manga.show', $manga->slug)" />
        <span class="mt-1 flex flex-wrap gap-1">
          @foreach ($manga->genres as $genre)
            <a href="{{ url('/manga?genre=' . $genre->slug) }}" class="flex rounded-md text-xs text-gray-500 transition hover:text-gray-400">
              <span>{{ $genre->title }}</span>
              @if (!$loop->last)
                <span>,</span>
              @endif
            </a>
          @endforeach
        </span>
      </div>
    @endforeach
  </div>
  <div class="mb-5 mt-5 flex justify-end">
    {{ $mangas->appends(request()->query())->links('pagination.default') }}
  </div>
@endsection
