@props(['text', 'info', 'search' => null, 'type' => 'manga'])

<p class="flex justify-between !text-opacity-50 dark:text-white">
  <span>{{ $text }}</span>
  @if ($search)
    <a href="{{ url($search) }}" class="transition-colors duration-200 hover:text-blue-500 dark:hover:text-white">
  @endif
  <span class="capitalize">{{ $info }}</span>
  @if ($search)
    </a>
  @endif
</p>
