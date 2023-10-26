@section('title', __('Add New Chapter'))
@extends('dashboard.layout')
@section('content')

  <div class="flex flex-col gap-5">
    <div class="flex flex-col gap-1">
      <div class="flex justify-between">
        <h3 class="text-3xl font-bold tracking-tight">{{ __('Add New Chapter') }}</h3>
        <x-table-button href="{{ route('dashboard.chapters.index') }}">
          <x-icons.back />
          <span>{{ __('Back') }}</span>
        </x-table-button>
      </div>
    </div>
    <hr class="border-black/10 dark:border-white/10" />
    <x-error :errors="$errors" />

    @if (count($mangas) === 0)
      <x-info>
        {{ __('There is no mangas yet, add some and try again.') }}
        </x-alert.info>
      @else
        <form action="{{ route('dashboard.chapters.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4"
          id="chapter-form">
          @csrf

          <x-input name="title" :value="old('title')" label="{{ __('Title') }}" placeholder="{{ __('Chapter Title (can be empty)') }}" />
          <div class="flex flex-col gap-3 sm:flex-row">
            <x-select class="hidden !border-none !p-0" label="{{ __('Manga') }}" id="tom-select" name="manga_id"
              selected="{{ old('manga_id', request()->get('manga')) }}" :options="$mangas">
            </x-select>
            <x-input name="chapter_number" :value="old('chapter_number')" label="{{ __('Chapter Number') }}" placeholder="{{ __('Chapter Number') }}"
              required />
          </div>

          <div class="relative flex flex-col gap-3" id="images-upload">
            <x-label title="{{ __('Files') }}" />
            <div id="dropzone" class="input dropzone !border-[1px] !border-white/10"></div>
          </div>

          <x-primary-button id="submit-chapter" disabled>{{ __('Submit') }}</x-primary-button>
        </form>
    @endif
  </div>
  <script>
    const uploadUrl = "{{ route('dashboard.chapters.upload') }}";
    const postUrl = "{{ route('dashboard.chapters.store') }}";
    const urlRedirect = "{{ route('dashboard.chapters.create') }}";
    const csrfToken = "{{ csrf_token() }}";
  </script>
  @vite(['resources/js/dashboard/chapterUpload.js', 'resources/css/dropzone.css', 'resources/css/tom-select.css'])
@endsection
