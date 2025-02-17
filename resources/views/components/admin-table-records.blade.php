@props([
  'recordButtons' => [],
  'columns' => [],
  'records' => [],
])

<div class="table-records">
  @if (count($records) == 0)
    <div class="table-no-records">
      <p>No hay registros</p>
    </div>
  @endif
  @foreach ($records as $record)
    <article class="table-record">
      <div class="table-record-buttons">
        @if($recordButtons['editButton'])
          <div class="edit-button" data-endpoint="{{ route($recordButtons['editButton'], $record) }}">
            <button>
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
              </svg>
              <x-tooltiptext text="Editar elemento" />                        
            </button>
          </div>
        @endif
        @if($recordButtons['destroyButton'])
          <div class="destroy-button" data-endpoint="{{ route($recordButtons['destroyButton'], $record) }}">
            <button>
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
              </svg>
              <x-tooltiptext text="Eliminar elemento" />            
            </button>
          </div>
        @endif
      </div>
      <div class="table-data">
        <ul>
          @foreach($columns as $column => $label)
            <li><span>{{ $label }}</span>{{ $record->{$column} }}</li>
          @endforeach
        </ul>
      </div> 
    </article>
  @endforeach
</div>