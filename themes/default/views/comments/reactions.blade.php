<div class="flex items-baseline gap-3">
  <form action="{{ route('comments.reaction.toggle', $comment->id) }}" method="POST" id="likeForm">
    @csrf
    <div class="flex items-baseline gap-2">
      <button>
        <x-icons.thumb-up id="like-btn"
          class="{{ $comment->liked ? 'fill-black dark:fill-white' : '' }} h-4 w-4 hover:fill-black dark:hover:fill-white" />
      </button>
    </div>
  </form>

  <form action="{{ route('comments.reaction.toggle', $comment->id) }}" method="POST" id="dislikeForm">
    @csrf
    <button>
      @php
      @endphp
      <x-icons.thumb-down id="dislike-btn"
        class="{{ $comment->disliked ? 'fill-black dark:fill-white' : '' }} h-4 w-4 hover:fill-black dark:hover:fill-white" />
    </button>
  </form>

  <span class="text-sm text-black dark:text-white" id="total-likes">{{ $comment->sum_count }}</span>
</div>
