@section('title', __('Mangas List'))
@extends('dashboard.layout')
@section('content')

  <div class="flex flex-col gap-5">
    <div class="flex flex-col gap-1">
      <h3 class="text-3xl font-bold tracking-tight">{{ __('Mangas List - Trashed') }}</h3>
      <p class="text-gray-500 dark:text-white dark:text-opacity-50">
        {{ __('List of deleted mangas, you can either restore or permanently delete.') }}</p>
    </div>
    <div class="flex flex-col items-end justify-between gap-3 sm:flex-row sm:items-center">
      <x-input placeholder="{{ __('Filter...') }}" id="filter-table" />
      <x-table-button href="{{ route('dashboard.mangas.index') }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-3 w-3">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
        </svg>
        <span>{{ __('Mangas List') }}</span>
      </x-table-button>
    </div>

    <x-table :headings="['#', __('Title'), __('Slug'), __('Description'), __('Uploader'), __('Views')]" :contents="$mangas
        ->map(function ($manga) {
            return [
                'id' => $manga->id,
                $manga->title,
                $manga->slug,
                \Illuminate\Support\Str::limit(strip_tags($manga->description), 50, $end = '...'),
                $manga->user->username,
                $manga->views->count(),
    
                'restore' => route('dashboard.mangas.restore', $manga->id),
                'delete' => route('dashboard.mangas.hard_delete', $manga->id),
            ];
        })
        ->toArray()" />

    <div class="flex justify-end">
      {{ $mangas->appends(request()->query())->links('pagination.default') }}
    </div>
  </div>
@endsection
