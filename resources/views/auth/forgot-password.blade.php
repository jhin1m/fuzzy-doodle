@section('title', __('Reset Password'))
@extends('auth.layout')
@section('content')
  @include('auth.heading', ['text' => __('Go Back'), 'title' => __('Reset Password')])
  <div class="flex flex-col gap-3">

    <x-success :status="session('status')" />
    <x-error :errors="$errors" />

    <form action="{{ route('password.email') }}" method="POST" class="flex flex-col gap-3">
      @csrf
      <x-input type="email" name="email" label="{{ __('Email Address') }}" placeholder="{{ __('email@example.com') }}" :value="old('email')"
        :required="true" />
      <x-primary-button>{{ __('Send Password Reset Link') }}</x-primary-button>
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
