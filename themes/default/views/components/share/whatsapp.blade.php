@props(['link'])

<x-share.wrapper class="bg-green-500 hover:bg-green-600" link="{{ $link }}">
  <x-fab-whatsapp class="inline-block h-4 w-4" />
  <span class="hidden text-sm md:inline-block">{{ __('Whatsapp') }}</span>
</x-share.wrapper>
