@section('title', __('Dashboard'))
@extends('dashboard.layout')
@section('content')
  <section class="flex flex-col gap-5">
    <h3 class="text-3xl font-bold tracking-tight">{{ __('Dashboard') }}</h3>
    @can('see_stats')
      <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <x-dashboard-card heading="{{ __('Total Mangas') }}" value="{{ $mangas }}" percentage="{{ $mangasPercentage }}">
          <x-icons.list class="h-5 w-5 text-gray-500" />
        </x-dashboard-card>

        <x-dashboard-card heading="{{ __('Manga Chapters') }}" value="{{ $chapters }}" percentage="{{ $chaptersPercentage }}">
          <x-icons.piechart class="h-5 w-5 text-gray-500" />
        </x-dashboard-card>

        <x-dashboard-card heading="{{ __('Total Views') }}" value="{{ $mangasViews + $chaptersViews }}" percentage="{{ $viewsPercentage }}">
          <x-icons.increase class="h-5 w-5 text-gray-500" />
        </x-dashboard-card>

        <x-dashboard-card heading="{{ __('Total Members') }}" value="{{ $users }}" percentage="{{ $membersPercentage }}">
          <x-icons.members class="h-5 w-5 text-gray-500" />
        </x-dashboard-card>
      </div>
    @endcan
  </section>
@endsection
