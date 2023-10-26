@props(['heading', 'value', 'percentage' => null])

<div class="boder-black/10 flex flex-col gap-4 rounded-lg border-[1px] p-6 shadow-sm dark:border-white/10 dark:shadow-none">
  <div class="flex items-center justify-between gap-3">
    <span class="font-medium tracking-tight">{{ $heading }}</span>
    {{ $slot ?? '' }}
  </div>
  <div class="flex flex-col">
    <span class="text-2xl font-bold">{{ $value }}</span>
    @if ($percentage)
      <span class="text-muted-foreground text-xs text-gray-500">{{ $percentage }}</span>
    @endif
  </div>
</div>
