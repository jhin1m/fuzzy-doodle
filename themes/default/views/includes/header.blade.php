<header class="container relative z-50 mx-auto px-3 sm:px-0" id="navbar">
  <nav class="flex items-center justify-between py-6">
    <div class="flex h-0 items-center gap-4">
      <a href="{{ url('/') }}" class="py-2 font-bold">
        @if (settings()->get('logo'))
          <img class="max-w-[120px] transition-opacity duration-300 hover:opacity-80"
            src="{{ asset('storage/site/' . basename(settings()->get('logo'))) }}" alt="{{ settings()->get('name') }}" />
        @else
          {{ settings()->get('name') }}
        @endif
      </a>

      <div class="hidden items-center gap-1 sm:flex">
        <x-navbar.nav-link link="{{ route('manga.index') }}" text="{{ __('Mangas') }}" />
        <x-navbar.nav-link link="{{ route('bookmarks.index') }}" text="{{ __('Favorites') }}" icon="fas-bookmark"
          icon_classes="text-red-500" />
      </div>
    </div>
    <div class="flex items-center gap-2 sm:gap-5">
      <div class="flex items-center gap-3">
        <a href="#" id="search-link" aria-label="{{ __('Search') }}">
          <x-icons.search class="h-5 w-5 transition hover:text-blue-500" />
        </a>
        <a href="{{ route('manga.random') }}" aria-label="{{ __('Random') }}">
          <x-fas-dice class="h-5 w-5 transition hover:text-yellow-400" />
        </a>
        <a class="cursor-pointer" data-toggle="dark" aria-label="{{ __('Dark Mode') }}">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="h-6 w-6">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
          </svg>
        </a>
      </div>
      <x-nav-link data-toggle="dropdown" aria-label="{{ __('User Menu') }}">
        <img class="h-9 w-9 rounded-full border-[1px] border-solid border-black/10 object-cover object-top" alt="avatar"
          src="{{ auth()->check() && auth()->user()->avatar ? asset('storage/avatars/' . auth()->user()->avatar) : asset('images/user/no-image.jpg') }}" />
      </x-nav-link>
      <x-dropdown>
        @guest
          <x-dropdown-link href="{{ url('/register') }}">{{ __('Register') }}</x-dropdown-link>
          <x-dropdown-link href="{{ url('/login') }}">{{ __('Login') }}</x-dropdown-link>
        @endguest

        @auth
          <x-dropdown-link href="{{ url('/user/settings') }}">{{ __('User Setting') }}</x-dropdown-link>
          @can('view_dashboard')
            <x-dropdown-link href="{{ url('/dashboard') }}">{{ __('Admin Dashboard') }}</x-dropdown-link>
          @endcan
          <form method="POST" action="{{ route('logout') }}" class="flex w-full">
            @csrf
            <x-dropdown-link href="{!! route('logout') !!}" id="logout-button">{{ __('Logout') }}</x-dropdown-link>
          </form>
        @endauth
      </x-dropdown>
    </div>
  </nav>

  <div id="nav-search" class="animate__animated animate__fast mb-8 hidden w-full sm:absolute">
    <x-navbar.search-form />
  </div>
</header>

<div id="phone-nav" class="-mt-4 mb-4 flex flex-col gap-3 bg-blue-600 p-3 text-white sm:hidden md:hidden lg:hidden">
  <div class="flex w-full flex-wrap justify-center gap-3 text-sm">
    <x-navbar.phone-nav-link link="{{ route('manga.index') }}" text="{{ __('Mangas') }}" icon="fas-list" />
    @auth
      <x-navbar.phone-nav-link link="{{ route('bookmarks.index') }}" text="{{ __('Favorites') }}" icon="fas-bookmark" />
    @endauth
  </div>

</div>
