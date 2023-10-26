@props(['text'])

<div class="flex items-center justify-center gap-1">
  {{ $slot }}
  <span class="text-sm font-bold">{{ $text }}</span>
</div>
