@props(['label' => null, 'name' => null, 'type', 'class' => null])

@php
  $defaultClass = 'input';
  if ($class) {
      $defaultClass .= ' ' . $class;
  }
@endphp

@if ($label)
  <div class="flex w-full flex-col gap-3">
    <x-label :for="$name" :title="$label" />
@endif

<input @if ($label) id="{{ $name }}" @endif @if ($name) name="{{ $name }}" @endif
  type="{{ $type ?? 'text' }}" class="{{ $defaultClass }}" {{ $attributes->merge(['autocomplete' => 'off']) }} />

@if ($label)
  </div>
@endif
