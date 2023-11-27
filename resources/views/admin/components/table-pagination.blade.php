<div class="table-pagination">
  <div class="table-pagination-info">
    <div class="table-pagination-total">      
      <span>{{$items->firstItem()}} - {{$items->lastItem()}} de {{$items->total()}} registros</span>
    </div>
    <div class="table-pagination-pages">
      <div class="table-current-page">
        <span>Página {{$items->currentPage()}} de {{$items->lastPage()}}</span>
      </div>
    </div>
  </div>
  <div class="table-pagination-buttons">
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
  </div>
</div>