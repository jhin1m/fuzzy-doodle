@section('title', __('Manga Status List'))
@extends('dashboard.layout')
@section('content')

  <div class="flex flex-col gap-5">
    <div class="flex flex-col gap-1">
      <h3 class="text-3xl font-bold tracking-tight">{{ __('Status List') }}</h3>
      <p class="text-gray-500 dark:text-white dark:text-opacity-50">
        {{ __('Take control of your content Statuses from this page.') }}</p>
    </div>

    <div class="flex flex-col items-end justify-between gap-3 sm:flex-row sm:items-center">
      <x-input placeholder="{{ __('Filter...') }}" id="filter-table" />

      @can('create_taxonomies')
        <x-table-button href="{{ route('dashboard.mangas_status.create') }}">
          <x-icons.add />
          <span>{{ __('Add new') }}</span>
        </x-table-button>
      @endcan
    </div>

    <x-table :headings="['#', __('Title'), __('Slug')]" :contents="$statuses
        ->map(function ($status) {
            return [
                'id' => $status->id,
                $status->title,
                $status->slug,
                'actions' => [
                    __('Edit') => route('dashboard.mangas_status.edit', $status->id),
                    __('Delete') => route('dashboard.mangas_status.delete', $status->id),
                ],
            ];
        })
        ->toArray()" />

    <div class="flex justify-end">
      {{ $statuses->appends(request()->query())->links('pagination.default') }}
    </div>
  </div>
@endsection
