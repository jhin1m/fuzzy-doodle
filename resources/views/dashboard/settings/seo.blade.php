@section('title', __('Edit SEO Settings'))
@extends('dashboard.layout')
@section('content')

  <div class="flex flex-col gap-5">
    <div class="flex flex-col gap-1">
      <div class="flex justify-between">
        <h3 class="text-3xl font-bold tracking-tight">{{ __('Edit SEO Settings') }}</h3>
      </div>
    </div>
    <hr class="border-black/10 dark:border-white/10" />
    <x-error :errors="$errors" />

    <form action="{{ route('dashboard.settings.update_seo') }}" method="POST" class="flex flex-col gap-3">
      @csrf
      @method('PUT')

      <div class="rounded-md border-[1px] border-black/10 bg-transparent px-6 py-3 dark:border-white/10">
        <h2 class="font-semibold">{{ __('Single Manga SEO') }}</h2>
        <span
          class="text-sm text-black !text-opacity-60 dark:text-white">{{ __('Use :title as a placeholder for the real manga title') }}</span>
      </div>
      <x-input label="{{ __('Manga Title') }}" name="manga-title" :value="old('manga-title', settings()->get('seo.manga.title'))" />
      <x-input label="{{ __('Manga Description') }}" name="manga-description" :value="old('manga-description', settings()->get('seo.manga.description'))" />

      <div class="mt-2 rounded-md border-[1px] border-black/10 bg-transparent px-6 py-3 dark:border-white/10">
        <h2 class="font-semibold">{{ __('Single Chapter SEO') }}</h2>
        <span
          class="text-sm text-black !text-opacity-60 dark:text-white">{{ __('Use :manga as a placeholder for the real manga title and :chapter for chapter number') }}</span>
      </div>
      <x-input label="{{ __('Chapter Title') }}" name="chapter-title" :value="old('chapter-title', settings()->get('seo.chapter.title'))" />
      <x-input label="{{ __('Chapter Description') }}" name="chapter-description" :value="old('chapter-description', settings()->get('seo.chapter.description'))" />

      <div class="mt-2 rounded-md border-[1px] border-black/10 bg-transparent px-6 py-3 dark:border-white/10">
        <h2 class="font-semibold">{{ __('Manga List SEO') }}</h2>
      </div>
      <x-input label="{{ __('Manga List Title') }}" name="mangas-title" :value="old('mangas-title', settings()->get('seo.mangas.title'))" />
      <x-input label="{{ __('Manga List Description') }}" name="mangas-description" :value="old('mangas-description', settings()->get('seo.mangas.description'))" />

      <x-primary-button>{{ __('Update') }}</x-primary-button>
    </form>
  </div>
@endsection
