@section('title', __('Users List'))
@extends('dashboard.layout')
@section('content')

  <div class="flex flex-col gap-5">
    <div class="flex flex-col gap-1">
      <h3 class="text-3xl font-bold tracking-tight">{{ __('Users List') }}</h3>
      <p class="text-gray-500 dark:text-white dark:text-opacity-50">
        {{ __('Take control of your users from this page, soft delete is active so when page is deleted you can still find it inside the trash.') }}
      </p>
    </div>
    <div class="flex flex-col items-end justify-between gap-3 sm:flex-row sm:items-center">
      <x-input placeholder="{{ __('Filter...') }}" id="filter-table" />
      <div class="flex gap-2">
        <x-table-button href="{{ route('dashboard.users.create') }}">
          <x-icons.add />
          <span>{{ __('Add new') }}</span>
        </x-table-button>
        <x-table-button href="{{ route('dashboard.users.deleted') }}">
          <x-icons.bin />
          <span>{{ __('Deleted Users') }}</span>
        </x-table-button>
      </div>
    </div>
    <x-table :headings="['#', __('Username'), __('Email'), __('Roles'), __('Registered')]" :contents="$users
        ->map(function ($user) {
            $roles = $user->getRoleNames()->toArray();
            return [
                'id' => $user->id,
                $user->username,
                $user->email,
                implode(', ', $roles),
                $user->created_at,
                'actions' => [
                    __('Edit') => route('dashboard.users.edit', $user->id),
                    __('Delete') => route('dashboard.users.delete', $user->id),
                ],
            ];
        })
        ->toArray()" />
    <div class="flex justify-end">
      {{ $users->appends(request()->query())->links('pagination.default') }}
    </div>
  </div>
@endsection
