<header>
  <div class="top-bar-title">
    <h1>Usuarios</h1>
  </div>
  <div class="top-bar-interaction">
    <x-dropdown>
      <x-slot name="trigger">
          <button>
              <span>{{ Auth::user()->name }}</span>
  
              <div class="arrow">
                  <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                      <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                  </svg>
              </div>
          </button>
      </x-slot>
  
      <x-slot name="content">
        <x-dropdown-link :href="route('profile.edit')">
          {{ __('admin/user-area.profile') }}
        </x-dropdown-link>
  
        <x-dropdown-link :href="route('logout')">
          {{ __('admin/user-area.logout') }}
        </x-dropdown-link>
      </x-slot>
    </x-dropdown>
    <div class="top-bar-menu">
      <div class="menu">
  
      </div>
      <button class="menu-button">
        <svg viewBox="0 0 100 100">
          <path class="line top-line" d="M 20,29.000046 H 80.000231 C 80.000231,29.000046 94.498839,28.817352 94.532987,66.711331 94.543142,77.980673 90.966081,81.670246 85.259173,81.668997 79.552261,81.667751 75.000211,74.999942 75.000211,74.999942 L 25.000021,25.000058" />
          <path class="line middle-line" d="M 20,50 H 80" />
          <path class="line bottom-line" d="M 20,70.999954 H 80.000231 C 80.000231,70.999954 94.498839,71.182648 94.532987,33.288669 94.543142,22.019327 90.966081,18.329754 85.259173,18.331003 79.552261,18.332249 75.000211,25.000058 75.000211,25.000058 L 25.000021,74.999942" />
        </svg>
      </button>
    </div>
  </div>

</header>