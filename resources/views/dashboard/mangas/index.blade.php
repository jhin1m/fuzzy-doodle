@section('title', __('Mangas List'))
@extends('dashboard.layout')
@section('content')

  <div class="flex flex-col gap-5">
    <div class="flex flex-col gap-1">
      <h3 class="text-3xl font-bold tracking-tight">{{ __('Mangas List') }}</h3>
      <p class="text-gray-500 dark:text-white dark:text-opacity-50">
        {{ __('Take control of your mangas from this page.') }}
      </p>
    </div>

    <div class="flex flex-col items-end justify-between gap-3 sm:flex-row sm:items-center">
      <x-input placeholder="{{ __('Filter...') }}" id="filter-table" />
      @can('create_mangas')
        <x-table-button href="{{ route('dashboard.mangas.create') }}">
          <x-icons.add />
          <span>{{ __('Add new') }}</span>
        </x-table-button>
      @endcan
    </div>
    <x-table :headings="['#', __('Title'), __('Slug'), __('Description'), __('Uploader'), __('Views'), __('Status')]" :contents="$mangas
        ->map(function ($manga) {
            return [
                'id' => $manga->id,
                $manga->title,
                $manga->slug,
                \Illuminate\Support\Str::limit(strip_tags($manga->description), 50, $end = '...'),
                $manga->user->username,
                $manga->views,
                $manga->status == 'publish' ? __('Publish') : __('Private'),
                'actions' => [
                    __('Chapters') => route('dashboard.chapters.index') . '?manga=' . $manga->id,
                    __('New Chapter') => route('dashboard.chapters.create') . '?manga=' . $manga->id,
                    __('Buld Upload') => route('dashboard.chapters.bulk.create') . '?manga=' . $manga->id,
                    __('Edit') => route('dashboard.mangas.edit', $manga->id),
                    __('Delete') => route('dashboard.mangas.delete', $manga->id),
                ],
            ];
        })
        ->toArray()" />

    <div class="flex justify-end">
      {{ $mangas->appends(request()->query())->links('pagination.default') }}
    </div>
  </div>
@endsection
