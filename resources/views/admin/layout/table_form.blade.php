@extends('admin.layout.master')

@section('content')

    <div class="table active" id="table">
        @yield('table')
    </div>

    <div class="form" id="form">
        @yield('form')
    </div>

@endsection