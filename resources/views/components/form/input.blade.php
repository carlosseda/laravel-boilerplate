@props([
  'name',
  'label',
  'type' => 'text',
  'width' => 'full-width',
  'value' => '',
  'inputAttributes' => [],
])

<div class="form-element {{ $width }}">
  <div class="form-element-label">
      <label for="{{ $name }}">{{ $label }}</label>
  </div>
  <div class="form-element-input">
    <input type="{{ $type }}" 
      name="{{ $name }}" 
      id="{{ $name }}" 
      value="{{ $value }}" 
      @foreach ($inputAttributes as $key => $value)
        {{ $key }}="{{ $value }}"      
      @endforeach
    >
  </div>
</div>