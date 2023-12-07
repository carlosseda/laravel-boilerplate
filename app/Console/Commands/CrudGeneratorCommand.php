<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CrudGeneratorCommand extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'make:crud {entityName}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = "Genera un CRUD completo para una entidad.\n
  Escribe el nombre de la entidad en singular, en minúsculas y en snake_case.\n 
  Por ejemplo: php artisan make:crud faq o php artisan make:crud faq_category";

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $this->info("\n\nBienvenido al generador de CRUD de Laravel.\n
    Responde a las siguientes preguntas para crear un CRUD completo para tu entidad.\n 
    Puedes cancelar en cualquier momento escribiendo !q\n
    ###############################################################\n");

    $entityName = Str::singular(strtolower($this->argument('entityName')));
    $pluralEntityName = Str::plural($entityName);

    $capitalizeEntityName = str_replace('_', ' ', $entityName);
    $capitalizeEntityName = ucwords($capitalizeEntityName);
    $capitalizeEntityName = str_replace(' ', '', $capitalizeEntityName);

    $urlName = strtolower($this->ask("¿Cuál es el nombre de la URL?: \n\n
    - La url estará dentro de /admin, no hace falta que escribas /admin\n
    - Escribe el nombre en minúsculas, por ejemplo faqs\n
    - Puedes usar guiones, por ejemplo faqs-categorias\n
    - Puedes usar un subdirectorio, por ejemplo faqs/categorias\n"));
    $this->quick($urlName);
    
    $titleName = strtolower($this->ask('¿Cuál es el título de la página?'));
    $this->quick($urlName);
    $titleName = ucwords($titleName);

    $fields = $this->createMigration($pluralEntityName);
    $this->createModel($capitalizeEntityName, $pluralEntityName, $fields);

    // $this->createView($pluralEntityName, $titleName);
    // $this->createRoutes($urlName, $capitalizeEntityName, $entityName, $pluralEntityName);
    // $this->createController($entityName, $capitalizeEntityName);

    // $this->createRequest($name);

    // $this->call('migrate');
    $this->info('CRUD para ' . $entityName . ' creado exitosamente.');
  }

  protected function createMigration($pluralEntityName){
    $tableRelations = $this->getTableRelations();

    foreach ($tableRelations as $tableRelation) {
      $fields[Str::singular($tableRelation) . '_id'] = ['type' => 'foreignId', 'options' => ['constrained']];
    }

    $fields = $this->addMigrationFields();

    $migrationContent = $this->generateMigrationContent($pluralEntityName, $fields);
    $fileName = date('Y_m_d_His') . '_create_' . Str::snake($pluralEntityName) . '_table.php';
    file_put_contents(database_path('migrations/' . $fileName), $migrationContent);

    return $fields;
  }

  private function createModel($capitalizeEntityName, $pluralEntityName, $fields){
    $templatePath = base_path('templates/model.txt');
    $modelTemplate = file_get_contents($templatePath);

    $formStructure = $this->createFormStructure($pluralEntityName, $fields);
    // $tableStructure = $this->createTableStructure($pluralEntityName, $fields);

    $modelTemplate = str_replace(
      ['{{modelName}}', '{{formStructure}}'],
      [$capitalizeEntityName, $formStructure],
      $modelTemplate
    );

    file_put_contents(app_path("/Models/{$capitalizeEntityName}.php"), $modelTemplate);
  }

  private function createTableStructure($pluralEntityName, $fields){
    $templatePath = base_path('templates/table-structure.txt');
    $tableTemplate = file_get_contents($templatePath);

    $tableFields = array_keys($fields);

    $tableFields = $this->choice(
      "Selecciona los campos que quieres mostrar en la tabla:\n\n",
      $tableFields,
      null,
      null,
      true
    );

    $tableFields = array_map(function($field) {
      $fieldName = $this->ask("¿Qué nombre quieres mostrar para el campo {$field}?");
      $this->quick($fieldName);
      return "'{$field}' => '{$fieldName}'"; 
    }, $tableFields);

    $tableFields = implode(",\n\t\t\t", $tableFields);

    $tableStructure = str_replace(
      ['{{pluralEntityName}}', '{{tableFields}}'],
      [$pluralEntityName, $tableFields],
      $tableTemplate 
    );

    return $tableStructure;
  }

  private function createFormStructure($pluralEntityName, $fields){

    $templatePath = base_path('templates/form-structure.txt');
    $formTemplate = file_get_contents($templatePath);

    $formFields = array_keys($fields);

    $noLocaleFormFields = array_map(function($field) use ($fields) {

      $customFields = [];
      $customFields['name'] = $field;
      
      $fieldName = $this->ask("¿Qué nombre quieres mostrar en el label para el campo {$field}?");
      $this->quick($fieldName);
      $customFields['label'] = $fieldName;

      $fieldType = $this->setFormFieldType($field, $fields);

      if (!$this->confirm('Se ha elegido ' . $fieldType . ' como tipo de dato para ' . $field . "\n ¿Estás de acuerdo?", true)) {
        $fieldType = $this->choice(
          "Tipo de dato para {$field}:\n 
          - Escribe el número correspondiente\n\n",
          ['textarea', 'text', 'number', 'select', 'checkbox', 'radio', 'date', 'time', 'datetime', 'file', 'password', 'email', 'url', 'color', 'range', 'hidden', 'search', 'tel', 'month', 'week', 'datetime-local'], 
          null
        );

        $this->quick($fieldType);
      }

      $customFields['type'] = $fieldType;

      $fieldAttributes = $this->setFormFieldAttributes($field, $fields, $fieldType);
      $customFields['attributes'] = $fieldAttributes;

      $fieldWidth = $this->choice(
        "¿Cuanto espacio quieres que ocupe en el formulario {$field}?:\n 
        - Escribe el número correspondiente\n\n",
        ['full-width', 'half-width', '.one-third-width', '.one-quarter-width'], 
        null
      );

      $this->quick($fieldWidth);

      $customFields['width'] = $fieldWidth;

      return $customFields; 
    
    }, $formFields);

    // Convertir a string $noLocaleFormFields
    $noLocaleFormFields = json_encode($noLocaleFormFields, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    $formStructure = str_replace(
      ['{{noLocaleFormFields}}'],
      [$noLocaleFormFields],
      $formTemplate 
    );

    return $formStructure;
  }

  private function createView($pluralEntityName, $titleName){
    $templatePath = base_path('templates/view.txt');
    $viewTemplate = file_get_contents($templatePath);

    $viewTemplate = str_replace(
      ['{{titleName}}'],
      [$titleName],
      $viewTemplate 
    );

    $directory = resource_path("/views/admin/$pluralEntityName");

    if (!file_exists($directory)) {
        mkdir($directory, 0755, true);
    }

    file_put_contents(resource_path("/views/admin/$pluralEntityName/index.blade.php"), $viewTemplate);
  }

  private function createRoutes($urlName, $capitalizeEntityName, $entityName, $pluralEntityName){
    $templatePath = base_path('templates/route.txt');
    $viewTemplate = file_get_contents($templatePath);

    $injectionName = explode('/', $urlName);

    $viewTemplate = str_replace(
      ['{{urlName}}', '{{controllerName}}', '{{injectionName}}', '{{entityName}}', '{{pluralEntityName}}'],
      [$urlName, $capitalizeEntityName, $injectionName, $entityName, $pluralEntityName],
      $viewTemplate 
    );

    $webRoutes = file_get_contents(base_path("/routes/web.php"));
    $position = strpos($webRoutes, "Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {");
    $position += strlen("Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {");

    $webRoutes = substr_replace($webRoutes, $viewTemplate, $position, 0);

    file_put_contents(base_path("/routes/web.php"), $webRoutes);
  }

  private function createController($entityName, $capitalizeEntityName){
    $templatePath = base_path('templates/controller.txt');
    $viewTemplate = file_get_contents($templatePath);

    $viewTemplate = str_replace(
      ['{{entityName}}','{{capitalizeEntityName}}'],
      [$entityName, $capitalizeEntityName],
      $viewTemplate 
    );

    file_put_contents(app_path("/Http/Controllers/Admin/{$capitalizeEntityName}Controller.php"), $viewTemplate);
  }

  protected function getTableRelations(){
    $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();

    if ($this->confirm('¿Deseas añadir relaciones con otras tablas existentes?')) {
      $tableRelations = $this->choice(
        "Selecciona las tablas con las que se relaciona:\n\n",
        $tables,
        null,
        null,
        true
      );

      $this->quick($tableRelations);

      return $tableRelations;
    }

    return [];
  }

  protected function addMigrationFields(){
    $fields = [];
    $continueAddingFields = true;

    $this->info("\n\nA continuación añadirás los campos que deseas en la tabla de la base de datos.\n
    - Se añadirán automáticamente los campos id, timestamps y softDeletes, no hace falta que los escribas\n
    - Si hay algún campo que será traducible no lo añadas aquí, se añadirá posteriormente al construir el formulario\n");

    while ($continueAddingFields) {

      $fieldName = $this->ask("Añade un nuevo nombre de campo para la tabla:\n
      - Deja en blanco para terminar\n
      - id, timestamps y softDeletes se añaden automáticamente\n\n");

      $this->quick($fieldName);

      if (empty($fieldName)) {
          $continueAddingFields = false;
          continue;
      }

      $fieldType = $this->setFieldType($fieldName);
      $fieldOptions = $this->setFieldOptions($fieldName);
      $additionalValues = $this->setAdditionalValues($fieldName, $fieldOptions);

      $fields[$fieldName] = ['type' => $fieldType, 'options' => $fieldOptions, 'values' => $additionalValues];
    }

    return $fields;
  }

  protected function setFieldType($fieldName){
    $fieldType = $this->choice(
      "Tipo de dato para {$fieldName}:\n 
      - Escribe el número correspondiente\n\n",
      ['bigIncrements', 'bigInteger', 'binary', 'boolean', 'char', 'date', 'dateTime', 'dateTimeTz', 'decimal', 'double', 'enum', 'float', 'geometry', 'geometryCollection', 'increments', 'integer', 'ipAddress', 'json', 'jsonb', 'lineString', 'longText', 'macAddress', 'mediumIncrements', 'mediumInteger', 'mediumText', 'morphs', 'uuidMorphs', 'multiLineString', 'multiPoint', 'multiPolygon', 'nullableMorphs', 'nullableUuidMorphs', 'nullableTimestamps', 'point', 'polygon', 'rememberToken', 'set', 'smallIncrements', 'smallInteger', 'softDeletes', 'softDeletesTz', 'string', 'text', 'time', 'timeTz', 'timestamp', 'timestampTz', 'timestamps', 'timestampsTz', 'tinyIncrements', 'tinyInteger', 'tinyText', 'unsignedBigInteger', 'unsignedDecimal', 'unsignedInteger', 'unsignedMediumInteger', 'unsignedSmallInteger', 'unsignedTinyInteger', 'uuid', 'year'], 
      null
    );

    $this->quick($fieldType);

    return $fieldType;
  }

  protected function setFieldOptions($fieldName){
    $fieldOptions = $this->choice(
      "Características adicionales para {$fieldName}: \n
      - Selecciona todas las características que quieras separando los números con comas\n
      - Selecciona ninguna si no quieres añadir características\n\n",
      ['ninguna', 'after', 'always', 'autoIncrement', 'charset', 'collation', 'comment', 'default', 'first', 'from', 'generatedAs', 'index', 'invisible', 'isGeometry', 'storedAs', 'unique', 'unsigned', 'useCurrent', 'useCurrengtOnUpdate', 'virtualAs'],
      null, 
      null,
      true 
    );

    $this->quick($fieldOptions);

    return array_filter($fieldOptions, function($option) {
      return $option !== 'ninguna';
    });
  }

  protected function setAdditionalValues($fieldName, $fieldOptions){
    $additionalValues = [];

    if (!empty($fieldOptions)) {

      foreach ($fieldOptions as $option) {

        if ($option === 'after') {
          $after = $this->ask("Después de qué campo quieres añadir {$fieldName}");
          $this->quick($after);
          $additionalValues[$option] = $after;
        }
      
        if ($option === 'charset') {
          $charset = $this->choice("Charset para {$fieldName}", ['utf8', 'utf8mb4'], null);
          $this->quick($charset);
          $additionalValues[$option] = $charset;
        }

        if ($option === 'collation') {
          $collation = $this->choice("Collation para {$fieldName}", ['utf8_unicode_ci', 'utf8mb4_unicode_ci'], null);
          $this->quick($collation);
          $additionalValues[$option] = $collation;
        }

        if ($option === 'comment') {
          $comment = $this->ask("Comentario para {$fieldName}");
          $this->quick($comment);
          $additionalValues[$option] = $comment;
        }

        if ($option === 'default') {
          $defaultValue = $this->ask("Valor por defecto para {$fieldName}");
          $this->quick($defaultValue);
          $additionalValues[$option] = $defaultValue;
        }

        if ($option === 'from') {
          $from = $this->ask("Valor para {$fieldName}");
          $this->quick($from);
          $additionalValues[$option] = $from;
        }

        if ($option === 'generatedAs') {
          $generatedAs = $this->ask("Valor para {$fieldName}");
          $this->quick($generatedAs);
          $additionalValues[$option] = $generatedAs;
        }

        if ($option === 'storedAs') {
          $storedAs = $this->ask("Valor para {$fieldName}");
          $this->quick($storedAs);
          $additionalValues[$option] = $storedAs;
        }

        if ($option === 'virtualAs') {
          $virtualAs = $this->ask("Valor para {$fieldName}");
          $this->quick($virtualAs);
          $additionalValues[$option] = $virtualAs;
        }
      }
    }

    return $additionalValues;
  }

  protected function generateMigrationContent($pluralEntityName, $fields){
    $migrationStub = "<?php\n\n";
    $migrationStub .= "use Illuminate\Database\Migrations\Migration;\nuse Illuminate\Database\Schema\Blueprint;\nuse Illuminate\Support\Facades\Schema;\n\n";
    $migrationStub .= "return new class extends Migration\n{\n";
    $migrationStub .= "\tpublic function up()\n\t{\n";
    $migrationStub .= "\t\tSchema::create('" . Str::snake($pluralEntityName) . "', function (Blueprint \$table) {\n";
    $migrationStub .= "\t\t\t\$table->id();\n";

    foreach ($fields as $fieldName => $fieldDetails) {

      $migrationStub .= "\t\t\t\$table->" . $fieldDetails['type'] . "('" . $fieldName . "')";
  
      foreach ($fieldDetails['options'] as $option) {
        if (isset($fieldDetails['values']) && array_key_exists($option, $fieldDetails['values'])) {
          $value = $fieldDetails['values'][$option];
          $migrationStub .= "->" . $option . "(" . $this->formatValue($value) . ")";
        } else {
          $migrationStub .= "->" . $option . "()";
        }
      }
  
      $migrationStub .= ";\n";
    }

    $migrationStub .= "\t\t\t\$table->timestamps();\n";
    $migrationStub .= "\t\t\t\$table->softDeletes();\n";
    $migrationStub .= "\t\t});\n\t}\n\n\tpublic function down()\n\t{\n";
    $migrationStub .= "\t\tSchema::dropIfExists('" . Str::snake($pluralEntityName) . "');\n\t}\n};\n";

    return $migrationStub;
  }

  protected function setFormFieldType($field, $fields){
    $fieldType = $fields[$field]['type'];

    switch ($fieldType) {
      case 'bigIncrements':
      case 'bigInteger':
      case 'increments':
      case 'integer':
      case 'mediumIncrements':
      case 'mediumInteger':
      case 'smallIncrements':
      case 'smallInteger':
      case 'tinyIncrements':
      case 'tinyInteger':
      case 'unsignedBigInteger':
      case 'unsignedInteger':
      case 'unsignedMediumInteger':
      case 'unsignedSmallInteger':
      case 'unsignedTinyInteger':
      case 'decimal':
      case 'double':
      case 'float':
      case 'unsignedDecimal':
          $formFieldType = 'number';
          break;
  
      case 'char':
      case 'string':
      case 'ipAddress':
      case 'macAddress':
          $formFieldType = 'text';
          break;
  
      case 'text':
      case 'longText':
      case 'mediumText':
      case 'tinyText':
          $formFieldType = 'textarea';
          break;
  
      case 'json':
      case 'jsonb':
          $formFieldType = 'textarea';
          break;
  
      case 'enum':
      case 'set':
          $formFieldType = 'select';
          break;
  
      case 'date':
          $formFieldType = 'date';
          break;
  
      case 'dateTime':
      case 'dateTimeTz':
      case 'timestamp':
      case 'timestampTz':
      case 'timestamps':
      case 'timestampsTz':
      case 'nullableTimestamps':
          $formFieldType = 'datetime-local';
          break;
  
      case 'time':
      case 'timeTz':
          $formFieldType = 'time';
          break;
  
      case 'year':
          $formFieldType = 'year';
          break;
  
      case 'binary':
          $formFieldType = 'file';
          break;
  
      case 'boolean':
          $formFieldType = 'checkbox';
          break;
  
      case 'geometry':
      case 'geometryCollection':
      case 'lineString':
      case 'multiLineString':
      case 'multiPoint':
      case 'multiPolygon':
      case 'point':
      case 'polygon':
          $formFieldType = 'textarea';
          break;
  
      case 'rememberToken':
      case 'uuid':
      case 'uuidMorphs':
      case 'nullableMorphs':
      case 'nullableUuidMorphs':
          $formFieldType = 'hidden';
          break;
    }

    return $formFieldType;
  }

  protected function setFormFieldAttributes($field, $fields, $formFieldType){
    
    $fieldOptions = $fields[$field]['options'];
    $fieldValues = $fields[$field]['values'];

    $formFieldAttributes = [];

    foreach ($fieldOptions as $fieldOption) {
      if($fieldOption === 'nullable'){
        $formFieldAttributes['required'] = true;
      }

      if($fieldOption === 'default'){
        $formFieldAttributes['value'] = $fieldValues[$fieldOption];
      }
    }

    switch($formFieldType){

      case 'text':
      case 'textarea':
      case 'password':
      case 'email':
      case 'url':
      case 'color':

        $customAttributes = $this->choice(
          "¿Qué atributos quieres para el input {$field} que es de tipo {$formFieldType}?: \n
          - Selecciona todas las características que quieras separando los números con comas\n
          - Selecciona ninguno si no quieres añadir características\n\n",
          ['ninguno', 'autocomplete', 'placeholder', 'maxlength', 'minlength', 'pattern', 'readonly'],
          null, 
          null,
          true 
        );

        $this->quick($customAttributes);

        $customAttributes = array_filter($fieldOptions, function($option) {
          return $option !== 'ninguno';
        });
      
        break;  

      case 'number':
      case 'range':
          
        $customAttributes = $this->choice(
          "¿Qué atributos quieres para el input {$field} que es de tipo {$formFieldType}?: \n
          - Selecciona todas las características que quieras separando los números con comas\n
          - Selecciona ninguno si no quieres añadir características\n\n",
          ['ninguno', 'autocomplete', 'placeholder', 'max', 'min', 'step', 'readonly'],
          null, 
          null,
          true 
        );

        $this->quick($customAttributes);

        $customAttributes = array_filter($fieldOptions, function($option) {
          return $option !== 'ninguno';
        });
      
        break;

      case 'select':

        $customAttributes = $this->choice(
          "¿Qué atributos quieres para el input {$field} que es de tipo {$formFieldType}?: \n
          - Selecciona todas las características que quieras separando los números con comas\n
          - Selecciona ninguno si no quieres añadir características\n\n",
          ['ninguno', 'autocomplete', 'placeholder', 'multiple', 'size', 'readonly'],
          null, 
          null,
          true 
        );

        $this->quick($customAttributes);

        $customAttributes = array_filter($fieldOptions, function($option) {
          return $option !== 'ninguno';
        });
      
        break;

      case 'checkbox':
      case 'radio':

        $customAttributes = $this->choice(
          "¿Qué atributos quieres para el input {$field} que es de tipo {$formFieldType}?: \n
          - Selecciona todas las características que quieras separando los números con comas\n
          - Selecciona ninguno si no quieres añadir características\n\n",
          ['ninguno', 'autocomplete', 'readonly'],
          null, 
          null,
          true 
        );

        $this->quick($customAttributes);

        $customAttributes = array_filter($fieldOptions, function($option) {
          return $option !== 'ninguno';
        });
      
        break;

      case 'date':
      case 'time':
      case 'datetime-local':
      case 'year':
      case 'month':
      case 'week':

        $customAttributes = $this->choice(
          "¿Qué atributos quieres para el input {$field} que es de tipo {$formFieldType}?: \n
          - Selecciona todas las características que quieras separando los números con comas\n
          - Selecciona ninguno si no quieres añadir características\n\n",
          ['ninguno', 'autocomplete', 'placeholder', 'max', 'min', 'readonly'],
          null, 
          null,
          true 
        );

        $this->quick($customAttributes);

        $customAttributes = array_filter($fieldOptions, function($option) {
          return $option !== 'ninguno';
        });
      
        break;

      case 'file':

        $customAttributes = $this->choice(
          "¿Qué atributos quieres para el input {$field} que es de tipo {$formFieldType}?: \n
          - Selecciona todas las características que quieras separando los números con comas\n
          - Selecciona ninguno si no quieres añadir características\n\n",
          ['ninguno', 'accept', 'multiple', 'readonly'],
          null, 
          null,
          true 
        );

        $this->quick($customAttributes);

        $customAttributes = array_filter($fieldOptions, function($option) {
          return $option !== 'ninguno';
        });
      
        break;
    }

    foreach ($customAttributes as $customAttribute) {
      if($customAttribute === 'autocomplete' || $customAttribute === 'readonly' || $customAttribute === 'multiple'){
        $formFieldAttributes[$customAttribute] = true;
      }else{
        $customAttributeValue = $this->ask("Valor para {$customAttribute}");
        $this->quick($customAttributeValue);
        $formFieldAttributes[$customAttribute] = $customAttributeValue;
      }
    }

    return $formFieldAttributes;
  }

  protected function formatValue($value){
    if (is_string($value)) {
      return "'" . addslashes($value) . "'";
    }

    if (is_bool($value)) {
      return $value ? 'true' : 'false';
    }

    return $value;
  }

  protected function quick($command){
    if ($command === '!q') {
      $this->info('Comando cancelado.');
      exit();
    }
  }
}
