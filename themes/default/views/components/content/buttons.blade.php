@props(['firstChapter', 'slug', 'id', 'isNovel' => false])

<div class="fixed inset-x-0 bottom-3 left-0 z-50 mx-auto flex w-5/6 gap-2 sm:static sm:w-full sm:flex-col" id="buttons">
  @php
    $chapter_link = $firstChapter ? route('manga.chapter.show', [$slug, $firstChapter]) : '';
    $classes = 'flex items-center justify-center text-sm font-bold text-center px-4 py-4 sm:py-3 bg-blue-500 text-white rounded-full sm:rounded-md w-full h-12 w-5/6';
    $classes .= $firstChapter ? ' hover:bg-blue-600 active:scale-95 transition-all duration-150' : '';
    $classes .= !$firstChapter ? ' bg-[#1c2f4c] disabled:cursor-not-allowed' : '';
  @endphp

  <button @if ($firstChapter) onclick="window.location.href='{{ $chapter_link }}'" @endif class="{{ $classes }}"
    @if (!$firstChapter) disabled @endif>{{ __('Read') }}</button>

  @php
    $type = 'manga';
    $isBookmarked =
        auth()->check() &&
        auth()
            ->user()
            ->bookmarks()
            ->where('bookmarkable_type', \App\Models\Manga::class)
            ->where('bookmarkable_id', $id)
            ->exists();
    
    // $action = $isBookmarked ? route('bookmarks.delete', $slug) : route('bookmarks.store', $slug);
    $action = route('bookmarks.store', ['type' => $type, 'slug' => $slug]);
    $text = $isBookmarked ? __('Remove from Favorites') : __('Add to Favorites');
  @endphp

  <form action="{{ $action }}" method="POST" class="flex w-1/6 sm:w-full" id="bookmarkForm">
    @csrf
    {{-- @honeypot --}}
    <button type="submit" id="submitBtn"
      class="mb-2 flex h-12 w-full items-center justify-center gap-1 rounded-full bg-red-500 px-4 py-4 text-sm text-white transition-all duration-150 hover:bg-red-600 active:scale-95 sm:h-full sm:rounded-md sm:py-2">
      <x-fas-bookmark class="h-4 w-4" />
      <span class="hidden sm:inline-block" id="btnText">{{ $text }}</span>
    </button>
  </form>
</div>

@auth
  <script>
    const submitBtn = document.querySelector("#submitBtn");
    const bookmarkForm = document.querySelector("#bookmarkForm");
    const btnText = document.querySelector("#btnText");

    bookmarkForm.addEventListener("submit", async (e) => {
      e.preventDefault();
      const form = e.target;
      const formData = new FormData(form);

      try {
        const response = await fetch(form.action, {
          method: form.method,
          body: formData,
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
          },
        });

        if (response.ok) {
          const responseData = await response.json();
          btnText.innerText = responseData?.btnText;
          submitBtn.disabled = false;
          submitBtn.classList.remove("disabled:cursor-not-allowed");
        } else {
          console.error("Server returned an error:", response.statusText);
        }
      } catch (error) {
        console.error("Error during fetch:", error);
      }

    });
  </script>
@endauth
