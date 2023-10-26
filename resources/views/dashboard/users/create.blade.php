@section('title', __('Add New User'))
@extends('dashboard.layout')
@section('content')

  <div class="flex flex-col gap-5">
    <div class="flex flex-col gap-1">
      <div class="flex justify-between">
        <h3 class="text-3xl font-bold tracking-tight">{{ __('Add New User') }}</h3>
        <x-table-button href="{{ route('dashboard.users.index') }}">
          <x-icons.back />
          <span>{{ __('Back') }}</span>
        </x-table-button>
      </div>
    </div>
    <hr class="border-black/10 dark:border-white/10" />
    <x-error :errors="$errors" />

    <form action="{{ route('dashboard.users.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
      @csrf

      <div class="flex flex-col gap-3 sm:flex-row">
        <x-input name="username" :value="old('username')" label="{{ __('Username') }}" placeholder="{{ __('Username') }}" />
        <x-input name="email" type="email" :value="old('email')" label="{{ __('Email address') }}" placeholder=" {{ __('Email') }}" />
      </div>

      <div class="flex flex-col gap-3 sm:flex-row">
        <x-input type="password" name="password" :value="old('password')" label="{{ __('Password') }}" placeholder=" {{ __('Password') }}" />
        <x-input type="password" name="password_confirmation" label="{{ __('Password Confirmation') }}"
          placeholder=" {{ __('Password Confirmation') }}" />
      </div>

      <x-input name="description" :value="old('description')" label="{{ __('Description') }}" placeholder="{{ __('Description') }}" />

      <x-select label="{{ __('Roles') }}" name="roles[]" :selected="old('roles', [])" size="{{ App\Models\Role::all()->count() }}" :options="App\Models\Role::all()->pluck('name', 'name')"
        multiple>
      </x-select>

      <x-primary-button>{{ __('Submit') }}</x-primary-button>
    </form>
  </div>
@endsection
