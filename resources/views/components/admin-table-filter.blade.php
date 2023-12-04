@props([
  'filters' => [],
])

<section class="filter">
  <div class="filter-content">
    <div class="filter-header">
      <h4>Filtraje de tabla</h4>
    </div>

    <div class="filter-form">
      <form class="table-filter">
        <div class="tabs-content">
          @foreach ($filters as $formElement)
            @switch($formElement['type'])
              @case('textarea')
                <x-form.textarea 
                  :name="$formElement['name']"
                  :width="$formElement['width']" 
                  :label="$formElement['label']" 
                  :inputAttributes="$formElement['attributes'] ?? ''"
                />
                @break

              @case('image')
                <x-form.file
                  :name="$formElement['name']"
                  :width="$formElement['width']" 
                  :label="$formElement['label']" 
                  :inputAttributes="$formElement['attributes'] ?? ''"
                />
                @break
      
              @case('file')
                <x-form.file
                  :name="$formElement['name']"
                  :width="$formElement['width']" 
                  :label="$formElement['label']" 
                  :inputAttributes="$formElement['attributes'] ?? ''"
                />
                @break
      
              @case('select')

                <x-form.select
                  :name="$formElement['name']"
                  :width="$formElement['width']" 
                  :label="$formElement['label']" 
                  :options="$formElement['options']"
                  :inputAttributes="$formElement['attributes'] ?? ''"
                />
                @break
      
              @case('checkbox')

                <x-form.checkbox
                  :name="$formElement['name']"
                  :width="$formElement['width']"
                  :label="$formElement['label']"
                  :options="$formElement['options']"
                  :inputAttributes="$formElement['attributes'] ?? ''"
                />
                @break
      
              @case('radio')

                <x-form.radio
                  :name="$formElement['name']"
                  :width="$formElement['width']"
                  :label="$formElement['label']"
                  :options="$formElement['options']"
                  :inputAttributes="$formElement['attributes'] ?? ''"
                />
                @break
      
              @default
                <x-form.input
                  :name="$formElement['name']"
                  :width="$formElement['width']"
                  :label="$formElement['label']"
                  :type="$formElement['type']"
                  :inputAttributes="$formElement['attributes'] ?? []"
                />
                @break
            @endswitch
          @endforeach
        </div>
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