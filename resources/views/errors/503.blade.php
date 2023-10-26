@include('includes.head')
@section('title', __('Error 503 - Service Unavailable'))

<main class="h-[100vh] dark:bg-dark-primary dark:text-white">
  <section class="container mx-auto px-3 sm:px-0 md:px-0 flex flex-col items-center justify-center h-full">
    <h2 class="text-3xl font-bold mb-3 text-center">{{ __('Under Maintenance') }}</h2>
    <div class="rounded-md flex flex-col gap-10 p-10 pt-2 items-center text-center">
      <div>
        <p>{{ __('Maintenance mode is up') }}</p>
        <p>{{ __('We will come backback soon!') }}</p>
      </div>
  </section>
</main>
