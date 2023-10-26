@section('title', __('Reset Password'))
@extends('auth.layout')
@section('content')
  @include('auth.heading', ['text' => __('Go Back'), 'title' => __('Reset Password')])
  <div class="flex flex-col gap-3">
    <x-success :status="session('status')" />
    <x-error :errors="$errors" />

    <form action="{{ route('password.update') }}" method="POST" class="flex flex-col gap-3">
      @csrf
      <input type="hidden" name="token" value="{{ $request->token }}">
      <x-input type="email" name="email" label="{{ __('Email Address') }}" placeholder="{{ __('email@example.com') }}"
        :value="old('email', $request->email)" :required="true" />
      <x-input type="password" name="password" label="{{ __('Password') }}" :required="true" />
      <x-input type="password" name="password_confirmation" label="{{ __('Password Confirmation') }}" :required="true" />
      <x-primary-button>{{ __('Reset Password') }}</x-primary-button>
    </form>
  </div>
@endsection
