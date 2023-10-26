@props(['route'])

<a href="{{ route($route) }}"
  class="my-[1px] py-3 px-4 hover:bg-black/20 rounded-md duration-200 transition-all {{ isActiveRoute($route) }}"
  id="nav-item">
  {{ $slot }}
</a>
