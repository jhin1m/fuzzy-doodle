@section('title', __('Bulk Add Chapters'))
@extends('dashboard.layout')
@section('content')

  <div class="flex flex-col gap-5">
    <div class="flex flex-col gap-1">
      <div class="flex justify-between">
        <h3 class="text-3xl font-bold tracking-tight">{{ __('Bulk Add Chapters') }}</h3>
        <x-table-button href="{{ route('dashboard.chapters.index') }}">
          <x-icons.back />
          <span>{{ __('Back') }}</span>
        </x-table-button>
      </div>
    </div>
    <hr class="border-black/10 dark:border-white/10" />
    <x-error :errors="$errors" />

    <form action="{{ route('dashboard.chapters.bulk.store') }}" id="bulk-upload" method="POST" enctype="multipart/form-data"
      class="flex flex-col gap-4">

      @csrf

      <x-select class="hidden !border-none !p-0" label="{{ __('Manga') }}" id="tom-select" name="content_id"
        selected="{{ old('content_id', request()->get('manga')) }}" :options="$mangas">
      </x-select>

      <div class="relative flex flex-col gap-3">
        <x-label title="{{ __('Zip file - Containing FOLDERS with chapter number as folder name') }}" />
        <div id="dropzone" class="input dropzone !border-[1px] !border-white/10"></div>
      </div>

      <x-primary-button id="submit-chapter" disabled>{{ __('Submit') }}</x-primary-button>

    </form>
  </div>
  <script>
    const uploadUrl = "{{ route('dashboard.chapters.bulk.upload') }}";
    const postUrl = "{{ route('dashboard.chapters.bulk.store') }}";
    const urlRedirect = "{{ route('dashboard.chapters.bulk.create') }}";
    const csrfToken = "{{ csrf_token() }}";
  </script>

  @vite(['resources/js/dashboard/bulkUpload.js', 'resources/css/dropzone.css', 'resources/css/tom-select.css'])

@endsection
