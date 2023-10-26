@props(['genres', 'type' => 'manga'])

<div class="flex flex-wrap gap-1">
  @foreach ($genres as $genre)
    @if ($genre->title)
      <a href="{{ url("/{$type}?genre={$genre->title}") }}"
        class="inline-block rounded-md border-[1px] border-black/10 px-4 py-2 text-xs font-light shadow-sm transition hover:bg-black hover:text-white dark:border-white/10 dark:text-white dark:shadow-none dark:hover:bg-white dark:hover:text-black">{{ $genre->title }}</a>
    @endif
  @endforeach
</div>
