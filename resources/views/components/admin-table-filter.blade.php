@props([
  'filters' => [],
  'tabs' => false,
])

<section class="filter">
  <div class="filter-content">
    <div class="filter-header">
      <h4>Filtraje de tabla</h4>
    </div>

    <div class="filter-form">
      <form class="table-filter">
        @if ($tabs)
          <div class="tabs-content">
            @foreach ($inputs as $key => $fields)
              <div class="tab-content {{ $loop->first ? 'active' : '' }}" data-tab="{{ $key }}">
                <div class="form-elements">
                  @foreach ($fields as $field)
                    <div class="form-element {{$field['width']}}">
                      <div class="form-element-label">
                        <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                      </div>
                      <div class="form-element-input">
                        @if ($field['type'] === 'textarea')
                          <textarea name="{{ $field['name'] }}" id="{{ $field['name'] }}"></textarea>
                        @elseif ($field['type'] === 'file')
                          <input type="file" name="{{ $field['name'] }}" id="{{ $field['name'] }}">
                        @elseif ($field['type'] === 'select')
                          <select name="{{ $field['name'] }}" id="{{ $field['name'] }}">
                            @foreach ($field['options'] as $option)
                              <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                            @endforeach
                          </select>
                        @else
                          @if ($field['type'] === 'checkbox')
                            @foreach ($field['options'] as $option)
                              <div class="form-element-checkbox">
                                <input type="checkbox" name="{{ $field['name'] }}[]" id="{{ $field['name'] }}-{{ $option['value'] }}" value="{{ $option['value'] }}">
                                <label for="{{ $field['name'] }}-{{ $option['value'] }}">{{ $option['label'] }}</label>
                              </div>
                            @endforeach
                          @elseif ($field['type'] === 'radio')
                            @foreach ($field['options'] as $option)
                              <div class="form-element-radio">
                                <input type="radio" name="{{ $field['name'] }}" id="{{ $field['name'] }}-{{ $option['value'] }}" value="{{ $option['value'] }}">
                                <label for="{{ $field['name'] }}-{{ $option['value'] }}">{{ $option['label'] }}</label>
                              </div>
                            @endforeach
                          @else
                            <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" id="{{ $field['name'] }}">
                          @endif
                        @endif
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            @endforeach
          </div>
        @else
          <div class="form-elements">
            @foreach ($filters as $field)
              <div class="form-element {{$field['width']}}">
                <div class="form-element-label">
                  <label for="{{ $field['name'] }}">{{ $field['label'] }}</label>
                </div>
                <div class="form-element-input">
                  @if ($field['type'] === 'textarea')
                    <textarea name="{{ $field['name'] }}" id="{{ $field['name'] }}"></textarea>
                  @elseif ($field['type'] === 'file')
                    <input type="file" name="{{ $field['name'] }}" id="{{ $field['name'] }}">
                  @elseif ($field['type'] === 'select')
                    <select name="{{ $field['name'] }}" id="{{ $field['name'] }}">
                      @foreach ($field['options'] as $option)
                        <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                      @endforeach
                    </select>
                  @else
                    @if ($field['type'] === 'checkbox')
                      @foreach ($field['options'] as $option)
                        <div class="form-element-checkbox">
                          <input type="checkbox" name="{{ $field['name'] }}[]" id="{{ $field['name'] }}-{{ $option['value'] }}" value="{{ $option['value'] }}">
                          <label for="{{ $field['name'] }}-{{ $option['value'] }}">{{ $option['label'] }}</label>
                        </div>
                      @endforeach
                    @elseif ($field['type'] === 'radio')
                      @foreach ($field['options'] as $option)
                        <div class="form-element-radio">
                          <input type="radio" name="{{ $field['name'] }}" id="{{ $field['name'] }}-{{ $option['value'] }}" value="{{ $option['value'] }}">
                          <label for="{{ $field['name'] }}-{{ $option['value'] }}">{{ $option['label'] }}</label>
                        </div>
                      @endforeach
                    @else
                      <input type="{{ $field['type'] }}" name="{{ $field['name'] }}" id="{{ $field['name'] }}">
                    @endif
                  @endif
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </form>
    </div>

    <div class="filter-footer">
      <div class="filter-option filter-confirm">
        <h4>Actualizar tabla</h4>
      </div>
      <div class="filter-option filter-cancel">
        <h4>Cancelar</h4>
      </div>
    </div>
  </div>
</section>