@extends('admin.layout.master')

@section('content')

  <div class="crud">
    <section class="table">
      @yield('table')
    </section>
  
    <section class="form">
      @yield('form')
    </section>
  </div>

@endsection