@props([
  'tableStructure' => [],
  'records' => [],
])

@if(in_array('filterButton', $tableStructure['tableButtons']))
  <x-admin-table-filter :filters="$tableStructure['filters']" />
@endif

<x-admin-table-buttons :tableButtons="$tableStructure['tableButtons']" />

<x-admin-table-records 
  :records="$records"
  :columns="$tableStructure['columns']" 
  :recordButtons="$tableStructure['recordButtons']" 
/>

<x-table-pagination :records="$records" />
