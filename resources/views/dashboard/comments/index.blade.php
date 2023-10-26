@section('title', __('Comments List'))
@extends('dashboard.layout')
@section('content')

  <div class="flex flex-col gap-5">
    <div class="flex flex-col gap-1">
      <h3 class="text-3xl font-bold tracking-tight">{{ __('Comments List') }}</h3>
      <p class="text-gray-500 dark:text-white dark:text-opacity-50">
        {{ __('Take control of your comments from this page.') }}
      </p>
    </div>
    <div class="flex flex-col items-end justify-between gap-3 sm:flex-row sm:items-center">
      <x-input placeholder="{{ __('Filter...') }}" id="filter-table" />
    </div>
    <x-table :headings="['#', __('Username'), __('Manga / Chapter'), __('Comment'), __('Likes'), __('Dislikes')]" :contents="$comments
        ->map(function ($comment) {
            return [
                'id' => $comment->id,
                $comment->user->username,
                $comment->commentable->title ??
                $comment->commentable->manga->title . ' - ' . __('Chapter') . ' ' . $comment->commentable->chapter_number,
                $comment->content,
                $comment->likes->count(),
                $comment->dislikes->count(),
                'actions' => [
                    __('Edit') => route('dashboard.comments.edit', $comment->id),
                    __('Delete') => route('dashboard.comments.delete', $comment->id),
                ],
            ];
        })
        ->toArray()" />
    <div class="flex justify-end">
      {{ $comments->appends(request()->query())->links('pagination.default') }}
    </div>
  </div>
@endsection

