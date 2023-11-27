@props(['items'])

<div class="table-pagination">
  <div class="table-pagination-info">
    <div class="table-pagination-total">      
      <span>{{$items->total()}} registros en total</span>
    </div>
    <div class="table-pagination-pages">
      @if (!$items->onFirstPage())
        <div class="table-pagination-page" data-pagination="{{$items->previousPageUrl()}}">
          <button><<</button>
        </div>
      @endif

      <div class="table-pagination-page {{ $items->currentPage() == 1 ? 'active' : '' }}" data-pagination="{{$items->url(1)}}">
        <button>1</button>
      </div>

      @if($items->currentPage() > 2 && $items->lastPage() > 2)
        <div class="table-pagination-ellipsis">
          <span>...</span>
        </div>
      @endif

      @if(!in_array($items->currentPage(), [1, $items->lastPage()]))
        <div class="table-pagination-page active">
          <button>{{ $items->currentPage() }}</button>
        </div>
      @endif

      @if($items->currentPage() < $items->lastPage() - 1 && $items->lastPage() > 2)
        <div class="table-pagination-ellipsis">
          <span>...</span>
        </div>
      @endif

      @if($items->lastPage() > 1)
        <div class="table-pagination-page {{ $items->currentPage() == $items->lastPage() ? 'active' : '' }}" data-pagination="{{$items->url($items->lastPage())}}">
          <button>{{ $items->lastPage() }}</button>
        </div>
      @endif

      @if ($items->hasMorePages())
        <div class="table-pagination-page" data-pagination="{{$items->nextPageUrl()}}">
          <button>>></button>
        </div>
      @endif
    </div>
  </div>
</div>