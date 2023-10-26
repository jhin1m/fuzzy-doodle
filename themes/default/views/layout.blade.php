@include('includes.head')

<body class="dark:bg-dark-primary flex h-screen flex-col bg-white text-sm dark:text-white">
  @include('includes.header')
  <main class="container mx-auto px-3 sm:px-0 md:px-0">
    @yield('content')
  </main>
  @include('includes.footer')
</body>
