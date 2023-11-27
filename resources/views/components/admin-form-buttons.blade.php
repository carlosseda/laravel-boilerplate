@props([
  'createRoute' => null,
  'storeRoute' => null,
])

<div class="form-buttons">
  @if ($createRoute)
    <div class="create-button" data-endpoint={{route($createRoute)}}>
      <button>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M19.36,2.72L20.78,4.14L15.06,9.85C16.13,11.39 16.28,13.24 15.38,14.44L9.06,8.12C10.26,7.22 12.11,7.37 13.65,8.44L19.36,2.72M5.93,17.57C3.92,15.56 2.69,13.16 2.35,10.92L7.23,8.83L14.67,16.27L12.58,21.15C10.34,20.81 7.94,19.58 5.93,17.57Z" /></svg>
        <x-tooltiptext text="Nuevo elemento" />                                   
      </button>
    </div>
  @endif
  @if ($storeRoute)
    <div class="store-button" data-endpoint={{route($storeRoute)}}>
      <button>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M15,9H5V5H15M12,19A3,3 0 0,1 9,16A3,3 0 0,1 12,13A3,3 0 0,1 15,16A3,3 0 0,1 12,19M17,3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V7L17,3Z" /></svg>
        <x-tooltiptext text="Guardar elemento" />                                       
      </button>
    </div>
  @endif
</div>