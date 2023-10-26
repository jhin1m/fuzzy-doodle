<a
  {{ $attributes->merge(['class' => 'cursor-pointer py-1 sm:px-2 w-full sm:hover:rounded-sm sm:hover:bg-black/10 sm:dark:hover:bg-white/10 duration-200 transition-colors']) }}>
  {{ $slot ?? '' }}
</a>
