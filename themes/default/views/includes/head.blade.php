<!DOCTYPE html>
<html lang="{{ __('lang') }}" dir="{{ __('direction') }}" class="{{ settings()->get('theme.mode') }}">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ settings()->get('name') }} | @yield('title')</title>
  <meta name="description" content="@yield('description')@if (!empty(trim($__env->yieldContent('description')))) , @endif{{ settings()->get('description') }}">
  <meta name="keywords" content="@yield('title')@if (!empty(trim(settings()->get('keywords')))) {{ ',' . settings()->get('keywords') }} @endif">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @if (settings()->get('favicon'))
    <link rel="icon" type="image/png" href="{{ asset('storage/site/' . basename(settings()->get('favicon'))) }}">
  @else
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon.png') }}">
  @endif

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700;900&display=swap" rel="stylesheet">

  <script>
    const language = {
      "submitting": "{{ __('Submitting') }}",
    };
  </script>
  @vite(['themes/' . config('theme.active') . '/css/app.css', 'themes/' . config('theme.active') . '/js/app.js', 'resources/css/app.css', 'resources/js/app.js'])
  <script src="{{ asset('js/swiper-element-bundle.min.js') }}" defer></script>
</head>
