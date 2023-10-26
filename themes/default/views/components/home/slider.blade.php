@props(['sliders' => []])

@php
  $assetPath = asset('storage/slider/');
@endphp

@if (!empty($sliders))
  <section class="-mt-4 mb-5 ml-[calc((100%-100vw)/2)] w-screen sm:-mt-24" id="slider-container">
    <swiper-container id="home-slider">
      @foreach ($sliders as $slide)
        @php
          $sliderImage = $assetPath . '/' . $slide->slider_image;
          $typeTitle = $slide->type_title ?? '-';
          $description = $slide->description;
          $type = $slide->type ? $slide->type : 'manga';
        @endphp
        <swiper-slide class="w-full cursor-pointer">
          <figure class="relative">
            <div class="absolute -bottom-[1px] left-0 h-1/2 w-full bg-gradient-to-b from-transparent to-white transition dark:to-[#121212]">
            </div>
            <img class="lazyload min-h-[45vh] w-full object-cover md:h-[75vh]" data-src="{{ $sliderImage }}" alt="{{ $slide->title }}">
            <div class="absolute bottom-0 z-50 flex flex-col gap-3 px-5 py-5 sm:px-10 lg:py-16 xl:px-32">
              <div class="flex flex-col">
                <p class="mx-1 text-xs capitalize leading-[1rem] text-white text-opacity-60">{{ $typeTitle }}</p>
                <h2 class="text-xl font-semibold text-white drop-shadow-sm sm:text-3xl lg:text-5xl">
                  {{ Str::limit(strip_tags($slide->title), 25, $end = '...') }}
                </h2>
              </div>
              <x-content.slider-genres :genres="$slide->genres" :type="$type" />
              @if ($description)
                <p class="text-xs text-white md:w-2/3 md:text-sm" style="text-shadow: 1px 1px 9px rgba(0,0,0,1);">
                  {{ Str::limit(strip_tags($description), 200, $end = '...') }}
                </p>
              @endif
              <div class="mt-3 flex flex-row gap-3">
                <a href="{{ route($type . '.show', $slide->slug) }}"
                  class="flex items-center gap-2 rounded-md bg-blue-500 px-7 py-3 font-semibold text-white transition hover:bg-blue-700 lg:px-14 lg:py-5">
                  <x-icons.cursor class="h-5 w-5" />
                  <span>{{ __('Read now') }}</span>
                </a>
                <div
                  class="group flex items-center justify-center gap-2 rounded-md border-[1px] border-black/10 px-5 transition hover:bg-blue-700 dark:border-white/10">
                  <x-fas-eye class="h-4 w-4 text-gray-600 group-hover:text-white dark:text-white/60" />
                  <span class="font-semibold group-hover:text-white">{{ $slide->views }}</span>
                </div>
              </div>
            </div>
          </figure>
        </swiper-slide>
      @endforeach
    </swiper-container>
  </section>
@endif
