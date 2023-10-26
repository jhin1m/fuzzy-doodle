@section('title', __('Edit Ad - :name', ['name' => $ad->name]))
@extends('dashboard.layout')
@section('content')

  <div class="flex flex-col gap-5">
    <div class="flex flex-col gap-1">
      <div class="flex justify-between">
        <h3 class="text-3xl font-bold tracking-tight">{{ __('Edit Ad - :name', ['name' => $ad->name]) }}</h3>
        <x-table-button href="{{ route('dashboard.ads.index') }}">
          <x-icons.back />
          <span>{{ __('Back') }}</span>
        </x-table-button>
      </div>
    </div>
    <hr class="border-black/10 dark:border-white/10" />
    <x-error :errors="$errors" />

    <form action="{{ route('dashboard.ads.update', $ad->id) }}" method="POST" class="flex flex-col gap-4" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="flex flex-col gap-3 sm:flex-row">
        <x-input id="title" name="name" :value="old('name', $ad->name)" label="{{ __('Name') }}" placeholder="{{ __('Ad Name') }}" />
        <x-input id="slug" name="identifier" label="{{ __('Identifier') }}" :value="old('identifier', $ad->identifier)" placeholder="{{ __('Ad Identifier') }}" />
      </div>
      <x-select id="ad-type" label="{{ __('Type') }}" name="type" selected="{{ old('type', $ad->type) }}"
        :options="['banner' => __('Banner'), 'script' => __('Script')]"></x-select>

      <div id="ad-banner" class="flex flex-col gap-4">
        <x-input label="{{ __('Image') }}" type="file" name="image" />
        @if ($ad->image)
          <div class="bg-input w-fit rounded-md p-3">
            <img src="{{ asset('storage/' . $ad->image) }}" />
          </div>
        @endif
        <x-input name="link" :value="old('link', $ad->link)" label="{{ __('Link') }}" placeholder="{{ __('Ad Link') }}" />
      </div>

      <div id="ad-script" class="hidden">
        <div class="flex flex-col gap-3">
          <x-label for="script">{{ __('Code / Script') }}</x-label>
          <textarea id="script" class="input" name="script" label="{{ __('Ad Script') }}">{{ old('script', $ad->script) }}</textarea>
        </div>
      </div>

      <x-select label="{{ __('Status') }}" name="is_active" selected="{{ old('is_active', $ad->is_active) }}" :options="['1' => __('Active'), '0' => __('Disabled')]"></x-select>

      <x-primary-button>{{ __('Update') }}</x-primary-button>
    </form>
  </div>
@endsection
