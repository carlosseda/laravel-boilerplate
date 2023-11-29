@props([
  'formStructure' => [],
  'record' => null,
])

<div class="form-top-bar">

  @if($formStructure['tabs'])
    <x-tabs
      :tabs="$formStructure['tabs']"
    />
  @endif

  <x-admin-form-buttons 
    :formButtons="$formStructure['formButtons']" 
  />
</div>

<x-admin-form-validation />

<form class="admin-form">

  <input type="hidden" name="id" value="{{$record?->id}}">

  <div class="tabs-content">
    @foreach ($formStructure['inputs'] as $key => $fields)
      <div class="tab-content {{ $loop->first ? 'active' : '' }}" data-tab="{{ $key }}">
        <div class="form-elements">
          @foreach ($fields as $field)
            <div class="form-element {{$field['width']}}">
              <div class="form-element-label">
                <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
              </div>
              <div class="form-element-input">
                @if ($field['type'] === 'textarea')
                  <textarea name="{{ $field['name'] }}" id="{{ $field['name'] }}">{{ $record?->{$field['name']} }}</textarea>
                @elseif ($field['type'] === 'file')
                  <input type="file" name="{{ $field['name'] }}" id="{{ $field['name'] }}">
                @elseif ($field['type'] === 'select')
                  <select name="{{ $field['name'] }}" id="{{ $field['name'] }}">
                    @foreach ($field['options'] as $option)
                      <option value="{{ $option['value'] }}" {{ $record?->{$field['name']} == $option['value'] ? 'selected' : '' }}>{{ $option['label'] }}</option>
                    @endforeach
                  </select>
                @else
                  @if ($field['type'] === 'checkbox')
                    @foreach ($field['options'] as $option)
                      <div class="form-element-checkbox">
                        <input type="checkbox" name="{{ $field['name'] }}[]" id="{{ $field['name'] }}-{{ $option['value'] }}" value="{{ $option['value'] }}" {{ in_array($option['value'], $record?->{$field['name']} ?? []) ? 'checked' : '' }}>
                        <label for="{{ $field['name'] }}-{{ $option['value'] }}">{{ $option['label'] }}</label>
                      </div>
                    @endforeach
                  @elseif ($field['type'] === 'radio')
                    @foreach ($field['options'] as $option)
                      <div class="form-element-radio">
                        <input type="radio" name="{{ $field['name'] }}" id="{{ $field['name'] }}-{{ $option['value'] }}" value="{{ $option['value'] }}" {{ $record?->{$field['name']} == $option['value'] ? 'checked' : '' }}>
                        <label for="{{ $field['name'] }}-{{ $option['value'] }}">{{ $option['label'] }}</label>
                      </div>
                    @endforeach
                  @else
                    <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" id="{{ $field['name'] }}" value="{{ $field['type'] != 'password' ? $record?->{$field['name']} : '' }}">
                  @endif
                @endif
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endforeach
  </div>
</form>