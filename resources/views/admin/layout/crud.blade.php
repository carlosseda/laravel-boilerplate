@extends('admin.layout.master')

@section('content')

  <section class="table">
    @yield('table')
  </section>

  <section class="form">
    @yield('form')
  </section>

@endsection