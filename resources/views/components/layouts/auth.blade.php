<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="">

    <title>Maquetación</title>

    @vite(['resources/sass/auth-app.scss'])
  </head>

  <body>
    <main>
      {{ $slot }}
    </main>
  </body>
</html>
