@section('title', __('Edit Role (:role)', ['role' => $role->name]))
@extends('dashboard.layout')
@section('content')

  <div class="flex flex-col gap-5">
    <div class="flex flex-col gap-1">
      <div class="flex justify-between">
        <h3 class="text-3xl font-bold tracking-tight">{{ __('Edit Role (:role)', ['role' => $role->name]) }}</h3>
        <x-table-button href="{{ route('dashboard.roles.index') }}">
          <x-icons.back />
          <span>{{ __('Back') }}</span>
        </x-table-button>
      </div>
    </div>
    <hr class="border-black/10 dark:border-white/10" />
    <x-error :errors="$errors" />

    <form action="{{ route('dashboard.roles.update', $role->id) }}" method="POST" class="flex flex-col gap-4">
      @csrf
      @method('PUT')

      <x-input label="{{ __('Role Name') }}" name="name" :value="old('name', $role->name)" />
      <x-select class="min-h-[20rem]" label="{{ __('Permissions') }}" name="permissions[]" :selected="old('permissions', $role->permissions->pluck('id')->toArray())"
        size="{{ Spatie\Permission\Models\Permission::all()->count() }}" :options="Spatie\Permission\Models\Permission::all()->pluck('name', 'id')" multiple></x-select>

      <x-primary-button>{{ __('Update') }}</x-primary-button>
    </form>
  </div>
@endsection
