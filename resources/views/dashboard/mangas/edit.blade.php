@section('title', __('Edit Manga (:title)', ['title' => $manga->title]))
@extends('dashboard.layout')
@section('content')
  <script src="{!! url('js/tinymce/tinymce.min.js') !!}"></script>

  <div class="flex flex-col gap-5">
    <div class="flex flex-col gap-1">
      <div class="flex justify-between">
        <h3 class="text-3xl font-bold tracking-tight">{{ __('Edit Manga (:title)', ['title' => $manga->title]) }}</h3>
        <x-table-button href="{{ route('dashboard.mangas.index') }}">
          <x-icons.back />
          <span>{{ __('Back') }}</span>
        </x-table-button>
      </div>
    </div>
    <hr class="border-black/10 dark:border-white/10" />
    <x-error :errors="$errors" />

    <form action="{{ route('dashboard.mangas.update', $manga->id) }}" method="POST" id="form-editor" enctype="multipart/form-data"
      class="flex flex-col gap-4">
      @csrf
      @method('PUT')

      <div class="flex flex-col gap-3 sm:flex-row">
        <x-input label="{{ __('Title') }}*" id="title" name="title" value="{{ old('title', $manga->title) }}" required />
        <x-input label="{{ __('Slug') }}*" id="slug" name="slug" value="{{ old('slug', $manga->slug) }}" required />
      </div>

      <div class="flex flex-col gap-3">
        <x-label for="input-tags">{{ __('Genres') }}</x-label>
        <select id="input-tags" name="genres[]" multiple placeholder="{{ __('Genres') }}" autocomplete="off" class="hidden">
          @foreach (\App\Models\Taxonomy::where('type', 'genre')->get() as $genre)
            <option value="{{ $genre->title }}"
              {{ collect(old('genres'))->contains($genre->title) || $manga->genres->contains('title', $genre->title) ? 'selected' : '' }}>
              {{ $genre->title }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="flex flex-col gap-3 md:flex-row">
        <div class="flex flex-1 flex-col gap-3">
          <x-label title="{{ __('Description') }}" />
          <textarea id="editor" name="description" class="h-[500px]">{{ old('description', $manga->description) }}</textarea>
        </div>
        <div class="relative flex h-[500px] w-full flex-col self-start md:mt-8 md:w-1/4">
          <img id="cover-preview" class="h-full rounded-md object-cover" src="/storage/covers/{{ $manga->cover }}"
            alt="{{ __('Cover') }}" />
          <x-input type="file" id="cover" name="cover" class="absolute left-0 top-0 h-full w-full cursor-pointer opacity-0"
            accept="image/*" />
        </div>
      </div>

      <div class="flex flex-col gap-3 sm:flex-row">
        <x-input label="{{ __('Author') }}" name="author" value="{{ old('author', $manga->author) }}" />
        <x-input label="{{ __('Artist') }}" name="artist" value="{{ old('artist', $manga->artist) }}" />
      </div>

      <div class="flex flex-col gap-3 sm:flex-row">
        <x-input label="{{ __('Alternative Titles') }}" name="alternative_titles"
          value="{{ old('alternative_titles', $manga->alternative_titles) }}" />
        <x-input label="{{ __('Released Year') }}" name="releaseDate" value="{{ old('releaseDate', $manga->releaseDate) }}" />
      </div>

      <x-input label="{{ __('Rate') }}" type="number" step="0.1" name="rate" value="{{ old('rate', $manga->rate) }}" />

      <div class="flex flex-col gap-3 sm:flex-row">
        @php
          $types = \App\Models\Taxonomy::where('type', 'type')
              ->pluck('title', 'id')
              ->toArray();
          $status = \App\Models\Taxonomy::where('type', 'status')
              ->pluck('title', 'id')
              ->toArray();
        @endphp
        <x-select label="{{ __('Type') }}" name="type" selected="{{ old('status', $manga->types()->first()->id ?? '') }}"
          :options="['' => '-'] + $types"></x-select>
        <x-select label="{{ __('Status') }}" name="status" selected="{{ old('status', $manga->statuses()->first()->id ?? '') }}"
          :options="['' => '-'] + $status">
        </x-select>
      </div>

      <x-select label="{{ __('Post Status') }}" name="post_status" selected="{{ old('post_status', $manga->status) }}"
        :options="['publish' => __('Published'), 'private' => __('Private')]"></x-select>

      @php
        $slider = \App\Models\Slider::where([['slidable_type', \App\Models\Manga::class], ['slidable_id', $manga->id]])->first();
        $isSlider = $slider ? $slider->is_active : 0;
      @endphp

      <x-select label="{{ __('Add to slider') }}" name="slider_option" selected="{{ old('slider_option', $isSlider) }}"
        :options="[0 => __('No'), 1 => __('Yes')]"></x-select>
      <x-input label="{{ __('Slider Cover') }}" type="file" name="slider_cover" />

      @if ($slider && $slider?->is_active)
        <div class="bg-input mt-2 w-fit rounded-md p-3" id="slider-wrapper">
          <img class="max-w-1/3 h-full object-contain" src="/storage/slider/{{ $slider->image }}" alt="slider" />
        </div>
      @endif

      <x-primary-button>{{ __('Update') }}</x-primary-button>

    </form>
  </div>
  @vite(['resources/js/dashboard/manga.js', 'resources/css/tom-select.css', 'resources/css/editor.css'])
@endsection
