<div class="flex gap-1 items-baseline">
  <h3 class="font-bold">{{ $comment->user->username }}</h3>
  <span class="text-black dark:dark:text-white !text-opacity-60 text-xs"> .
    {{ optional($comment->created_at)->locale(__('lang'))->diffForHumans() ?? '-' }}</span>
</div>
