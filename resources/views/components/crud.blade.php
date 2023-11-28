 @props(['title'])

<x-layouts.admin :title="$title">

  <div class="crud">
    <section class="table">
      {{$table}}
    </section>
  
    <section class="form">
      {{$form}}
    </section>
  </div>

</x-layouts.admin>
