@section('title', __('Ads List'))
@extends('dashboard.layout')
@section('content')

  <div class="flex flex-col gap-5">

    <div class="flex flex-col gap-1">
      <h3 class="text-3xl font-bold tracking-tight">{{ __('Ads List') }}</h3>
      <p class="text-gray-500 dark:text-white dark:text-opacity-50">
        {{ __('Take control of your ads from this page.') }}</p>
    </div>

    <div class="flex flex-col items-end justify-between gap-3 sm:flex-row sm:items-center">
      <x-input placeholder="{{ __('Filter...') }}" id="filter-table" />
      <x-table-button href="{{ route('dashboard.ads.create') }}">
        <x-icons.add />
        <span>{{ __('Add new') }}</span>
      </x-table-button>
    </div>
    <x-table :headings="['#', __('Name'), __('Identifier'), __('Status'), __('Type'), __('Clicks')]" :contents="$ads
        ->map(function ($ad) {
            return [
                'id' => $ad->id,
                $ad->name,
                $ad->identifier,
                $ad->type,
                $ad->is_active ? __('Active') : __('Disabled'),
                $ad->views->count(),
                'actions' => [
                    __('Edit') => route('dashboard.ads.edit', $ad->id),
                    __('Delete') => route('dashboard.ads.delete', $ad->id),
                ],
            ];
        })
        ->toArray()" />

    <div class="flex justify-end">
      {{ $ads->appends(request()->query())->links('pagination.default') }}
    </div>
  </div>
@endsection
