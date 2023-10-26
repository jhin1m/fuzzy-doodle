@section('title', __('Add New Role'))
@extends('dashboard.layout')
@section('content')

  <div class="flex flex-col gap-5">
    <div class="flex flex-col gap-1">
      <div class="flex justify-between">
        <h3 class="text-3xl font-bold tracking-tight">{{ __('Add New Role') }}</h3>
        <x-table-button href="{{ route('dashboard.roles.index') }}">
          <x-icons.back />
          <span>{{ __('Back') }}</span>
        </x-table-button>
      </div>
    </div>
    <hr class="border-black/10 dark:border-white/10" />
    <x-error :errors="$errors" />

    <form action="{{ route('dashboard.roles.store') }}" method="POST" class="flex flex-col gap-4">
      @csrf

      <x-input name="name" :value="old('name')" label="{{ __('Name') }}" placeholder="{{ __('Role Name') }}" />
      <x-select class="min-h-[20rem]" label="{{ __('Permissions') }}" name="permissions[]" :selected="old('permissions', [])"
        size="{{ Spatie\Permission\Models\Permission::all()->count() }}" :options="Spatie\Permission\Models\Permission::all()->pluck('name', 'id')" multiple></x-select>

      <x-primary-button>{{ __('Submit') }}</x-primary-button>
    </form>
  </div>
@endsection
