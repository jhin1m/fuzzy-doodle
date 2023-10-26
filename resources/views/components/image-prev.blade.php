@props(['src'])
<div class="flex items-center justify-center rounded-md bg-black/10 p-3 dark:bg-white/10">
  <img src="{{ $src }}" alt="{{ __('Preview') }}" {{ $attributes }} />
</div>
