@props(['identifier', 'place' => null])
@php
  $ad = \App\Models\Ad::where('identifier', $identifier)->first();
  switch ($place) {
      case 'bottom':
          $class = 'bottom-0 left-1/2 -translate-x-1/2 w-[90%] max-w-[1000px]';
          break;
  
      case 'left':
          $class = 'top-[10%] left-0';
          break;
  
      case 'right':
          $class = 'top-[10%] right-0';
          break;
  
      default:
          $class = '';
          break;
  }
@endphp

@if ($ad && $ad->is_active)
  <div class="{{ $class }} fixed z-50 flex flex-col">
    <span id="close-ad"
      class="inline-block max-w-fit grow-0 cursor-pointer rounded-t-md border-[1px] border-white/20 bg-black px-3 py-1 text-white hover:bg-black/70">X</span>
    <div class="flex justify-center">
      @if ($ad->type == 'script')
        <div class="inline-block w-full">
          {!! $ad->script !!}
        </div>
      @elseif($ad->type == 'banner')
        <a href="{{ route('ads.redirect', $ad->id) }}" class="w-full max-w-[1000px] shrink-0">
          <img src="{{ asset('storage/' . $ad->image) }}" alt="{{ __('Ad') }}" class="w-full" />
        </a>
      @endif
    </div>
  </div>
@endif
