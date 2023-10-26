@section('title', __('Users List'))
@extends('dashboard.layout')
@section('content')

  <div class="flex flex-col gap-5">
    <div class="flex flex-col gap-1">
      <h3 class="text-3xl font-bold tracking-tight">{{ __('Deleted Users') }}</h3>
      <p class="text-gray-500 dark:text-white dark:text-opacity-50">
        {{ __('List of deleted users, you can either restore or permanently delete.') }}</p>
    </div>

    <div class="flex flex-col items-end justify-between gap-3 sm:flex-row sm:items-center">
      <x-input placeholder="{{ __('Filter...') }}" id="filter-table" />
      <x-table-button href="{{ route('dashboard.users.index') }}">
        <x-icons.back />
        <span>{{ __('Back') }}</span>
      </x-table-button>
    </div>
    <x-table :headings="['#', __('Username'), __('Email'), __('Roles'), __('Registered')]" :contents="$users
        ->map(function ($user) {
            return [
                'id' => $user->id,
                $user->username,
                $user->email,
                implode(', ', $user->getRoleNames()->toArray()),
                $user->created_at,
                'actions' => [
                    __('Restore') => route('dashboard.users.restore', $user->id),
                    __('Delete') => route('dashboard.users.hard_delete', $user->id),
                ],
            ];
        })
        ->toArray()" />
    <div class="flex justify-end">
      {{ $users->appends(request()->query())->links('pagination.default') }}
    </div>
  </div>
@endsection
