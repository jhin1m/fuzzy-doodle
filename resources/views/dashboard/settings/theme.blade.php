@section('title', __('Edit Theme Settings'))
@extends('dashboard.layout')
@section('content')

  <div class="flex flex-col gap-5">
    <div class="flex flex-col gap-1">
      <div class="flex justify-between">
        <h3 class="text-3xl font-bold tracking-tight">{{ __('Edit Theme Settings') }}</h3>
      </div>
    </div>
    <hr class="border-black/10 dark:border-white/10" />
    <x-error :errors="$errors" />

    <form action="{{ route('dashboard.settings.update_theme') }}" method="POST" class="flex flex-col gap-4">
      @csrf
      @method('PUT')

      @php
        $themes = [];
        foreach (glob(base_path('themes') . '/*', GLOB_ONLYDIR) as $dir) {
            $themes[basename($dir)] = basename($dir);
        }
      @endphp

      <x-select label="{{ __('Default Theme') }}" name="theme_active" selected="{{ old('theme_active', settings()->get('theme.active')) }}"
        :options="$themes"></x-select>

      <x-select label="{{ __('Default Mode') }}" name="theme_mode" selected="{{ old('theme_mode', settings()->get('theme.mode')) }}"
        :options="[
            'dark' => __('Dark'),
            'light' => __('Light'),
        ]"></x-select>

      <x-select label="{{ __('Theme Slider') }}" name="theme_slider" selected="{{ old('theme_slider', settings()->get('theme.slider')) }}"
        :options="[
            1 => __('Enabled'),
            0 => __('Disabled'),
        ]"></x-select>

      <x-select label="{{ __('Chapter Images Lazyload') }}" name="chapter_lazyload"
        selected="{{ old('chapter_lazyload', settings()->get('chapter.lazyload')) }}" :options="[
            0 => __('Disabled'),
            1 => __('Enabled'),
        ]"></x-select>

      <x-input label="{{ __('Facebook link') }}" name="facebook" :value="old('facebook', settings()->get('theme.social.facebook'))" />
      <x-input label="{{ __('Instagram link') }}" name="instagram" :value="old('instagram', settings()->get('theme.social.instagram'))" />
      <x-input label="{{ __('Twitter link') }}" name="twitter" :value="old('facebook', settings()->get('theme.social.twitter'))" />
      <x-input label="{{ __('Discord link') }}" name="discord" :value="old('discord', settings()->get('theme.social.discord'))" />
      <x-primary-button>{{ __('Update') }}</x-primary-button>
    </form>
  </div>
@endsection
