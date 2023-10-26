@section('title', __('Add New Type'))
@extends('dashboard.layout')
@section('content')

  <div class="flex flex-col gap-5">
    <div class="flex flex-col gap-1">
      <div class="flex justify-between">
        <h3 class="text-3xl font-bold tracking-tight">{{ __('Add New Type') }}</h3>
        <x-table-button href="{{ route('dashboard.mangas_types.index') }}">
          <x-icons.back />
          <span>{{ __('Back') }}</span>
        </x-table-button>
      </div>
    </div>
    <hr class="border-black/10 dark:border-white/10" />
    <x-error :errors="$errors" />

    <form action="{{ route('dashboard.mangas_types.store') }}" method="POST" class="flex flex-col gap-4">
      @csrf
      <x-input id="title" name="title" :value="old('title')" label="{{ __('Name') }}" placeholder="{{ __('Type Name ex. Manga') }}" />
      <x-primary-button>{{ __('Submit') }}</x-primary-button>
    </form>
  </div>
@endsection
