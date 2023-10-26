@section('title', __('Plugins List'))
@extends('dashboard.layout')
@section('content')

  <div class="flex flex-col gap-5">
    <div class="flex flex-col gap-1">
      <h3 class="text-3xl font-bold tracking-tight">{{ __('Plugins List') }}</h3>
      <p class="text-gray-500 dark:text-white dark:text-opacity-50">
        {{ __('Take control of your plugins from this page.') }}</p>
    </div>
    <hr class="border-black/10 dark:border-white/10" />
    <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
      @foreach ($plugins as $plugin)
        <div class="flex flex-col gap-3">
          <div class="flex flex-col gap-5 rounded-md border-[1px] border-black/10 p-5 dark:border-white/10">
            <div class="flex flex-col gap-2">
              <h3 class="text-base font-semibold">{{ $plugin['name'] }}</h3>
              <p>{{ $plugin['description'] }}</p>
            </div>
          </div>
          @php
            $isActive = \App\Models\Plugin::where('name', $plugin['folder'])
                ->where('active', true)
                ->first();
          @endphp
          @if (!$isActive)
            <a href="{{ route('dashboard.plugins.activate', $plugin['folder']) }}">
              <x-primary-button class="w-full">{{ __('Activate') }}</x-primary-button>
            </a>
          @else
            <a href="{{ route('dashboard.plugins.deactivate', $plugin['folder']) }}">
              <x-primary-button class="w-full">{{ __('Deactivate') }}</x-primary-button>
            </a>
          @endif
        </div>
      @endforeach
    </div>
  </div>
@endsection
