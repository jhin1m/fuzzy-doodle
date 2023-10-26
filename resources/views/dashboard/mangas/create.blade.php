@section('title', __('Add New Manga'))
@extends('dashboard.layout')
@section('content')
  <script src="{!! url('js/tinymce/tinymce.min.js') !!}"></script>

  <div class="flex flex-col gap-5">
    <div class="flex flex-col gap-1">
      <div class="flex justify-between">
        <h3 class="text-3xl font-bold tracking-tight">{{ __('Add New Manga') }}</h3>
        <x-table-button href="{{ route('dashboard.mangas.index') }}">
          <x-icons.back />
          <span>{{ __('Back') }}</span>
        </x-table-button>
      </div>
    </div>
    <hr class="border-black/10 dark:border-white/10" />

    <x-error :errors="$errors" />

    <form action="{{ route('dashboard.mangas.store') }}" method="POST" id="form-editor" enctype="multipart/form-data"
      class="flex flex-col gap-4">
      @csrf

      <div class="flex flex-col gap-3 sm:flex-row">
        <x-input id="title" name="title" value="{{ old('title') }}" placeholder="{{ __('Title') }}" label="{{ __('Title') }}"
          required />
        <x-input id="slug" name="slug" value="{{ old('slug') }}" placeholder="{{ __('Slug') }}" label="{{ __('Slug') }}"
          required />
      </div>

      <div class="flex flex-col gap-3">
        <x-label for="input-tags">{{ __('Genres') }}</x-label>
        <select id="input-tags" name="genres[]" multiple placeholder="{{ __('Genres') }}" autocomplete="off">
          @foreach (\App\Models\Taxonomy::where('type', 'genre')->get() as $genre)
            <option value="{{ $genre->title }}" {{ collect(old('genres'))->contains($genre->title) ? 'selected' : '' }}>
              {{ $genre->title }}
            </option>
          @endforeach
        </select>
      </div>

      <x-label for="editor">{{ __('Description') }}</x-label>
      <textarea id="editor" name="description" class="hidden">{{ nl2br(old('description')) }}</textarea>

      <div class="flex flex-col gap-3 sm:flex-row">
        <x-input name="author" value="{{ old('author') }}" label="{{ __('Author') }}" placeholder="{{ __('Author') }}" />
        <x-input name="artist" value="{{ old('artist') }}" label="{{ __('Artist') }}" placeholder="{{ __('Artist') }}" />
      </div>

      <x-input label="{{ __('Rate') }}" type="number" step="0.1" name="rate" value="{{ old('rate', 0) }}" />

      <div class="flex flex-col gap-3 sm:flex-row">
        <x-input name="alternative_titles" value="{{ old('alternative_titles') }}" label="{{ __('Alternative Titles') }}"
          placeholder="{{ __('Alternative Titles') }}" />
        <x-input name="releaseDate" value="{{ old('releaseDate') }}" label="{{ __('Released Year') }}"
          placeholder="{{ __('Released Year') }}" />
      </div>

      <x-input label="{{ __('Cover') }}" type="file" id="cover" name="cover" />

      <div class="flex flex-col gap-3 sm:flex-row">
        <x-select label="{{ __('Type') }}" name="type" selected="{{ old('type') }}" :options="\App\Models\Taxonomy::where('type', 'type')
            ->pluck('title', 'id')
            ->toArray()"></x-select>
        <x-select label="{{ __('Status') }}" name="status" selected="{{ old('status') }}" :options="\App\Models\Taxonomy::where('type', 'status')
            ->pluck('title', 'id')
            ->toArray()"></x-select>
      </div>

      <x-select label="{{ __('Post Status') }}" name="post_status" selected="{{ old('post_status') }}" :options="['publish' => __('Published'), 'private' => __('Private')]"></x-select>

      <x-select label="{{ __('Add to slider') }}" name="slider_option" selected="{{ old('slider_option') }}" :options="[0 => __('No'), 1 => __('Yes')]"></x-select>
      <x-input label="{{ __('Slider Cover') }}" type="file" name="slider_cover" />
      <x-primary-button>{{ __('Submit') }}</x-primary-button>
      <div class="self-end">
      </div>
    </form>
  </div>

  @vite(['resources/js/dashboard/manga.js', 'resources/css/tom-select.css', 'resources/css/editor.css'])

@endsection
