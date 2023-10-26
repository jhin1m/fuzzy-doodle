@if (
    $comment->user_id == auth()->id() ||
        (auth()->id() &&
            auth()->user()->can('delete_comments')))
  <form method="POST" action="{{ route('comments.delete', [$comment->id]) }}">
    @csrf
    @method('DELETE')
    <button onclick="return confirm('{{ __('Are you sure?') }}')" class="text-xs text-red-400 transition-all duration-200 hover:text-red-500"
      type="submit">{{ __('Delete') }}</button>
  </form>
@endif
