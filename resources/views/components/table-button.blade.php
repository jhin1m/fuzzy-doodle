<a
  {{ $attributes->merge(['class' => 'flex items-center gap-1 rounded-md border-[1px] border-black/10 bg-white px-4 py-2 text-xs font-medium transition hover:bg-black/10 dark:border-white/10 dark:bg-[#09090b] dark:hover:bg-white/10']) }}>
  {{ $slot ?? '' }}
</a>
