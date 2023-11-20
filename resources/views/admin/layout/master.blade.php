<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="">

        <title>Maquetación</title>

        <link rel="stylesheet" href="style/app.css">
    </head>

    <body>
        @include('admin.layout.partials.header')

        <main>
            @include('admin.components.filter')

            <div class="crud">
                @yield('content')
            </div>
        </main>
    </body>
</html>