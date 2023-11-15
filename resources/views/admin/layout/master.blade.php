<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" href="">

        <title>Maquetación</title>

        @include("admin.layout.partials.styles")
    </head>

    <body>
        <div class="wrapper" id="app">

            @include('admin.components.wait')
            @include('admin.components.messages')
            @include('admin.components.modal_delete')
            @include('admin.components.modal_image')
            @include('admin.layout.partials.topbar')

            @if(isset($filters))
                @include('admin.components.table_filters', [
                    'route' => $route, 
                    'filters' => $filters, 
                    'order' => $order
                ])
            @endif

            <div class="main-content">
                @yield('content')
            </div>

            @if($agent->isMobile())
                @include('admin.layout.partials.bottombar')
            @endif
        </div>      

        @include("admin.layout.partials.js")
    </body>
</html>
