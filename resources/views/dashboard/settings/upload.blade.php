@section('title', __('Edit Uploading Settings'))
@extends('dashboard.layout')
@section('content')

  <div class="flex flex-col gap-5">
    <div class="flex flex-col gap-1">
      <div class="flex justify-between">
        <h3 class="text-3xl font-bold tracking-tight">{{ __('Edit Uploading Settings') }}</h3>
      </div>
    </div>
    <hr class="border-black/10 dark:border-white/10" />
    <x-error :errors="$errors" />

    <form action="{{ route('dashboard.settings.update_upload') }}" method="POST" class="flex flex-col gap-4">
      @csrf
      @method('PUT')

      <x-select label="{{ __('Image Encoding') }}" name="image-encoding"
        selected="{{ old('image-encoding', settings()->get('image-encoding')) }}" :options="[
            '0' => __('Disabled'),
            '1' => __('Enabled'),
        ]"></x-select>

      <x-select label="{{ __('Driver (Make sure it is active on the server)') }}" name="image-driver"
        selected="{{ old('image-driver', settings()->get('image-driver')) }}" :options="[
            'gd' => __('GD'),
            'imagick' => __('imagick'),
        ]"></x-select>

      @php
        $isGdActive = extension_loaded('gd');
        $isImagickActive = extension_loaded('imagick');
      @endphp

      @if (!$isGdActive && settings()->get('image-driver') == 'gd')
        <x-error :single="true">{{ __('Error: GD module is not active on the server.') }}</x-error>
      @endif

      @if (!$isImagickActive && settings()->get('image-driver') == 'imagick')
        <x-error :single="true">{{ __('Error: Imagick module is not active on the server.') }}</x-error>
      @endif

      <x-select label="{{ __('Preferred Images Extension. deafult: webp') }}" name="extension"
        selected="{{ old('extension', settings()->get('extension')) }}" :options="[
            'webp' => __('webp - Recommended'),
            'jpg' => __('jpg - Not Recommended'),
            'jpeg' => __('jpeg - Not Recommended'),
            'png' => __('png - Not Recommended'),
            'same' => __('Same as uploaded - Not Recommended'),
        ]"></x-select>

      <x-input label="{{ __('Images Quality 1 - 100 (70 - 80 is the best)') }}" type="number" name="quality" :value="old('quality', settings()->get('quality'))" />
      <x-primary-button>{{ __('Update') }}</x-primary-button>
    </form>
  </div>
@endsection
