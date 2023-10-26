@props(['title', 'link' => '#', 'icon' => null, 'active' => false, 'has_menu' => true])

<li class="flex flex-col w-full my-[2px]" id="nav-list">
  <a href="{{ $link }}"
    class="flex items-center justify-start gap-1 w-full h-12 px-4 lg:px-5 rounded hover:bg-black/20 {{ $active && !$has_menu ? 'bg-black/20' : '' }}">
    @if ($icon)
      <x-dynamic-component :component="$icon" class="w-5 h-5" />
    @endif
    <span class="mx-2 text-sm font-medium lg:block" id="nav-list-title">{{ $title }}</span>
  </a>
  @if ($has_menu)
    <div class="{{ $active ? 'flex' : 'hidden' }} text-sm mx-6 flex-col">
      {{ $slot }}
    </div>
  @endif
</li>
