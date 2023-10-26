@props(['genres', 'type' => 'manga'])

<div class="flex flex-wrap gap-1">
  @foreach ($genres as $genre)
    @if ($genre->title)
      <a href="{{ url("/{$type}?genre={$genre->title}") }}"
        class="inline-block rounded-md border-[1px] border-white/10 bg-white px-2 py-1 text-xs font-light text-black shadow-sm transition hover:bg-black hover:text-white dark:bg-black dark:text-white dark:shadow-none dark:hover:bg-white dark:hover:text-black sm:px-4 sm:py-2">{{ $genre->title }}</a>
    @endif
  @endforeach
</div>
