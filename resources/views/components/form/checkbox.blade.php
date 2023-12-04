@props([
    'form',
    'name',
    'label',
    'options' => [],
    'width' => 'full-width',
])

<div class="form-element {{ $width }}">
  <div class="form-element-label">
      <label>{{ $label }}</label>
  </div>
  <div class="form-element-input">
      <div class="form-element-checkbox">
        @foreach ($options as $option)

        <input type="checkbox" 
          name="{{ $name }}[]" 
          id="{{ $form }}-{{ $name }}-{{ $option['value'] }}" 
          value="{{ $option['value'] }}" 
          {{ $option['checked'] ?? '' }}
        >
        <label for="{{ $form }}-{{ $name }}-{{ $option['value'] }}">{{ $option['label'] }}</label>
        @endforeach

      </div>
  </div>
</div>