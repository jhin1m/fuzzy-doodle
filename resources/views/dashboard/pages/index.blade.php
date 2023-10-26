@section('title', __('Pages List'))
@extends('dashboard.layout')
@section('content')

  <div class="flex flex-col gap-5">
    <div class="flex flex-col gap-1">
      <h3 class="text-3xl font-bold tracking-tight">{{ __('Pages List') }}</h3>
      <p class="text-gray-500 dark:text-white dark:text-opacity-50">
        {{ __('Take control of your pages from this page, soft delete is active so when page is deleted you can still find it inside the trash.') }}
      </p>
    </div>

    <div class="flex flex-col items-end justify-between gap-3 sm:flex-row sm:items-center">
      <x-input placeholder="{{ __('Filter...') }}" id="filter-table" />
      <div class="flex gap-2">
        @can('create_pages')
          <x-table-button href="{{ route('dashboard.pages.create') }}">
            <x-icons.add />
            <span>{{ __('Add new') }}</span>
          </x-table-button>
        @endcan
        <x-table-button href="{{ route('dashboard.pages.deleted') }}">
          <x-icons.bin />
          <span>{{ __('Deleted Pages') }}</span>
        </x-table-button>
      </div>
    </div>

    <x-table :headings="['#', __('Title'), __('Slug'), __('Creator'), __('Views')]" :contents="$pages_pagination
        ->map(function ($page) {
            return [
                'id' => $page->id,
                $page->title,
                $page->slug,
                $page->user->username,
                $page->views->count(),
                'actions' => [
                    __('Edit') => route('dashboard.pages.edit', $page->id),
                    __('Delete') => route('dashboard.pages.delete', $page->id),
                ],
            ];
        })
        ->toArray()" />
    <div>
      {{ $pages_pagination->appends(request()->query())->links('pagination.default') }}
    </div>
  </div>
@endsection
