@props(['id' => null, 'edit' => null, 'delete' => null, 'restore' => null])

<a class="group inline-block cursor-pointer" data-toggle="dropdown">
  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
    class="h-6 w-6 rounded-sm transition">
    <path stroke-linecap="round" stroke-linejoin="round"
      d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
  </svg>
</a>
<x-dropdown>
  @if ($restore)
    <x-dropdown-link href="{{ $restore }}">{{ __('Restore') }}</x-dropdown-link>
  @else
    <x-dropdown-link href="{{ $edit }}">{{ __('Edit') }}</x-dropdown-link>
  @endif

  <x-dropdown-link href="{{ $delete }}" data-toggle="delete" data-id="{{ $id }}"
    class="text-red-600 dark:text-red-400">{{ __('Delete') }}</x-dropdown-link>

</x-dropdown>
