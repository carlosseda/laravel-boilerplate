<div class="table-pagination">
  <div class="table-pagination-info">
    <div class="table-pagination-total">      
      <span>{{$items->total()}} registros en total</span>
    </div>
    <div class="table-pagination-pages">
            {{-- Página anterior --}}
      @if (!$items->onFirstPage())
        <div class="table-pagination-page" data-pagination="{{$items->previousPageUrl()}}">
          <button><<</button>
        </div>
      @endif

      {{-- Página 1 --}}
      <div class="table-pagination-page {{ $items->currentPage() == 1 ? 'active' : '' }}" data-pagination="{{$items->url(1)}}">
        <button>1</button>
      </div>

      {{-- Puntos suspensivos después de la página 1 si es necesario --}}
      @if($items->currentPage() > 2 && $items->lastPage() > 2)
        <div class="table-pagination-ellipsis">
          <span>...</span>
        </div>
      @endif

      {{-- Página actual, excepto si es la primera o la última página --}}
      @if(!in_array($items->currentPage(), [1, $items->lastPage()]))
        <div class="table-pagination-page active">
          <button>{{ $items->currentPage() }}</button>
        </div>
      @endif

      {{-- Puntos suspensivos antes de la última página si es necesario --}}
      @if($items->currentPage() < $items->lastPage() - 1 && $items->lastPage() > 2)
        <div class="table-pagination-ellipsis">
          <span>...</span>
        </div>
      @endif

      {{-- Última página --}}
      @if($items->lastPage() > 1)
        <div class="table-pagination-page {{ $items->currentPage() == $items->lastPage() ? 'active' : '' }}" data-pagination="{{$items->url($items->lastPage())}}">
          <button>{{ $items->lastPage() }}</button>
        </div>
      @endif

      {{-- Página siguiente --}}
      @if ($items->hasMorePages())
        <div class="table-pagination-page" data-pagination="{{$items->nextPageUrl()}}">
          <button>>></button>
        </div>
      @endif
    </div>
  </div>
  {{-- <div class="table-pagination-buttons">
    <div class="table-pagination-button {{$items->onFirstPage() ? 'inactive' : ''}}" data-pagination="{{$items->url(1)}}">
      <button>{{__('admin/pagination.first_page')}}</button>
    </div>
    <div class="table-pagination-button {{$items->onFirstPage() ? 'inactive' : ''}}" data-pagination="{{$items->previousPageUrl()}}">
      <button>Anterior</button>
    </div>
    <div class="table-pagination-button {{$items->currentPage() == $items->lastPage() ? 'inactive' : ''}}" data-pagination="{{$items->nextPageUrl()}}">
      <button>Siguiente</button>
    </div>
    <div class="table-pagination-button {{$items->currentPage() == $items->lastPage() ? 'inactive' : ''}}" data-pagination="{{$items->url($items->lastPage())}}">
      <button>Última</button>
    </div>
  </div> --}}
</div>