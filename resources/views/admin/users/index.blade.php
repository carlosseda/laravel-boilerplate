<x-crud title="Usuarios">
  <x-slot name="table">
    <x-admin-table
      :tableStructure="$tableStructure"
      :records="$records"
    />
  </x-slot>

  <x-slot name="form">
    <x-admin-form 
      :formStructure="$formStructure"
      :record="$record"
    />
  </x-slot>
</x-crud>

