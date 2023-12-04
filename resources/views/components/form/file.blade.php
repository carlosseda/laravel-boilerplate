@props([
  'form',
  'name',
  'label',
  'value' => '',
  'width' => 'full-width',
])

<div class="form-element {{ $width }}">
  <div class="form-element-label">
      <label for="{{ $form }}-{{ $name }}">{{ $label }}</label>
  </div>
  <div class="form-element-input">
      <input type="file" name="{{ $name }}" id="{{ $form }}-{{ $name }}">
  </div>
</div>