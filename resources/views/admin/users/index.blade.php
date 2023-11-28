<x-crud title="Usuarios">
  <x-slot name="table">
    <x-admin-table
      :records="$users"
      :fields="[
        'email' => 'Email',
        'name' => 'Nombre',
        'created_at' => 'Fecha de creación'
      ]" 
      editRoute="users_edit" 
      destroyRoute="users_destroy"
      :filterInputs="[
        ['name' => 'name', 'type' => 'text', 'label' => 'Nombre', 'width' => 'full-width'],
        ['name' => 'email', 'type' => 'email', 'label' => 'Email', 'width' => 'full-width']
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
          ['name' => 'name', 'type' => 'text', 'label' => 'Nombre', 'width' => 'half-width'],
          ['name' => 'email', 'type' => 'email', 'label' => 'Email', 'width' => 'half-width'],
          ['name' => 'password', 'type' => 'password', 'label' => 'Contraseña', 'width' => 'half-width'],
          ['name' => 'password_confirmation', 'type' => 'password', 'label' => 'Confirmar contraseña', 'width' => 'half-width'],
        ],
        'images' => [
          ['name' => 'image', 'type' => 'file', 'label' => 'Imagen', 'width' => 'full-width'],
        ],
      ]"
      createRoute="users_create"
      storeRoute="users_store"
      :record="$user"
    />
  </x-slot>
</x-crud>

