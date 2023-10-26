@props(['errors', 'single' => false])

@php
  $divClasses = 'bg-transparent border-[1px] border-white/10 rounded-md p-4 mb-3 flex gap-3 items-center';
  $icon = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
      </svg>';
@endphp

@if ($single)
  <div {{ $attributes->merge(['class' => $divClasses]) }}>
    {!! $icon !!}
    <span>{{ $slot ?? '' }}</span>
  </div>
@else
  @if ($errors->any())
    <div {{ $attributes->merge(['class' => $divClasses]) }}>
      {!! $icon !!}
      <div>
        @foreach ($errors->all() as $error)
          <p class="text-sm">{{ $error }}</p>
        @endforeach
      </div>
    </div>
  @endif
@endif
