<?php
namespace App\Sync;

use Illuminate\Support\Facades\Schema;
use OscarAFDev\MigrationsGenerator\Generators\FieldGenerator;
use OscarAFDev\MigrationsGenerator\Generators\SchemaGenerator;

class SchemaCreator
{
    public function __construnct($fromConnection, $toConnection)
    {
        $this->fromConnection = $fromConnection;
        $this->toConnection = $toConnection;
    }

    public function getSchema($tables)
    {
        // $tables = 'ManTree';
        
        $this->fieldGenerator = new FieldGenerator();
        $this->schemaGenerator = new SchemaGenerator($this->fromConnection, null, null);

        $table2 = $this->schemaGenerator->getFields($tables);
        echo var_dump($table2);
        
        Schema::connection('stCore')->create('test', function ($table) {
            $table->integer('CNO')->index('IX_ManTree');
            $table->smallInteger('SType')->index('IX_ManTree_3');
            $table->integer('Man_Code')->index('IX_ManTree_2');
        });
    }

    private function createSchema()
    {

    }


    protected function addDecorators($decorators)
    {
        $output = '';

        foreach ($decorators as $decorator) {
            $output .= sprintf("->%s", $decorator);

            if (strpos($decorator, '(') === false) {
                $output .= '()';
            }
        }
        return $output;
    }
}