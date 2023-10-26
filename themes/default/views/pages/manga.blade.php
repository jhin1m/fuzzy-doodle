@section('title', str_replace(':title', $manga->title, settings()->get('seo.manga.title')))
@section('description', str_replace(':title', $manga->title, settings()->get('seo.manga.description')))
@extends('layout')
@section('content')
  <x-content.wrapper>
    <x-content.info :content="$manga">
      @php
        $statusSearch = $manga->status_title ? route('manga.index', ['status' => $manga->status_title]) : route('manga.index');
        $typeSearch = $manga->type_title ? route('manga.index', ['type' => $manga->type_title]) : route('manga.index');
      @endphp
      <x-content.info-item text="{{ __('Status') }}" :info="$manga->status_title" search="{{ $statusSearch }}" />
      <x-content.info-item text="{{ __('Type') }}" :info="$manga->type_title" search="{{ $typeSearch }}" />
      <x-content.info-item text="{{ __('Year') }}" :info="$manga->releaseDate ?? '-'" />
      <x-content.info-item text="{{ __('Author') }}" :info="$manga->author ?? '-'" />
      <x-content.info-item text="{{ __('Artist') }}" :info="$manga->artist ?? '-'" />
      <x-content.info-item text="{{ __('Posted') }}" :info="$manga->user->username ?? '-'" />
    </x-content.info>
    <x-content.data :content="$manga" :comments="$comments" />
  </x-content.wrapper>
@endsection
