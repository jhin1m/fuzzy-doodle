@include('shared.head')

<body class="h-[100vh] text-sm text-white">
  <main class="flex h-full justify-between">
    <div class="dark:bg-dark-secondary flex h-full w-full items-center justify-center border-l border-white/10 md:w-3/5 lg:w-2/5">
      <div class="mx-auto flex w-[90%] flex-col gap-8 sm:w-3/5">
        @yield('content')
      </div>
    </div>
    <div class="bg-dark-primary hidden h-full items-center justify-center md:flex md:w-2/5 lg:flex lg:w-3/5">
      @php
        if (settings()->get('auth-cover')) {
            $cover = asset('storage/site/' . basename(settings()->get('auth-cover')));
        } else {
            $cover = url('/images/auth.webp');
        }
      @endphp
      <img class="h-full w-full object-cover opacity-10" src="{{ $cover }}" alt="{{ __('Auth Cover') }}">
    </div>
  </main>
</body>
