<div {{ $attributes->merge(['class' => 'rounded-md border-[1px] border-blue-500/60 bg-transparent p-3 dark:border-blue-500/30']) }}>
  {{ $slot ?? '' }}
</div>

