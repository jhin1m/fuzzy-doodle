@section('title', __('Error 404'))
@include('shared.head')
<main class="dark:bg-dark-primary h-[100vh] dark:text-white">
  <section class="container mx-auto flex h-full flex-col items-center justify-center px-3 sm:px-0 md:px-0">
    <h2 class="mb-3 text-center text-3xl font-bold">{{ __('Error 404') }}</h2>
    <div class="flex flex-col items-center gap-10 rounded-md p-10 pt-2 text-center">
      <div>
        <p>{{ __('The page you are looking for does not exist.') }}</p>
        <p>{{ __('You can go back to homepage by clicking the next button!') }}</p>
      </div>
      <div>
        <a href="{{ route('home') }}"
          class="flex items-center gap-3 rounded bg-blue-500 px-4 py-2 font-bold text-white shadow-md shadow-black/50 transition-all duration-200 hover:bg-blue-700 dark:shadow-none">
          @if (__('direction') === 'ltr')
            <x-fas-arrow-left-long class="h-4 w-4" />
          @else
            <x-fas-arrow-right-long class="h-4 w-4" />
          @endif
          <span>{{ __('Go back to homepage') }}</span>
        </a>
      </div>
  </section>
</main>
