@props(['link', 'text' => null, 'icon' => null, 'icon_classes' => null])

<a href="{{ $link }}"
  {{ $attributes->merge(['class' => 'nav-link text-sm p-2 hover:bg-black/10 hover:rounded-sm flex gap-2 items-center transition']) }}>
  @if ($icon)
    <x-dynamic-component :component="$icon" class="{{ $icon_classes }} h-4 w-4" />
  @endif

  @if ($text)
    <span>{{ $text }}</span>
  @endif
</a>
