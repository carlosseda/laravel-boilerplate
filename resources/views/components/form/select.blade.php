@props([
  'name',
  'label',
  'value' => '',
  'width' => 'full-width',
  'options' => [],
])

<div class="form-element {{ $width }}">
  <div class="form-element-label">
      <label for="{{ $name }}">{{ $label }}</label>
  </div>
  <div class="form-element-input">
    <select name="{{ $name }}" id="{{ $name }}">
      @foreach ($options as $option)
        <option value="{{ $option['value'] }}" {{ $option['selected'] ?? '' }}>{{ $option['label'] }}</option>
      @endforeach
    </select>
  </div>
</div>