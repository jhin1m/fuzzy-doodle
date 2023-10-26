@section('title', __('Edit Site Settings'))
@extends('dashboard.layout')
@section('content')

  <div class="flex flex-col gap-5">
    <div class="flex flex-col gap-1">
      <div class="flex justify-between">
        <h3 class="text-3xl font-bold tracking-tight">{{ __('Edit Site Settings') }}</h3>
      </div>
    </div>
    <hr class="border-black/10 dark:border-white/10" />
    <x-error :errors="$errors" />

    <form action="{{ route('dashboard.settings.update_site') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
      @csrf
      @method('PUT')
      <x-input label="{{ __('Site Title') }}" name="name" :value="old('name', settings()->get('name'))" />
      <x-input label="{{ __('Site URL') }}" name="url" :value="old('url', settings()->get('url'))" />

      <x-select label="{{ __('Force Https (Enable if you are using cloudflare ssl without server side ssl)') }}" name="https-force"
        selected="{{ old('https-force', settings()->get('https-force')) }}" :options="[
            '0' => __('Disabled'),
            '1' => __('Enabled'),
        ]"></x-select>

      <div class="flex flex-col gap-3 sm:flex-row">
        <x-input label="{{ __('Site Description') }}" name="description" :value="old('description', settings()->get('description'))" />
        <x-input label="{{ __('Site Keywords') }}" name="keywords" :value="old('keywords', settings()->get('keywords'))" />
      </div>

      <div class="flex flex-col gap-3 sm:flex-row">
        <div class="flex w-full flex-col gap-3">
          <x-input label="{{ __('Site Logo') }}" type="file" name="logo" />
          @if (settings()->get('logo'))
            <x-image-prev src="{{ asset('storage/site/' . basename(settings()->get('logo'))) }}" />
          @endif
        </div>
        <div class="flex w-full flex-col gap-3">
          <x-input label="{{ __('Site Favicon') }}" type="file" name="favicon" />
          @if (settings()->get('favicon'))
            <x-image-prev src="{{ asset('storage/site/' . basename(settings()->get('favicon'))) }}" />
          @endif
        </div>
      </div>

      <div class="flex w-full flex-col gap-3">
        <x-input label="{{ __('Auth Cover') }}" type="file" name="auth-cover" />
        @if (settings()->get('auth-cover'))
          <x-image-prev src="{{ asset('storage/site/' . basename(settings()->get('auth-cover'))) }}" />
        @endif
      </div>

      @php
        $appLocales = config('app.locales');
        $localeOptions = [];
        foreach ($appLocales as $locale) {
            $localeOptions[$locale] = __($locale);
        }
      @endphp
      <x-select label="{{ __('Website Main Language') }}" name="locale" selected="{{ old('locale', settings()->get('locale')) }}"
        :options="$localeOptions">
      </x-select>

      <div class="flex flex-col gap-3">
        <x-label for="custom_html">{{ __('Additional HTML') }}</x-label>
        <textarea id="custom_html" class="input min-h-[100px]" name="custom_html">{{ old('custom_html', settings()->get('custom_html')) }}</textarea>
      </div>

      <x-primary-button>{{ __('Update') }}</x-primary-button>
    </form>
  </div>
  <script>
    const checkBoxs = document.querySelectorAll("input[type=checkbox]");

    checkBoxs.forEach(checkbox => {
      checkbox.addEventListener("change", function(e) {
        e.preventDefault();
        this.value = this.checked ? 1 : 0;
      });
    });
  </script>
@endsection
