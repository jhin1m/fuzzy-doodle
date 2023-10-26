@section('title', $page->title)
@extends('layout')
@section('content')
  <h2 class="mb-3 text-lg font-bold">{{ $page->title }}</h2>
  <div class="rounded-md bg-gray-500 bg-opacity-10 p-4">
    {!! $page->content ?? '' !!}
  </div>
@endsection
