@props(['link'])

<x-share.wrapper class="bg-blue-400 hover:bg-blue-500" link="{{ $link }}">
  <x-fab-twitter class="inline-block h-4 w-4" />
  <span class="hidden text-sm md:inline-block">{{ __('Twitter') }}</span>
</x-share.wrapper>
