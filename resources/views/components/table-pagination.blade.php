@props(['records'])

<div class="table-pagination">
  <div class="table-pagination-info">
    <div class="table-pagination-total">      
      <span>{{$records->total()}} registros en total</span>
    </div>
    <div class="table-pagination-pages">
      @if (!$records->onFirstPage())
        <div class="table-pagination-page" data-pagination="{{$records->previousPageUrl()}}">
          <button><<</button>
        </div>
      @endif

      <div class="table-pagination-page {{ $records->currentPage() == 1 ? 'active' : '' }}" data-pagination="{{$records->url(1)}}">
        <button>1</button>
      </div>

      @if($records->currentPage() > 2 && $records->lastPage() > 2)
        <div class="table-pagination-ellipsis">
          <span>...</span>
        </div>
      @endif

      @if(!in_array($records->currentPage(), [1, $records->lastPage()]))
        <div class="table-pagination-page active">
          <button>{{ $records->currentPage() }}</button>
        </div>
      @endif

      @if($records->currentPage() < $records->lastPage() - 1 && $records->lastPage() > 2)
        <div class="table-pagination-ellipsis">
          <span>...</span>
        </div>
      @endif

      @if($records->lastPage() > 1)
        <div class="table-pagination-page {{ $records->currentPage() == $records->lastPage() ? 'active' : '' }}" data-pagination="{{$records->url($records->lastPage())}}">
          <button>{{ $records->lastPage() }}</button>
        </div>
      @endif

      @if ($records->hasMorePages())
        <div class="table-pagination-page" data-pagination="{{$records->nextPageUrl()}}">
          <button>>></button>
        </div>
      @endif
    </div>
  </div>
</div>