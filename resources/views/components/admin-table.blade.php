@props([
  'records' => [],
  'fields' => [],
  'editRoute' => null,
  'destroyRoute' => null,
  'filterInputs' => []
])

<x-admin-table-filter :inputs="$filterInputs" />
<x-admin-table-buttons />

<x-admin-table-records 
  :records="$records"
  :fields="$fields" 
  :editRoute="$editRoute" 
  :destroyRoute="$destroyRoute"
/>

<x-table-pagination :records="$records" />
