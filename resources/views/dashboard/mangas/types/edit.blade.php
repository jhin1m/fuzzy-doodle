@section('title', __('Edit Type (:name)', ['name' => $type->title]))
@extends('dashboard.layout')
@section('content')

  <div class="flex flex-col gap-5">
    <div class="flex flex-col gap-1">
      <div class="flex justify-between">
        <h3 class="text-3xl font-bold tracking-tight">{{ __('Edit Type (:name)', ['name' => $type->title]) }}</h3>
        <x-table-button href="{{ route('dashboard.mangas_types.index') }}">
          <x-icons.back />
          <span>{{ __('Back') }}</span>
        </x-table-button>
      </div>
    </div>
    <hr class="border-black/10 dark:border-white/10" />
    <x-error :errors="$errors" />

    <form action="{{ route('dashboard.mangas_types.update', $type->id) }}" method="POST" class="flex flex-col gap-4">
      @csrf
      @method('PUT')
      <x-input id="title" name="title" :value="old('name', $type->title)" label="{{ __('Name') }}" placeholder="{{ __('Type Name') }}" />
      <x-input id="slug" name="slug" :value="old('slug', $type->slug)" label="{{ __('Slug') }}" placeholder="{{ __('Type Slug') }}" />
      <x-primary-button>{{ __('Update') }}</x-primary-button>
    </form>
  </div>
@endsection
