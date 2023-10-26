@section('title', __('Edit Mail Settings'))
@extends('dashboard.layout')
@section('content')

  <div class="flex flex-col gap-5">
    <div class="flex flex-col gap-1">
      <div class="flex justify-between">
        <h3 class="text-3xl font-bold tracking-tight">{{ __('Edit Mail Settings') }}</h3>
      </div>
    </div>
    <hr class="border-black/10 dark:border-white/10" />
    <x-error :errors="$errors" />

    <form action="{{ route('dashboard.settings.update_mail') }}" method="POST" class="flex flex-col gap-4">
      @csrf
      @method('PUT')

      <x-select label="{{ __('Mail Mailer') }}" name="driver" selected="{{ old('driver', settings()->get('mail.driver')) }}"
        :options="['sendmail' => __('Sendmail'), 'smtp' => __('SMTP')]"></x-select>
      <x-input label="{{ __('Mail Host') }}" name="host" :value="old('host', settings()->get('mail.host'))" />
      <x-input label="{{ __('Mail Port') }}" name="port" :value="old('port', settings()->get('mail.port'))" />
      <x-input label="{{ __('Mail Username') }}" name="username" :value="old('username', settings()->get('mail.username'))" />
      <x-input label="{{ __('Mail Password') }}" name="password" :value="old('password', settings()->get('mail.password'))" />
      <x-select label="{{ __('Mail Encryption') }}" name="encryption" selected="{{ old('encryption', settings()->get('mail.encryption')) }}"
        :options="['ssl' => __('ssl'), 'tls' => __('tls')]"></x-select>
      <x-input label="{{ __('Mail From') }}" name="address" :value="old('address', settings()->get('mail.address'))" />

      <x-primary-button>{{ __('Update') }}</x-primary-button>
    </form>
  </div>
@endsection
