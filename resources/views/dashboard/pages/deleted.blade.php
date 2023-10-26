@section('title', __('Deleted Pages List'))
@extends('dashboard.layout')
@section('content')

  <div class="flex flex-col gap-5">
    <div class="flex flex-col gap-1">
      <h3 class="text-3xl font-bold tracking-tight">{{ __('Deleted Pages List') }}</h3>
      <p class="text-gray-500 dark:text-white dark:text-opacity-50">
        {{ __('List of deleted pages, you can either restore or permanently delete.') }}</p>
    </div>

    <div class="flex flex-col items-end justify-between gap-3 sm:flex-row sm:items-center">
      <x-input placeholder="{{ __('Filter...') }}" id="filter-table" />
      <x-table-button href="{{ route('dashboard.pages.index') }}">
        <x-icons.back />
        <span>{{ __('Back') }}</span>
      </x-table-button>
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
                    __('Restore') => route('dashboard.pages.restore', $page->id),
                    __('Delete') => route('dashboard.pages.hard_delete', $page->id),
                ],
            ];
        })
        ->toArray()" />
    <div>
      {{ $pages_pagination->appends(request()->query())->links('pagination.default') }}
    </div>
  </div>
@endsection
