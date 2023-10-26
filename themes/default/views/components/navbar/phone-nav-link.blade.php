@props(['id' => null, 'link', 'text', 'icon' => null])

<a @if ($id) id="{{ $id }}" @endif href="{{ $link }}" class="flex items-center gap-2"
  {{ $attributes }}>
  @if ($icon)
    <x-dynamic-component :component="$icon" class="h-4 w-4" />
  @endif
  <span>{{ $text }}</span>
</a>
