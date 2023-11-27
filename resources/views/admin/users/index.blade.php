<x-crud>
  <x-slot name="table">
    @if (count($users) == 0)
      <x-admin-table-no-records />
    @endif

    <x-table-filter>
      <x-form 
        class="filter-form"
        :tabs=false
        :inputs="[
          ['name' => 'name', 'type' => 'text', 'label' => 'Nombre', 'width' => 'full-width'],
          ['name' => 'email', 'type' => 'email', 'label' => 'Email', 'width' => 'full-width']
        ]"
      />
    </x-table-filter>

    <x-admin-table-buttons />

    <x-admin-table-records 
      :records="$users" 
      :fields="[
        'email' => 'Email',
        'name' => 'Nombre',
        'created_at' => 'Fecha de creación'
      ]" 
      editRoute="users_edit" 
      destroyRoute="users_destroy"
    />

    <x-table-pagination :items="$users" />
  </x-slot>

  <x-slot name="form">
    <div class="form-top-bar">
      <x-tabs
        :tabs="[
          'general' => 'General',
          'images' => 'Imágenes',
        ]"
      />

      <x-admin-form-buttons 
        createRoute="users_create" 
        storeRoute="users_store"
      />
    </div>

    <x-form 
      class="admin-form"
      :tabs=true
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
      :record="$user"
    />
  </x-slot>
</x-crud>

