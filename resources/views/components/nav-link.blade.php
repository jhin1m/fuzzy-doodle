@props(['active' => false])

<a
  {{ $attributes->merge(['class' => 'cursor-pointer hover:text-black dark:hover:text-white duration-200 transition-colors ' . ($active ? 'text-black dark:text-white' : 'text-gray-500')]) }}>{{ $slot ?? '' }}</a>
