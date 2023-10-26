<x-ads.float identifier="float-bottom" place="bottom" />
<x-ads.float identifier="float-left" place="left" />
<x-ads.float identifier="float-right" place="right" />

<footer class="flex w-full flex-col items-center justify-center py-5">
  <div class="mb-3 flex gap-3">
    @if (settings()->get('theme.social.facebook'))
      <a href="{{ settings()->get('theme.social.facebook') }}" target="_blank" aria-label="{{ __('Facebook') }}">
        <x-fab-facebook class="h-5 w-5 transition-colors duration-200 hover:text-blue-500" />
      </a>
    @endif
    @if (settings()->get('theme.social.instagram'))
      <a href="{{ settings()->get('theme.social.instagram') }}" target="_blank" aria-label="{{ __('Instagram') }}">
        <x-fab-instagram class="h-5 w-5 transition-colors duration-200 hover:text-red-500" />
      </a>
    @endif
    @if (settings()->get('theme.social.twitter'))
      <a href="{{ settings()->get('theme.social.twitter') }}" target="_blank" aria-label="{{ __('Twitter') }}">
        <x-fab-twitter class="h-5 w-5 transition-colors duration-200 hover:text-blue-300" />
      </a>
    @endif
    @if (settings()->get('theme.social.discord'))
      <a href="{{ settings()->get('theme.social.discord') }}" target="_blank" aria-label="{{ __('Discord') }}">
        <x-fab-discord class="h-5 w-5 transition-colors duration-200 hover:text-blue-800" />
      </a>
    @endif
  </div>
  <div class="mb-1 flex flex-wrap justify-center gap-2">
    @foreach (\App\Models\Page::all() as $page)
      <a href="{{ url('/page/' . $page->slug) }}"
        class="text-sm text-gray-800 transition hover:text-blue-500 dark:text-blue-500 dark:hover:text-blue-600">{{ $page->title }}</a>
    @endforeach
  </div>
  <span class="text-sm text-black !text-opacity-60 dark:dark:text-white">{{ __('All rights reserved.') }} ©2023</span>

  <a href="{{ url('/') }}">{{ config('app.name') }}</a>
</footer>

{!! settings()->get('custom_html') !!}
