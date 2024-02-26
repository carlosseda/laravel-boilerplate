@props([
  'form',
  'record' => null,
  'locale' => '',
  'name',
  'label',
  'value' => '',
  'width' => 'full-width',
  'inputAttributes' => [],
])

@php
  if ($record) $value = $record[$name . '.' . $locale] ?? $record->{$name} ?? '';
  if ($locale) $name = 'locale[' . $name . '.' . $locale . ']';
@endphp

<div class="form-element {{ $width }}">
  <div class="form-element-label">
      <label for="{{ $form }}-{{ $name }}">{{ $label }}</label>
  </div>
  <div class="form-element-input">
    <textarea 
      name="{{ $name }}" 
      id="{{ $form }}-{{ $name }}"
    >{{ $value }}</textarea>
  </div>
</div>