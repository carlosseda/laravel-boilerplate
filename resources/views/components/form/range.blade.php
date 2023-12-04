@props([
  'form',
  'name',
  'label',
  'type' => 'text',
  'width' => 'full-width',
  'value' => '',
  'inputAttributes' => [],
])

<div class="form-element {{ $width }}">
  <div class="form-element-label">
      <label for="{{ $form }}-{{ $name }}">{{ $label }}</label>
  </div>
  <div class="form-element-range">
    <input type="{{ $type }}" 
      name="{{ $name }}" 
      id="{{ $form }}-{{ $name }}" 
      value="{{ $value }}" 
      @foreach ($inputAttributes as $key => $value)
        {{ $key }}="{{ $value }}"      
      @endforeach
    >
    <span class="range-value">
      {{ $value }}
    </span>
  </div>
</div>