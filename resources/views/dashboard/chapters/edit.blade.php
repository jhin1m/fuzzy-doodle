@section('title',
  __('Edit Manga :manga - Chapter :chapter ', [
  'manga' => $chapter->manga->title,
  'chapter' => $chapter->chapter_number,
  ]))
  @extends('dashboard.layout')
@section('content')

  <div class="flex flex-col gap-5">
    <div class="flex flex-col gap-1">
      <div class="flex justify-between">
        <h3 class="text-3xl font-bold tracking-tight">
          {{ __('Edit Manga :manga - Chapter :chapter', [
              'manga' => $chapter->manga->title,
              'chapter' => $chapter->chapter_number,
          ]) }}
        </h3>
        <x-table-button href="{{ route('dashboard.chapters.index') }}">
          <x-icons.back />
          <span>{{ __('Back') }}</span>
        </x-table-button>
      </div>
    </div>
    <hr class="border-black/10 dark:border-white/10" />

    <div class="flex flex-wrap gap-3">
      <x-primary-button id="update-info-button">{{ __('Update Manga, Title or Number') }}</x-primary-button>
      <x-primary-button id="update-images-button">{{ __('Update Images') }}</x-primary-button>
    </div>

    <x-error :errors="$errors" />

    <form action="{{ route('dashboard.chapters.update', $chapter->id) }}" method="POST" enctype="multipart/form-data"
      class="flex hidden flex-col gap-4" id="update-info">
      @csrf
      @method('PUT')
      <x-input name="title" :value="old('title', $chapter->title)" label="{{ __('Title') }}" placeholder="{{ __('Chapter Title (can be empty)') }}" />
      <div class="flex flex-col gap-3 sm:flex-row">
        <x-select label="{{ __('Manga') }}" name="manga_id" selected="{{ old('manga_id', $chapter->manga->id) }}"
          :options="$mangas"></x-select>
        <x-input name="chapter_number" label="{{ __('Chapter Number') }}" :value="old('chapter_number', $chapter->chapter_number)" placeholder="{{ __('Chapter Number') }}" />
      </div>

      <x-primary-button>{{ __('Update') }}</x-primary-button>
    </form>
    <form action="{{ route('dashboard.chapters.update-content', $chapter->id) }}" method="POST" enctype="multipart/form-data"
      class="flex hidden flex-col gap-4" id="update-images">
      @csrf
      <div class="relative flex flex-col gap-3" id="images-upload">
        <x-label title="{{ __('Images') }}" />
        <div id="dropzone" class="input dropzone !border-[1px] !border-white/10"></div>
      </div>
      <x-primary-button id="submit-chapter" disabled>{{ __('Update') }}</x-primary-button>
    </form>

  </div>

  <script>
    const uploadUrl = "{{ route('dashboard.chapters.upload') }}";
    const postUrl = "{{ route('dashboard.chapters.update-content', $chapter->id) }}";
    const urlRedirect = "{{ route('dashboard.chapters.edit', $chapter->id) }}";
    const csrfToken = "{{ csrf_token() }}";

    const infoForm = document.querySelector("#update-info");
    const imagesForm = document.querySelector("#update-images");
    const infoBtn = document.querySelector("#update-info-button");
    const imgsBtn = document.querySelector("#update-images-button");

    infoBtn.addEventListener("click", (e) => {
      e.preventDefault();
      infoForm.classList.toggle("hidden");
      imagesForm.classList.add("hidden");
    });

    imgsBtn.addEventListener("click", (e) => {
      e.preventDefault();
      imagesForm.classList.toggle("hidden");
      infoForm.classList.add("hidden");
    });
  </script>
  @vite(['resources/js/dashboard/chapterUpload.js', 'resources/css/dropzone.css', 'resources/css/tom-select.css'])
@endsection
