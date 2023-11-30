@props([
  'inputs' => [], 
  'record' => null,
])

<form class="admin-form">

  <input type="hidden" name="id" value="{{$record?->id}}">

  <div class="tabs-content">
    @foreach ($inputs as $section => $content)
      <div class="tab-content {{ $loop->first ? 'active' : '' }}" data-tab="{{ $section }}">
        <div class="form-elements">
          @isset($content['noLocale'])
            @foreach ($content['noLocale'] as $formElement)
              <div class="form-element {{$formElement['width']}}">
                <div class="form-element-label">
                  <label for="{{ $formElement['name'] }}">{{ $formElement['label'] }}</label>
                </div>
                <div class="form-element-input">
                  @if ($formElement['type'] === 'textarea')
                    <textarea name="{{ $formElement['name'] }}" id="{{ $formElement['name'] }}">{{ $record?->{$formElement['name']} }}</textarea>
                  @elseif ($formElement['type'] === 'file')
                    <input type="file" name="{{ $formElement['name'] }}" id="{{ $formElement['name'] }}">
                  @elseif ($formElement['type'] === 'select')
                    <select name="{{ $formElement['name'] }}" id="{{ $formElement['name'] }}">
                      @foreach ($formElement['options'] as $option)
                        <option value="{{ $option['value'] }}" {{ $record?->{$formElement['name']} == $option['value'] ? 'selected' : '' }}>{{ $option['label'] }}</option>
                      @endforeach
                    </select>
                  @else
                    @if ($formElement['type'] === 'checkbox')
                      @foreach ($formElement['options'] as $option)
                        <div class="form-element-checkbox">
                          <input type="checkbox" name="{{ $formElement['name'] }}[]" id="{{ $formElement['name'] }}-{{ $option['value'] }}" value="{{ $option['value'] }}" {{ in_array($option['value'], $record?->{$formElement['name']} ?? []) ? 'checked' : '' }}>
                          <label for="{{ $formElement['name'] }}-{{ $option['value'] }}">{{ $option['label'] }}</label>
                        </div>
                      @endforeach
                    @elseif ($formElement['type'] === 'radio')
                      @foreach ($formElement['options'] as $option)
                        <div class="form-element-radio">
                          <input type="radio" name="{{ $formElement['name'] }}" id="{{ $formElement['name'] }}-{{ $option['value'] }}" value="{{ $option['value'] }}" {{ $record?->{$formElement['name']} == $option['value'] ? 'checked' : '' }}>
                          <label for="{{ $formElement['name'] }}-{{ $option['value'] }}">{{ $option['label'] }}</label>
                        </div>
                      @endforeach
                    @else
                      <input type="{{ $formElement['type'] }}" name="{{ $formElement['name'] }}" id="{{ $formElement['name'] }}" value="{{ $formElement['type'] != 'password' ? $record?->{$formElement['name']} : '' }}">
                    @endif
                  @endif
                </div>
              </div>
            @endforeach
          @endIf

          @isset($content['locale'])

            <section class="locale-inputs">
              <x-tabs
                :tabs="$languages"
              />

              @foreach ($content['locale'] as $formElement)
                <div class="form-element {{$formElement['width']}}">
                  <div class="form-element-label">
                    <label for="{{ $formElement['name'] }}">{{ $formElement['label'] }}</label>
                  </div>
                  <div class="form-element-input">
                    @if ($formElement['type'] === 'textarea')
                      <textarea name="{{ $formElement['name'] }}" id="{{ $formElement['name'] }}">{{ $record?->{$formElement['name']} }}</textarea>
                    @elseif ($formElement['type'] === 'file')
                      <input type="file" name="{{ $formElement['name'] }}" id="{{ $formElement['name'] }}">
                    @elseif ($formElement['type'] === 'select')
                      <select name="{{ $formElement['name'] }}" id="{{ $formElement['name'] }}">
                        @foreach ($formElement['options'] as $option)
                          <option value="{{ $option['value'] }}" {{ $record?->{$formElement['name']} == $option['value'] ? 'selected' : '' }}>{{ $option['label'] }}</option>
                        @endforeach
                      </select>
                    @else
                      @if ($formElement['type'] === 'checkbox')
                        @foreach ($formElement['options'] as $option)
                          <div class="form-element-checkbox">
                            <input type="checkbox" name="{{ $formElement['name'] }}[]" id="{{ $formElement['name'] }}-{{ $option['value'] }}" value="{{ $option['value'] }}" {{ in_array($option['value'], $record?->{$formElement['name']} ?? []) ? 'checked' : '' }}>
                            <label for="{{ $formElement['name'] }}-{{ $option['value'] }}">{{ $option['label'] }}</label>
                          </div>
                        @endforeach
                      @elseif ($formElement['type'] === 'radio')
                        @foreach ($formElement['options'] as $option)
                          <div class="form-element-radio">
                            <input type="radio" name="{{ $formElement['name'] }}" id="{{ $formElement['name'] }}-{{ $option['value'] }}" value="{{ $option['value'] }}" {{ $record?->{$formElement['name']} == $option['value'] ? 'checked' : '' }}>
                            <label for="{{ $formElement['name'] }}-{{ $option['value'] }}">{{ $option['label'] }}</label>
                          </div>
                        @endforeach
                      @else
                        <input type="{{ $formElement['type'] }}" name="{{ $formElement['name'] }}" id="{{ $formElement['name'] }}" value="{{ $formElement['type'] != 'password' ? $record?->{$formElement['name']} : '' }}">
                      @endif
                    @endif
                  </div>
                </div>
              @endforeach
            </section>
          @endisset
        </div>
      </div>

    @endforeach
    
  </div>
</form>