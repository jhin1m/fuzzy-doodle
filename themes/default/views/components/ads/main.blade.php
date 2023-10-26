@props(['identifier'])
@php
  $ad = \App\Models\Ad::where('identifier', $identifier)->first();
@endphp

@if ($ad && $ad->is_active)
  <div class="my-3 flex justify-center">
    @if ($ad->type == 'script')
      <div class="inline-block w-full">
        {!! $ad->script !!}
      </div>
    @elseif($ad->type == 'banner')
      <a href="{{ route('ads.redirect', $ad->id) }}">
        <img src="{{ asset('storage/' . $ad->image) }}" alt="{{ __('Ad') }}" class="max-h-52 w-full" />
      </a>
    @endif
  </div>
@endif
