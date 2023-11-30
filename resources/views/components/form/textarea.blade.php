@props([
  'name',
  'label',
  'value' => '',
  'width' => 'full-width',
  'inputAttributes' => [],
])

<div class="form-element {{ $width }}">
  <div class="form-element-label">
      <label for="{{ $name }}">{{ $label }}</label>
  </div>
  <div class="form-element-input">
      <textarea name="{{ $name }}" id="{{ $name }}">{{ $value }}</textarea>
  </div>
</div>