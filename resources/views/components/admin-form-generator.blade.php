@props([
  'inputs' => [], 
  'record' => null,
])

<form class="admin-form">

  <input type="hidden" name="id" value="{{$record?->id}}">

  @foreach ($inputs as $section => $content)
    <div class="tab-content {{ $loop->first ? 'active' : '' }}" data-tab="{{ $section }}">
      <div class="form-elements">
        @foreach ($content as $localization => $formElements)
          @if ($localization == 'noLocale')
            @foreach ($formElements as $formElement)
              @switch($formElement['type'])
                @case('textarea')

                  <x-form.textarea 
                    form="admin-form"
                    :name="$formElement['name']"
                    :width="$formElement['width']" 
                    :label="$formElement['label']" 
                    :value="$record?->{$formElement['name']}"
                    :inputAttributes="$formElement['attributes'] ?? ''"
                  />
                  @break

                @case('image')

                  <x-form.file
                    form="admin-form"
                    :name="$formElement['name']"
                    :width="$formElement['width']" 
                    :label="$formElement['label']" 
                    :value="$record?->{$formElement['name']}"
                    :inputAttributes="$formElement['attributes'] ?? ''"
                  />
                  @break
        
                @case('file')

                  <x-form.file
                    form="admin-form"
                    :name="$formElement['name']"
                    :width="$formElement['width']" 
                    :label="$formElement['label']" 
                    :value="$record?->{$formElement['name']}"
                    :inputAttributes="$formElement['attributes'] ?? ''"
                  />
                  @break
        
                @case('select')

                  <x-form.select
                    form="admin-form"
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
                    form="admin-form"
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
                    form="admin-form"
                    :name="$formElement['name']"
                    :width="$formElement['width']"
                    :label="$formElement['label']"
                    :value="$record?->{$formElement['name']}"
                    :options="$formElement['options']"
                    :inputAttributes="$formElement['attributes'] ?? ''"
                  />
                  @break

                @case('range')

                  <x-form.range
                    form="admin-form"
                    :name="$formElement['name']"
                    :width="$formElement['width']"
                    :label="$formElement['label']"
                    :value="$record?->{$formElement['name']}"
                    :type="$formElement['type']"
                    :inputAttributes="$formElement['attributes'] ?? []"
                  />
                  @break
        
                @default

                  <x-form.input
                    form="admin-form"
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

          @if($localization == 'locale' && $formElements)

            <section class="locale-inputs">
  
              <div class="locale-bar">
                <x-tabs
                  :tabs="$languages"
                />
              </div>

              @foreach($languages as $language)
  
                <div class="tab-content {{ $loop->first ? 'active' : '' }}" data-tab="{{ $language['name'] }}">
  
                  <div class="form-elements">

                    @foreach ($formElements as $formElement)
                    
                      @switch($formElement['type'])
                      
                        @case('textarea')
        
                          <x-form.textarea 
                            form="admin-form"
                            :locale="$language['name']"
                            :name="$formElement['name']"
                            :width="$formElement['width']" 
                            :label="$formElement['label']" 
                            :value="$record?->{$formElement['name']}"
                            :inputAttributes="$formElement['attributes'] ?? ''"
                          />
                          @break
        
                        @case('image')
        
                          <x-form.file
                            form="admin-form"
                            :name="$formElement['name']"
                            :width="$formElement['width']" 
                            :label="$formElement['label']" 
                            :value="$record?->{$formElement['name']}"
                            :inputAttributes="$formElement['attributes'] ?? ''"
                          />
                          @break
                
                        @case('file')
        
                          <x-form.file
                            form="admin-form"
                            :name="$formElement['name']"
                            :width="$formElement['width']" 
                            :label="$formElement['label']" 
                            :value="$record?->{$formElement['name']}"
                            :inputAttributes="$formElement['attributes'] ?? ''"
                          />
                          @break
                
                        @case('select')
        
                          <x-form.select
                            form="admin-form"
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
                            form="admin-form"
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
                            form="admin-form"
                            :name="$formElement['name']"
                            :width="$formElement['width']"
                            :label="$formElement['label']"
                            :value="$record?->{$formElement['name']}"
                            :options="$formElement['options']"
                            :inputAttributes="$formElement['attributes'] ?? ''"
                          />
                          @break
        
                        @case('range')
        
                          <x-form.range
                            form="admin-form"
                            :name="$formElement['name']"
                            :width="$formElement['width']"
                            :label="$formElement['label']"
                            :value="$record?->{$formElement['name']}"
                            :type="$formElement['type']"
                            :inputAttributes="$formElement['attributes'] ?? []"
                          />
                          @break
                
                        @default
        
                          <x-form.input
                            form="admin-form"
                            :locale="$language['name']"
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
                  </div>
                </div>
              @endforeach   
            </section>
          @endif
        @endforeach
      </div>
    </div>
  @endforeach
</form>