@section('title', __('Register'))
@extends('auth.layout')
@section('content')
  @include('auth.heading', ['text' => __('Go Back'), 'title' => __('Register')])
  <div class="flex flex-col gap-3">
    <x-error :errors="$errors" />
    <form action="{{ route('register') }}" method="POST" class="flex flex-col gap-3">
      @csrf
      <x-input type="text" name="username" label="{{ __('Username') }}" placeholder="{{ __('ex. mangalover') }}"
        :value="old('username')" required />
      <x-input type="email" name="email" label="{{ __('Email Address') }}" placeholder="{{ __('email@example.com') }}"
        :value="old('email')" required />
      <x-input type="password" name="password" label="{{ __('Password') }}" required />
      <x-input type="password" name="password_confirmation" label="{{ __('Password Confirmation') }}" required />
      <x-primary-button>{{ __('Register') }}</x-primary-button>
    </form>
  </div>

  <div class="flex flex-col gap-1">
    <span class="text-sm">
      {{ __('Already have an account?') }}
      <x-auth-link link="{{ url('/login') }}">{{ __('Login') }}</x-auth-link>
    </span>
    <x-auth-link link="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</x-auth-link>
  </div>
@endsection
