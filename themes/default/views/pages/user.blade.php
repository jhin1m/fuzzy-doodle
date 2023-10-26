@section('title', __('User Setting'))
@extends('layout')
@section('content')
  <div id="update-user" class="flex flex-col items-center justify-center">
    <div class="flex flex-col md:w-2/3">
      <x-info>{{ __('We take privacy issues seriously. You can be sure that your personal data is securely protected.') }}</x-alert.info>
        <x-success :status="session('status')" />
        <x-error :errors="$errors->updateProfileInformation" />

        <div class="wrap mt-10 flex gap-10">
          <div class="hidden lg:block lg:w-2/5">
            <h2 class="my-3 text-lg font-bold">{{ __('Personal Information') }} - ({{ auth()->user()->username }})</h2>
            <p class="text-sm text-black !text-opacity-60 dark:text-white">
              {{ __('Update your username, email or your description. Remember if you changed the email you will need to reactivate the new email.') }}
            </p>
          </div>
          <div class="w-full lg:w-3/5">
            <form action="{{ route('user-profile-information.update') }}" method="POST" class="flex flex-col gap-3"
              enctype="multipart/form-data">
              @csrf
              @method('PUT')

              <x-input type="file" label="{{ __('Avatar') }}" name="avatar" />
              <div class="flex flex-col gap-3 sm:flex-row">
                <x-input label="{{ __('Username') }}" type="text" name="username" :value="auth()->user()->username" />
                <x-input label="{{ __('Email') }}" type="email" name="email" :value="auth()->user()->email" />
              </div>

              <x-input label="{{ __('Description') }}" type="text" name="description" :value="auth()->user()->description" />

              @if (!auth()->user()->hasVerifiedEmail())
                <span class="text-red-500">{{ __("This email isn't verified, if you didn't recieve the verification message,") }}
                  <a class="text-blue-500 transition hover:text-blue-700"
                    href="{{ route('verification.notice') }}">{{ __('click here') }}</a> {{ __('to resend it!') }}</span>
              @endif
              <x-primary-button>{{ __('Update') }}</x-primary-button>
            </form>
          </div>
        </div>
        <hr class="mb-10 mt-10 border-black/10 dark:border-white/10">

        <div class="wrap flex gap-10">
          <div class="hidden lg:block lg:w-2/5">
            <h2 class="my-3 text-lg font-bold">{{ __('Security') }}</h2>
            <p class="text-sm text-black !text-opacity-60 dark:text-white">
              {{ __('Update your security information from this section!') }}</p>
          </div>

          <div id="update-password" class="w-full lg:w-3/5">
            <x-error :errors="$errors->updatePassword" />
            <form action="{{ route('user-password.update') }}" method="POST" class="flex flex-col gap-3">
              @csrf
              @method('PUT')
              <x-input label="{{ __('Current Password') }}" type="password" name="current_password" />
              <x-input label="{{ __('Password') }}" type="password" name="password" />
              <x-input label="{{ __('Password Confirmation') }}" type="password" name="password_confirmation" />
              <x-primary-button>{{ __('Update') }}</x-primary-button>
            </form>
          </div>
        </div>
    </div>
  </div>
@endsection
