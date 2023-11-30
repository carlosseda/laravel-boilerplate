@props([
  'name',
  'label',
  'options' => [],
  'selected' => null,
  'width' => 'full-width',
])

<div class="form-element {{ $width }}">
  <div class="form-element-label">
    <label>{{ $label }}</label>
  </div>
  <div class="form-element-input">
    @foreach ($options as $option)
      <div class="form-element-radio">
        <input type="radio" 
          name="{{ $name }}" 
          id="{{ $name }}-{{ $option['value'] }}" 
          value="{{ $option['value'] }}" 
          {{ $option['checked'] ?? '' }}
        >
        <label for="{{ $name }}-{{ $option['value'] }}">{{ $option['label'] }}</label>
      </div>
    @endforeach
  </div>
</div>