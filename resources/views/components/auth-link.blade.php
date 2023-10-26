@props(['link'])

<a class="text-blue-400 hover:text-blue-500 duration-200 transition-all"
  href="{{ $link }}">{{ $slot }}</a>
