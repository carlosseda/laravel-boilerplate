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
      $entityName = strtolower($this->argument('entityName'));
      $capitalizeEntityName = ucwords($entityName);
      $pluralEntityName = Str::plural($entityName);
      $urlName = strtolower($this->ask('¿Cuál es el nombre de la URL para ' . $entityName . '?'));
      $titleName = ucwords($urlName);

      // $this->createRoutes($urlName, $capitalizeEntityName, $entityName, $pluralEntityName);
      // $this->createController($entityName, $capitalizeEntityName);
      // $this->createView($pluralEntityName, $titleName);
      // $this->createMigration($pluralEntityName);

      // $this->createModel($name);
      // $this->createRequest($name);

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

    private function createRoutes($urlName, $capitalizeEntityName, $entityName, $pluralEntityName){
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

    protected function createMigration($pluralEntityName)
    {
      $fields = [];
      $continueAddingFields = true;

      while ($continueAddingFields) {

        $fieldName = $this->ask('Añade un nuevo nombre de campo para la tabla (deja en blanco para terminar)');

        if (empty($fieldName)) {
          $continueAddingFields = false;
          continue;
        }

        $fieldType = $this->choice(
          "Tipo de dato para {$fieldName}, escribe el número correspondiente",
          ['bigIncrements', 'bigInteger', 'binary', 'boolean', 'char', 'date', 'dateTime', 'dateTimeTz', 'decimal', 'double', 'enum', 'float', 'geometry', 'geometryCollection', 'increments', 'integer', 'ipAddress', 'json', 'jsonb', 'lineString', 'longText', 'macAddress', 'mediumIncrements', 'mediumInteger', 'mediumText', 'morphs', 'uuidMorphs', 'multiLineString', 'multiPoint', 'multiPolygon', 'nullableMorphs', 'nullableUuidMorphs', 'nullableTimestamps', 'point', 'polygon', 'rememberToken', 'set', 'smallIncrements', 'smallInteger', 'softDeletes', 'softDeletesTz', 'string', 'text', 'time', 'timeTz', 'timestamp', 'timestampTz', 'timestamps', 'timestampsTz', 'tinyIncrements', 'tinyInteger', 'unsignedBigInteger', 'unsignedDecimal', 'unsignedInteger', 'unsignedMediumInteger', 'unsignedSmallInteger', 'unsignedTinyInteger', 'uuid', 'year'], 
          null
        );

        $fieldOptions = $this->choice(
          "Características adicionales para {$fieldName} (selecciona todas las que apliquen separando los números con comas)",
          ['nullable', 'default', 'unsigned', 'autoIncrement', 'primary', 'unique', 'index', 'useCurrent', 'storedAs', 'virtualAs', 'charset', 'collation', 'encrypted', 'nullableMorphs', 'nullableUuidMorphs', 'nullableTimestamps', 'rememberToken', 'softDeletes', 'softDeletesTz', 'timestamps', 'timestampsTz'],
          null,
          null,
          true 
        );

        $fields[$fieldName] = ['type' => $fieldType, 'options' => $fieldOptions];
      }

      $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();
      $tableNames = $this->choice('¿Con qué tablas existentes está relacionada esta tabla? Escribe los números separados con comas', $tables, null, null, true);
      
      foreach ($tableNames as $tableName) {
        $fields[Str::singular($tableName) . '_id'] = ['type' => 'foreignId', 'options' => ['constrained']];
      }

      $migrationContent = $this->generateMigrationContent($pluralEntityName, $fields);

      $fileName = date('Y_m_d_His') . '_create_' . Str::snake($pluralEntityName) . '_table.php';
      $filePath = database_path('migrations/' . $fileName);
      file_put_contents($filePath, $migrationContent);

      $this->call('migrate');
    }

    protected function generateMigrationContent($pluralEntityName, $fields)
    {
        $migrationStub = "<?php\n\n";
        $migrationStub .= "use Illuminate\Database\Migrations\Migration;\nuse Illuminate\Database\Schema\Blueprint;\nuse Illuminate\Support\Facades\Schema;\n\n";
        $migrationStub .= "return new class extends Migration\n{\n";
        $migrationStub .= "\tpublic function up()\n\t{\n";
        $migrationStub .= "\t\tSchema::create('" . Str::snake($pluralEntityName) . "', function (Blueprint \$table) {\n";

        foreach ($fields as $fieldName => $fieldDetails) {
          $migrationStub .= "\t\t\t\$table->" . $fieldDetails['type'] . "('" . $fieldName . "')";
          foreach ($fieldDetails['options'] as $option) {
              $migrationStub .= "->" . $option . "()";
          }
          $migrationStub .= ";\n";
        }

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
}
