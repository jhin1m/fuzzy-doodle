<div class="mb-2 flex sm:mb-4">
  <div class="mb-4 w-full md:mb-0 md:w-full">
    <x-input id="title" name="title" :value="request('title')" label="{{ __('Title') }}" placeholder="{{ __('Search for content...') }}" />
  </div>
</div>
<div class="flex flex-col gap-2 md:flex-row">
  <div class="flex w-full gap-3">
    <div class="mb-4 w-full md:mb-0">
      <div class="flex flex-col gap-3">
        <x-label for="type">{{ __('Type') }}</x-label>
        <select id="type" class="input" name="type">
          <option value="">{{ __('All Types') }}</option>
          @php
            $types = \App\Models\Taxonomy::where('type', 'type')->get();
          @endphp

          @foreach ($types as $type)
            <option value="{{ $type->slug }}" {{ request('type') === $type->slug ? 'selected' : '' }}>
              {{ $type->title }}
            </option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="mb-4 w-full md:mb-0">
      <div class="flex flex-col gap-3">
        <x-label for="status">{{ __('Status') }}</x-label>
        <select id="status" class="input" name="status">
          <option value="">{{ __('All Status') }}</option>
          @php
            $statuses = \App\Models\Taxonomy::where('type', 'status')->get();
          @endphp

          @foreach ($statuses as $status)
            <option value="{{ $status->slug }}" {{ request('status') === $status->slug ? 'selected' : '' }}>
              {{ $status->title }}
            </option>
          @endforeach
        </select>
      </div>
    </div>
  </div>
  <div class="mt-1 w-full md:w-1/2">

    <x-label class="mb-3 block">{{ __('Genres') }}</x-label>
    <div class="grid max-h-[200px] grid-cols-2 justify-between gap-2 overflow-x-auto px-2 py-0">
      @php
        $genres = \App\Models\Taxonomy::where('type', 'genre')
            ->orderBy('title')
            ->get();
      @endphp
      @if ($genres->count() > 0)
        @foreach ($genres as $genre)
          <div class="flex items-center gap-2">
            <label class="cursor-pointer" for="{{ $genre->title }}">{{ $genre->title }}</label>
            </label>
            <input id="{{ $genre->title }}" type="checkbox" name="genre[]" value="{{ $genre->title }}"
              {{ in_array($genre->title, (array) request('genre', [])) ? 'checked' : '' }} class="input">
          </div>
        @endforeach
      @else
        <span class="font-sm !text-opacity-60 dark:dark:text-white">{{ __('No data has been found') }}</span>
      @endif
    </div>
  </div>
</div>

<div class="mt-3 flex justify-end">
  <x-primary-button>{{ __('Search') }}</x-primary-button>
</div>
