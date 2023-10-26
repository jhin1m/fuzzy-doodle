@section('title', __('Chapters List'))
@extends('dashboard.layout')
@section('content')

  <div class="flex flex-col gap-5">
    <div class="flex flex-col gap-1">
      <h3 class="text-3xl font-bold tracking-tight">{{ __('Chapters List') }}</h3>
      <p class="text-gray-500 dark:text-white dark:text-opacity-50">
        {{ __('Take control of your chapters from this page.') }}</p>
    </div>

    <div class="flex flex-col items-end justify-between gap-3 sm:flex-row sm:items-center">
      <x-input placeholder="{{ __('Filter...') }}" id="filter-table" />
      <div class="flex gap-2 self-end">

        @can('create_chapters')
          <x-table-button href="{{ route('dashboard.chapters.create') }}">
            <x-icons.add />
            <span>{{ __('Add new') }}</span>
          </x-table-button>
        @endcan

        @can('bulk_upload_chapters')
          <x-table-button href="{{ route('dashboard.chapters.bulk.create') }}">
            <x-icons.add />
            <span>{{ __('Add Bulk') }}</span>
          </x-table-button>
        @endcan
      </div>
    </div>

    <x-table :headings="['#', __('Manga'), _('Title'), __('Chapter number'), __('Uploader'), __('Views')]" :contents="$chapters
        ->map(function ($chapter) {
            return [
                'id' => $chapter->id,
                $chapter->manga->title,
                $chapter->title ?? '-',
                $chapter->chapter_number,
                $chapter->user->username,
                $chapter->totalViews(),
                'actions' => [
                    __('Edit') => route('dashboard.chapters.edit', $chapter->id),
                    __('Delete') => route('dashboard.chapters.delete', $chapter->id),
                ],
            ];
        })
        ->toArray()" />

    <div class="flex justify-end">
      {{ $chapters->appends(request()->query())->links('pagination.default') }}
    </div>
  </div>
@endsection
