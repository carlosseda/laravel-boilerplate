@props([
  'formStructure' => [],
  'record' => null,
])

<div class="form-top-bar">

  @if($formStructure['tabs'])
    <x-tabs
      :tabs="$formStructure['tabs']"
    />
  @endif

  <x-admin-form-buttons 
    :formButtons="$formStructure['formButtons']" 
  />
</div>

<x-admin-form-validation />

<x-admin-form-generator 
  :inputs="$formStructure['inputs']" 
  :record="$record"
/>
