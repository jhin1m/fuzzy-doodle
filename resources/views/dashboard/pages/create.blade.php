@section('title', __('Add New Page'))
@extends('dashboard.layout')
@section('content')
  <script src="{!! url('js/tinymce/tinymce.min.js') !!}"></script>
  <div class="flex flex-col gap-5">
    <div class="flex flex-col gap-1">
      <div class="flex justify-between">
        <h3 class="text-3xl font-bold tracking-tight">{{ __('Add New Page') }}</h3>
        <x-table-button href="{{ route('dashboard.pages.index') }}">
          <x-icons.back />
          <span>{{ __('Back') }}</span>
        </x-table-button>
      </div>
    </div>
    <hr class="border-black/10 dark:border-white/10" />
    <x-error :errors="$errors" />

    <form action="{{ route('dashboard.pages.store') }}" method="POST" id="form-editor" enctype="multipart/form-data" class="flex flex-col gap-4">
      @csrf

      <div class="flex flex-col gap-3 sm:flex-row">
        <x-input id="title" name="title" :value="old('title')" label="{{ __('Title') }}" placeholder="{{ __('Page Title') }}" />
        <x-input id="slug" name="slug" :value="old('slug')" label="{{ __('Slug') }}" placeholder="{{ __('Page Slug') }}" />
      </div>

      <div class="flex flex-col gap-3">
        <x-label title="{{ __('Page Content') }}" />
        <textarea id="editor" name="content" class="hidden">{{ old('content') }}</textarea>
      </div>
      <x-primary-button>{{ __('Submit') }}</x-primary-button>
    </form>
  </div>
  @vite(['resources/css/editor.css'])
@endsection
