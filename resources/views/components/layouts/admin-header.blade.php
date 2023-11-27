<header>
  <x-admin-title title="Usuarios" />

  <div class="header-interaction">
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
        <a href="{{route('profile.edit')}}">
          {{ __('admin/user-area.profile') }}
        </a>
  
        <a href="{{route('logout')}}">
          {{ __('admin/user-area.logout') }}
        </a>
      </x-slot>
    </x-dropdown>

    <x-menu></x-menu>
  </div>
</header>