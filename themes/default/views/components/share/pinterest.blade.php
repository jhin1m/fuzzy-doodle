@props(['link'])

<x-share.wrapper class="bg-red-400 hover:bg-red-500" link="{{ $link }}">
  <x-fab-pinterest class="inline-block h-4 w-4" />
  <span class="hidden text-sm md:inline-block">{{ __('Pinterest') }}</span>
</x-share.wrapper>
