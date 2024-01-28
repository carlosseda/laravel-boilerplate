@props([
  'form',
  'record' => null,
  'locale' => '',
  'name',
  'label',
  'type' => 'text',
  'width' => 'full-width',
  'value' => '',
  'inputAttributes' => [],
])

@php
  if ($locale) $name = 'locale[' . $name . '.' . $locale . ']';
  if ($record && $locale) $value = $record->{$name . '.' . $locale} ?? $record->{$name} ?? '';
@endphp

<div class="form-element {{ $width }}">
  <div class="form-element-label">
      <label for="{{ $form }}-{{ $name }}">{{ $label }}</label>
  </div>
  <div class="form-element-input">
    <input type="{{ $type }}" 
      name="{{ $name }}" 
      id="{{ $form }}-{{ $name }}" 
      value="{{ $value }}"      
      @foreach ($inputAttributes as $key => $value)
        {{ $key }}="{{ $value }}"      
      @endforeach
    >
  </div>
</div>