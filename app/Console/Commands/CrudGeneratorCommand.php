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
  protected $description = 'Genera un CRUD completo para una entidad.';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $this->info("Bienvenido al generador de CRUD de Laravel.\n
    Responde a las siguientes preguntas para crear un CRUD completo para tu entidad.\n 
    Puedes cancelar en cualquier momento escribiendo !q");

    $entityName = strtolower($this->argument('entityName'));
    $capitalizeEntityName = ucwords($entityName);
    $pluralEntityName = Str::plural($entityName);
    $urlName = strtolower($this->ask('¿Cuál es el nombre de la URL para ' . $entityName . '?'));
    $this->quick($urlName);
    $titleName = ucwords($urlName);

    // $this->createRoutes($urlName, $capitalizeEntityName, $entityName, $pluralEntityName);
    // $this->createController($entityName, $capitalizeEntityName);
    // $this->createView($pluralEntityName, $titleName);
    // $this->createMigration($pluralEntityName);

    // $this->createModel($name);
    // $this->createRequest($name);

    // $this->call('migrate');
    $this->info('CRUD para ' . $entityName . ' creado exitosamente.');
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

  private function createRoutes($urlName, $capitalizeEntityName, $entityName, $pluralEntityName)
  {
    $templatePath = base_path('templates/route.txt');
    $viewTemplate = file_get_contents($templatePath);

    $viewTemplate = str_replace(
      ['{{urlName}}', '{{capitalizeEntityName}}', '{{entityName}}', '{{pluralEntityName}}'],
      [$urlName, $capitalizeEntityName, $entityName, $pluralEntityName],
      $viewTemplate 
    );

    $webRoutes = file_get_contents(base_path("/routes/web.php"));
    $position = strpos($webRoutes, "Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {");
    $position += strlen("Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {");

    $webRoutes = substr_replace($webRoutes, $viewTemplate, $position, 0);

    file_put_contents(base_path("/routes/web.php"), $webRoutes);
  }

  private function createController($entityName, $capitalizeEntityName)
  {
    $templatePath = base_path('templates/controller.txt');
    $viewTemplate = file_get_contents($templatePath);

    $viewTemplate = str_replace(
      ['{{entityName}}','{{capitalizeEntityName}}'],
      [$entityName, $capitalizeEntityName],
      $viewTemplate 
    );

    file_put_contents(app_path("/Http/Controllers/Admin/{$capitalizeEntityName}Controller.php"), $viewTemplate);
  }

  protected function createMigration($pluralEntityName)
  {
    $tableRelations = $this->getTableRelations();

    foreach ($tableRelations as $tableRelation) {
      $fields[Str::singular($tableRelation) . '_id'] = ['type' => 'foreignId', 'options' => ['constrained']];
    }

    $fields = $this->addMigrationFields();

    $migrationContent = $this->generateMigrationContent($pluralEntityName, $fields);
    $fileName = date('Y_m_d_His') . '_create_' . Str::snake($pluralEntityName) . '_table.php';
    file_put_contents(database_path('migrations/' . $fileName), $migrationContent);
  }

  protected function getTableRelations()
  {
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

  protected function addMigrationFields()
  {
    $fields = [];
    $continueAddingFields = true;

    while ($continueAddingFields) {

      $fieldName = $this->ask("Añade un nuevo nombre de campo para la tabla:\n
      - Deja en blanco para terminar\n
      - id, timestamps y softDeletes se añaden automáticamente\n\n");

      $this->quick($fieldName);

      if (empty($fieldName)) {
          $continueAddingFields = false;
          continue;
      }

      $fieldType = $this->getFieldType($fieldName);
      $fieldOptions = $this->getFieldOptions($fieldName);
      $additionalValues = $this->getAdditionalValues($fieldName, $fieldOptions);

      $fields[$fieldName] = ['type' => $fieldType, 'options' => $fieldOptions, 'values' => $additionalValues];
    }

    return $fields;
  }

  protected function getFieldType($fieldName)
  {
    $fieldType = $this->choice(
      "Tipo de dato para {$fieldName}:\n 
      - Escribe el número correspondiente\n\n",
      ['bigIncrements', 'bigInteger', 'binary', 'boolean', 'char', 'date', 'dateTime', 'dateTimeTz', 'decimal', 'double', 'enum', 'float', 'geometry', 'geometryCollection', 'increments', 'integer', 'ipAddress', 'json', 'jsonb', 'lineString', 'longText', 'macAddress', 'mediumIncrements', 'mediumInteger', 'mediumText', 'morphs', 'uuidMorphs', 'multiLineString', 'multiPoint', 'multiPolygon', 'nullableMorphs', 'nullableUuidMorphs', 'nullableTimestamps', 'point', 'polygon', 'rememberToken', 'set', 'smallIncrements', 'smallInteger', 'softDeletes', 'softDeletesTz', 'string', 'text', 'time', 'timeTz', 'timestamp', 'timestampTz', 'timestamps', 'timestampsTz', 'tinyIncrements', 'tinyInteger', 'tinyText', 'unsignedBigInteger', 'unsignedDecimal', 'unsignedInteger', 'unsignedMediumInteger', 'unsignedSmallInteger', 'unsignedTinyInteger', 'uuid', 'year'], 
      null
    );

    $this->quick($fieldType);

    return $fieldType;
  }

  protected function getFieldOptions($fieldName)
  {
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
      return $option !== 'Ninguna';
    });
  }

  protected function getAdditionalValues($fieldName, $fieldOptions)
  {
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

  protected function generateMigrationContent($pluralEntityName, $fields)
  {
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

  private function createModel($name)
  {
    $templatePath = base_path('path/to/your/template/model.txt');
    $modelTemplate = file_get_contents($templatePath);

    $modelTemplate = str_replace(
      ['{{modelName}}', '{{modelNamePlural}}'],
      [$name, str_plural($name)],
      $this->getStub('Model')
    );

    file_put_contents(app_path("/Models/{$name}.php"), $modelTemplate);
  }

  protected function formatValue($value)
  {
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
