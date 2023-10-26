@props(['text', 'title'])

<a href="{{ url('/') }}" class="-mb-6 text-blue-400 hover:text-blue-600 duration-200 transition-all">
  {{ __('direction') === 'ltr' ? '←' : '→' }} {{ $text }}
</a>

<span class="block text-xl font-bold">{{ $title }}</span>
