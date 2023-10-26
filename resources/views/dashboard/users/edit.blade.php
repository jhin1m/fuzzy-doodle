@section('title', __('Edit User (:username)', ['username' => $user->username]))
@extends('dashboard.layout')
@section('content')

  <div class="flex flex-col gap-5">
    <div class="flex flex-col gap-1">
      <div class="flex justify-between">
        <h3 class="text-3xl font-bold tracking-tight">{{ __('Edit User (:username)', ['username' => $user->username]) }}
        </h3>
        <x-table-button href="{{ route('dashboard.users.index') }}">
          <x-icons.back />
          <span>{{ __('Back') }}</span>
        </x-table-button>
      </div>
    </div>
    <hr class="border-black/10 dark:border-white/10" />
    <x-error :errors="$errors" />

    <form action="{{ route('dashboard.users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
      @csrf
      @method('PUT')

      <div class="flex flex-col gap-3 sm:flex-row">
        <x-input label="{{ __('Username') }}" name="username" label="{{ __('Username') }}" :value="old('username', $user->username)" />
        <x-input label="{{ __('Email') }}" name="email" type="email" label="{{ __('Email address') }}" :value="old('email', $user->email)" />
      </div>

      <x-input label="{{ __('Description') }}" name="description" label="{{ __('Description') }}" :value="old('description', $user->description)" />

      <x-select label="{{ __('Roles') }}" name="roles[]" :selected="old('roles', $user->roles->pluck('name')->toArray())" size="{{ App\Models\Role::all()->count() }}" :options="App\Models\Role::all()->pluck('name', 'name')"
        multiple>
      </x-select>

      <div class="flex flex-col gap-3 sm:flex-row">
        <x-input label="{{ __('Password') }}" type="password" name="password" />
        <x-input label="{{ __('Password Confirmation') }}" type="password" name="password_confirmation" />
      </div>

      <x-primary-button>{{ __('Update') }}</x-primary-button>
    </form>
  </div>
@endsection
