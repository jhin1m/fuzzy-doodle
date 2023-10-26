@section('title', __('Edit Comment (#:id)', ['id' => $comment->id]))
@extends('dashboard.layout')
@section('content')

  <div class="flex flex-col gap-5">
    <div class="flex flex-col gap-1">
      <div class="flex justify-between">
        <h3 class="text-3xl font-bold tracking-tight">{{ __('Edit Comment (#:id)', ['id' => $comment->id]) }}</h3>
        <x-table-button href="{{ route('dashboard.comments.index') }}">
          <x-icons.back />
          <span>{{ __('Back') }}</span>
        </x-table-button>
      </div>
    </div>
    <hr class="border-black/10 dark:border-white/10" />
    <x-error :errors="$errors" />

    <form action="{{ route('dashboard.comments.update', $comment->id) }}" method="POST" class="flex flex-col gap-4">
      @csrf
      @method('PUT')

      <x-input label="{{ __('Comment') }}" name="content" :value="old('content', $comment->content)" placeholder="{{ __('Comment content...') }}" />

      <x-primary-button>{{ __('Update') }}</x-primary-button>
    </form>
  </div>
@endsection
