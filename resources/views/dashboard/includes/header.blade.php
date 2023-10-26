<header class="border-b-[1px] border-black/10 dark:border-white/10">
  <nav class="container-app flex items-center justify-between font-medium">
    <a href="#" class="sm:hidden" id="nav-toggle">
      <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M2 5.995c0-.55.446-.995.995-.995h8.01a.995.995 0 0 1 0 1.99h-8.01A.995.995 0 0 1 2 5.995Z"></path>
        <path d="M2 12.003c0-.55.446-.995.995-.995h18.01a.995.995 0 1 1 0 1.99H2.995A.995.995 0 0 1 2 12.003Z"></path>
        <path d="M2.995 17.008a.995.995 0 0 0 0 1.99h12.01a.995.995 0 0 0 0-1.99H2.995Z"></path>
      </svg>
    </a>
    <div class="hidden sm:flex sm:gap-4" id="nav-menu">
      @foreach ($links as $link)
        @can($link['permission'])
          @php
            $isActive = false;
            if (isset($link['dropdown'])) {
                foreach ($link['dropdown'] as $dropdownLink) {
                    if (request()->routeIs($dropdownLink['route'])) {
                        $isActive = true;
                        break;
                    }
                }
            } else {
                $isActive = request()->routeIs($link['route']);
            }
          @endphp

          @if (isset($link['dropdown']))
            <x-nav-link active="{{ $isActive }}" data-toggle="dropdown">{{ __($link['label']) }}</x-nav-link>
            <x-dropdown nav="true">
              @foreach ($link['dropdown'] as $dropdownLink)
                @can($dropdownLink['permission'])
                  <x-dropdown-link href="{{ route($dropdownLink['route']) }}">{{ __($dropdownLink['label']) }}</x-dropdown-link>
                @endcan
              @endforeach
            </x-dropdown>
          @else
            <x-nav-link href="{{ route($link['route']) }}" active="{{ $isActive }}">{{ __($link['label']) }}</x-nav-link>
          @endif
        @endcan
      @endforeach
    </div>
    <div class="flex items-center gap-3">
      <form class="relative">
        <x-input name="filter" placeholder="{{ __('Search...') }}" />

        @php
          $iconClass = __('direction') == 'rtl' ? 'left-3' : 'right-3';
        @endphp
        <button type="submit">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="{{ $iconClass }} absolute top-1/2 h-4 w-4 -translate-y-1/2 cursor-pointer">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
          </svg>
        </button>
      </form>
      <a class="cursor-pointer" data-toggle="dark" aria-label="Dark">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
        </svg>
      </a>

      <x-nav-link data-toggle="dropdown">
        <img class="h-7 w-7 rounded-full object-cover"
          src="{{ auth()->check() && auth()->user()->avatar ? asset('storage/avatars/' . auth()->user()->avatar) : asset('images/user/no-image.jpg') }}"
          alt="Profile" />
      </x-nav-link>
      <x-dropdown>
        <x-dropdown-link href="{{ url('/user/settings') }}">{{ __('Account Settings') }}</x-dropdown-link>
        <x-dropdown-link href="{{ route('home') }}">{{ __('Back to home') }}</x-dropdown-link>
        <form method="POST" action="{{ route('logout') }}" class="flex w-full">
          @csrf
          <x-dropdown-link id="logout-button">{{ __('Logout') }}</x-dropdown-link>
        </form>
      </x-dropdown>
    </div>
  </nav>
</header>
