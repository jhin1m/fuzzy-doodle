@props(['link'])

<a href="{{ $link }}" target="_blank"
  {{ $attributes->merge(['class' => 'flex shadow-md dark:shadow-none items-center justify-center gap-2 rounded-md px-3 py-2 text-white transition text-xs']) }}>
  {{ $slot ?? '' }}
</a>
