@props([
  'name',
  'label',
  'value' => '',
  'width' => 'full-width',
])

<div class="form-element {{ $width }}">
  <div class="form-element-label">
      <label for="{{ $name }}">{{ $label }}</label>
  </div>
  <div class="form-element-input">
      <input type="file" name="{{ $name }}" id="{{ $name }}">
  </div>
</div>