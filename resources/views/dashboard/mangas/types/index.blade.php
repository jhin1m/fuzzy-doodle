@section('title', __('Types List'))
@extends('dashboard.layout')
@section('content')

  <div class="flex flex-col gap-5">
    <div class="flex flex-col gap-1">
      <h3 class="text-3xl font-bold tracking-tight">{{ __('Types List') }}</h3>
      <p class="text-gray-500 dark:text-white dark:text-opacity-50">
        {{ __('Take control of your content Types from this page.') }}</p>
    </div>

    <div class="flex flex-col items-end justify-between gap-3 sm:flex-row sm:items-center">
      <x-input placeholder="{{ __('Filter...') }}" id="filter-table" />

      @can('create_taxonomies')
        <x-table-button href="{{ route('dashboard.mangas_types.create') }}">
          <x-icons.add />
          <span>{{ __('Add new') }}</span>
        </x-table-button>
      @endcan
    </div>

    <x-table :headings="['#', __('Title'), __('Slug')]" :contents="$types
        ->map(function ($type) {
            return [
                'id' => $type->id,
                $type->title,
                $type->slug,
                'actions' => [
                    __('Edit') => route('dashboard.mangas_types.edit', $type->id),
                    __('Delete') => route('dashboard.mangas_types.delete', $type->id),
                ],
            ];
        })
        ->toArray()" />

    <div class="flex justify-end">
      {{ $types->appends(request()->query())->links('pagination.default') }}
    </div>
  </div>
@endsection
