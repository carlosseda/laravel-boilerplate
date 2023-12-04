@props([
  'form',
  'name',
  'label',
  'value' => '',
  'width' => 'full-width',
  'options' => [],
])

<div class="form-element {{ $width }}">
  <div class="form-element-label">
      <label for="{{ $form }}-{{ $name }}">{{ $label }}</label>
  </div>
  <div class="form-element-input">
    <select name="{{ $name }}" id="{{ $form }}-{{ $name }}">
      @foreach ($options as $option)
        <option value="{{ $option['value'] }}" {{ $option['selected'] ?? '' }}>{{ $option['label'] }}</option>
      @endforeach
    </select>
  </div>
</div>