@include('shared.head')

<body class="bg-white text-sm text-black dark:bg-[#09090b] dark:text-white">
  <main>
    @include('dashboard.includes.header')
    <section class="container-app">
      @yield('content')
    </section>
  </main>
</body>
