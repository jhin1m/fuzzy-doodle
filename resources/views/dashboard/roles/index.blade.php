@section('title', __('Roles List'))
@extends('dashboard.layout')
@section('content')

  <div class="flex flex-col gap-5">
    <div class="flex flex-col gap-1">
      <h3 class="text-3xl font-bold tracking-tight">{{ __('Roles List') }}</h3>
      <p class="text-gray-500 dark:text-white dark:text-opacity-50">
        {{ __('Take control of your roles from this page.') }}</p>
    </div>

    <div class="flex flex-col items-end justify-between gap-3 sm:flex-row sm:items-center">
      <x-input placeholder="{{ __('Filter...') }}" id="filter-table" />
      <x-table-button href="{{ route('dashboard.roles.create') }}">
        <x-icons.add />
        <span>{{ __('Add new') }}</span>
      </x-table-button>
    </div>

    <x-table :headings="['#', __('Role Name'), __('Created At'), __('Updated At')]" :contents="$roles
        ->map(function ($role) {
            return [
                'id' => $role->id,
                $role->name,
                $role->created_at,
                $role->updated_at,
                'actions' => [
                    __('Edit') => route('dashboard.roles.edit', $role->id),
                    __('Delete') => route('dashboard.roles.delete', $role->id),
                ],
            ];
        })
        ->toArray()" />
    <div class="flex justify-end">
      {{ $roles->appends(request()->query())->links('pagination.default') }}
    </div>
  </div>
@endsection
