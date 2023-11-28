@props(['title'])

<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="">

    <title>Maquetación</title>

    @vite(['resources/sass/admin-app.scss', 'resources/js/admin-app.js'])
  </head>

  <body>
    
    <x-modal-destroy />
    <x-notification />

    <header>
      <x-admin-title :title="$title" />
    
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
    
        <x-menu />
      </div>
    </header>

    <main>
      {{ $slot }}
    </main>
  </body>
</html>
