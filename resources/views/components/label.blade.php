@props(['title' => null])

<label {{ $attributes->merge(['class' => 'text-sm font-medium cursor-pointer max-w-fit']) }}>{{ $title ?? $slot }}</label>
