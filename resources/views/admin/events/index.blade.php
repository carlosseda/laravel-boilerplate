<x-crud title="Eventos">
  <x-slot name="table">
    <x-admin-table
      :records="$events"
      :fields="[
        'name' => 'Nombre',
        'date' => 'Fecha',
        'time' => 'Hora'
      ]" 
      editRoute="events_edit" 
      destroyRoute="events_destroy"
      :filterInputs="[
        ['name' => 'name', 'type' => 'text', 'label' => 'Nombre', 'width' => 'full-width'],
        ['name' => 'date', 'type' => 'date', 'label' => 'Fecha', 'width' => 'full-width'],
        ['name' => 'time', 'type' => 'time', 'label' => 'Hora', 'width' => 'full-width']
      ]"
    />
  </x-slot>

  <x-slot name="form">
    <x-admin-form 
      :tabs="[
        ['name' => 'general', 'label' => 'General'],
        ['name' => 'images', 'label' => 'Imágenes']
      ]"
      :inputs="[
        'general' => [
          ['name' => 'name', 'type' => 'text', 'label' => 'Nombre', 'width' => 'full-width'],
          ['name' => 'address', 'type' => 'text', 'label' => 'Dirección', 'width' => 'half-width'],
          ['name' => 'price', 'type' => 'number', 'label' => 'Precio', 'width' => 'half-width'],
          ['name' => 'date', 'type' => 'date', 'label' => 'Fecha', 'width' => 'half-width'],
          ['name' => 'time', 'type' => 'time', 'label' => 'Hora', 'width' => 'half-width'],
          ['name' => 'description', 'type' => 'textarea', 'label' => 'Descripción', 'width' => 'full-width'],
        ],
        'images' => [
          ['name' => 'featured_image', 'type' => 'file', 'label' => 'Imagen destacada', 'width' => 'full-width'],
        ],
      ]"
      createRoute="events_create"
      storeRoute="events_store"
      :record="$event"
    />
  </x-slot>
</x-crud>
