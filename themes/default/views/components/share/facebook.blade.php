@props(['link'])

<x-share.wrapper class="bg-blue-600 hover:bg-blue-700" link="{{ $link }}">
  <x-fab-facebook class="inline-block h-4 w-4" />
  <span class="hidden text-sm md:inline-block">{{ __('Facebook') }}</span>
</x-share.wrapper>
