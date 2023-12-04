@props([
  'form',
  'locale' => '',
  'name',
  'label',
  'value' => '',
  'width' => 'full-width',
  'inputAttributes' => [],
])

<div class="form-element {{ $width }}">
  <div class="form-element-label">
      <label for="{{ $form }}-{{ $name }}">{{ $label }}</label>
  </div>
  <div class="form-element-input">
      <textarea 
        name="{{ $locale ? 'locale[' . $name . '.' . $locale . ']' : $name }}" 
        id="{{ $form }}-{{ $name }}">
        {{ $value }}
      </textarea>
  </div>
</div>