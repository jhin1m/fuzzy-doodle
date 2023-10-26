@section('title', __('Login'))
@extends('auth.layout')
@section('content')
  @include('auth.heading', ['text' => __('Go Back'), 'title' => __('Login')])
  <div class="flex flex-col gap-3">
    <x-success :status="session('status')" />
    <x-error :errors="$errors" />

    <form action="{{ route('login') }}" method="POST" class="flex flex-col gap-3">
      @csrf
      <x-input type="email" name="email" label="{{ __('Email Address') }}" placeholder="{{ __('email@example.com') }}"
        :value="old('email')" required />
      <x-input type="password" name="password" label="{{ __('Password') }}" required />

      <div class="flex gap-2 items-center">
        <label for="remember" class="cursor-pointer">{{ __('Remember me?') }}</label>
        <input id="remember" type="checkbox" class="w-5 h-5 rounded-md bg-transparent -order-1 cursor-pointer"
          name="remember" />
      </div>
      <x-primary-button>{{ __('Login') }}</x-primary-button>
    </form>
  </div>

  <div class="flex flex-col gap-1">
    <span class="text-sm">
      {{ __('Don\'t have an account?') }}
      <x-auth-link link="{{ url('/register') }}">{{ __('Register here.') }}</x-auth-link>
    </span>
    <x-auth-link link="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</x-auth-link>
  </div>
@endsection
