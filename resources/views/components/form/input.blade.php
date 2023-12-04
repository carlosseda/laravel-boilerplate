@props([
  'form',
  'locale' => '',
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
  <div class="form-element-input">
    <input type="{{ $type }}" 
      name="{{ $locale ? 'locale[' . $name . '.' . $locale . ']' : $name }}" 
      id="{{ $form }}-{{ $name }}" 
      value="{{ $value }}" 
      @foreach ($inputAttributes as $key => $value)
        {{ $key }}="{{ $value }}"      
      @endforeach
    >
  </div>
</div>