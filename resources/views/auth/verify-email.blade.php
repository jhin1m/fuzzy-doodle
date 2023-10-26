@section('title', __('Email verification'))
@extends('auth.layout')
@section('content')
  @include('auth.heading', ['text' => __('Go Back'), 'title' => __('Email verification')])
  <div class="flex flex-col gap-3">
    <x-success :status="session('status')" />

    <form action="{{ route('verification.send') }}" method="POST" class="flex flex-col gap-3">
      @csrf
      <x-primary-button>{{ __('Send another request') }}</x-primary-button>
    </form>
  </div>
@endsection
