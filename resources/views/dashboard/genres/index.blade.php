@section('title', __('Genres List'))
@extends('dashboard.layout')
@section('content')

  <div class="flex flex-col gap-5">
    <div class="flex flex-col gap-1">
      <h3 class="text-3xl font-bold tracking-tight">{{ __('Genres List') }}</h3>
      <p class="text-gray-500 dark:text-white dark:text-opacity-50">
        {{ __('Take control of your genres from this page.') }}</p>
    </div>

    <div class="flex flex-col items-end justify-between gap-3 sm:flex-row sm:items-center">
      <x-input placeholder="{{ __('Filter...') }}" id="filter-table" />

      @can('create_taxonomies')
        <x-table-button href="{{ route('dashboard.genres.create') }}">
          <x-icons.add />
          <span>{{ __('Add new') }}</span>
        </x-table-button>
      @endcan
    </div>

    <x-table :headings="['#', __('Name'), __('Slug')]" :contents="$genres
        ->map(function ($genre) {
            return [
                'id' => $genre->id,
                $genre->title,
                $genre->slug,
                'actions' => [
                    __('Edit') => route('dashboard.genres.edit', $genre->id),
                    __('Delete') => route('dashboard.genres.delete', $genre->id),
                ],
            ];
        })
        ->toArray()" />

    <div class="flex justify-end">
      {{ $genres->appends(request()->query())->links('pagination.default') }}
    </div>
  </div>
@endsection
