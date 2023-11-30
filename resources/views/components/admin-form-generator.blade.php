@props([
  'inputs' => [], 
  'record' => null,
])

<form class="admin-form">

  <input type="hidden" name="id" value="{{$record?->id}}">

  @foreach ($inputs as $section => $content)
    <div class="tab-content {{ $loop->first ? 'active' : '' }}" data-tab="{{ $section }}">
      <div class="form-elements">
        @isset($content['noLocale'])
          @foreach ($content['noLocale'] as $formElement)
            @switch($formElement['type'])
              @case('textarea')
                <x-form.textarea 
                  :name="$formElement['name']"
                  :width="$formElement['width']" 
                  :label="$formElement['label']" 
                  :value="$record?->{$formElement['name']}"
                  :inputAttributes="$formElement['attributes'] ?? ''"
                />
                @break

              @case('image')
                <x-form.file
                  :name="$formElement['name']"
                  :width="$formElement['width']" 
                  :label="$formElement['label']" 
                  :value="$record?->{$formElement['name']}"
                  :inputAttributes="$formElement['attributes'] ?? ''"
                />
                @break
      
              @case('file')
                <x-form.file
                  :name="$formElement['name']"
                  :width="$formElement['width']" 
                  :label="$formElement['label']" 
                  :value="$record?->{$formElement['name']}"
                  :inputAttributes="$formElement['attributes'] ?? ''"
                />
                @break
      
              @case('select')

                <x-form.select
                  :name="$formElement['name']"
                  :width="$formElement['width']" 
                  :label="$formElement['label']" 
                  :value="$record?->{$formElement['name']}"
                  :options="$formElement['options']"
                  :inputAttributes="$formElement['attributes'] ?? ''"
                />
                @break
      
              @case('checkbox')

                <x-form.checkbox
                  :name="$formElement['name']"
                  :width="$formElement['width']"
                  :label="$formElement['label']"
                  :value="$record?->{$formElement['name']}"
                  :options="$formElement['options']"
                  :inputAttributes="$formElement['attributes'] ?? ''"
                />
                @break
      
              @case('radio')

                <x-form.radio
                  :name="$formElement['name']"
                  :width="$formElement['width']"
                  :label="$formElement['label']"
                  :value="$record?->{$formElement['name']}"
                  :options="$formElement['options']"
                  :inputAttributes="$formElement['attributes'] ?? ''"
                />
                @break
      
              @default
                <x-form.input
                  :name="$formElement['name']"
                  :width="$formElement['width']"
                  :label="$formElement['label']"
                  :value="$record?->{$formElement['name']}"
                  :type="$formElement['type']"
                  :inputAttributes="$formElement['attributes'] ?? []"
                />
                @break
            @endswitch
          @endforeach
        @endif

        @isset($content['locale'])

          <section class="locale-inputs">

            <div class="locale-bar">
              <x-tabs
                :tabs="$languages"
              />
            </div>

            @foreach($languages as $language)

              <div class="tab-content {{ $loop->first ? 'active' : '' }}" data-tab="{{ $language['name'] }}">

                <div class="form-elements">
                  @foreach ($content['locale'] as $formElement)
                    @switch($formElement['type'])
                      @case('textarea')
                        <x-form.textarea 
                          :width="$formElement['width']" 
                          :name="$formElement['name']" 
                          :label="$formElement['label']" 
                          :value="$record?->{$formElement['name']}"
                        />
                        @break
              
                      @case('file')
                        <x-form.file
                          :width="$formElement['width']" 
                          :name="$formElement['name']" 
                          :label="$formElement['label']" 
                          :value="$record?->{$formElement['name']}"
                        />
                        @break
              
                      @case('select')
        
                        <x-form.select
                          :width="$formElement['width']" 
                          :name="$formElement['name']" 
                          :label="$formElement['label']" 
                          :value="$record?->{$formElement['name']}"
                          :options="$formElement['options']"
                        />
                        @break
              
                      @case('checkbox')
        
                        <x-form.checkbox
                          :width="$formElement['width']"
                          :name="$formElement['name']"
                          :label="$formElement['label']"
                          :value="$record?->{$formElement['name']}"
                          :options="$formElement['options']"
                        />
                        @break
              
                      @case('radio')
        
                        <x-form.radio
                          :width="$formElement['width']"
                          :name="$formElement['name']"
                          :label="$formElement['label']"
                          :value="$record?->{$formElement['name']}"
                          :options="$formElement['options']"
                        />
                        @break
              
                      @default
                        <x-form.input
                          :width="$formElement['width']"
                          :name="$formElement['name']"
                          :label="$formElement['label']"
                          :value="$record?->{$formElement['name']}"
                          :type="$formElement['type']"
                          :atributes="$formElement['atributes'] ?? ''"
                        />
                        @break
                    @endswitch
                  @endforeach
                </div>
              </div>
            @endforeach   
          </section>
        @endisset
      </div>
    </div>
  @endforeach
</form>