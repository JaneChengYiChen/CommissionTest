<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Sync\ManTree;
use App\Commission\CommissionDB;
use App\Sync\GeneralSyncEntry;
use OscarAFDev\MigrationsGenerator\Generators\FieldGenerator;
use OscarAFDev\MigrationsGenerator\Generators\SchemaGenerator;
use Way\Generators\Syntax;
use Illuminate\Support\Facades\Schema;

class SyncPKS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'syncPKS';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $Tablelists = array('pks_ManTree', 'pks_Bonus');
        // $sync = new GeneralSyncEntry($Tablelists);
        // $sync->flow();
        // exit;

        $connection = CommissionDB::dbInit(CommissionDB::ST_PKS)->getDoctrineConnection();
        $this->database = $connection->getDatabase();
        $this->schema = $connection->getSchemaManager();
        // $this->getTables = $this->schema->listTableNames();
        // $this->schema = $connection->getSchemaManager();
        // echo vaR_Dump($this->schema);
        // exit;

        $tables = 'SS_Detail'; //bonus

        $this->fieldGenerator = new FieldGenerator();
        $this->schemaGenerator = new SchemaGenerator('stPKS', null, null);
        
        //$tablesSchema= $this->generateTablesAndIndices($tables);
        $schema = $this->schemaGenerator->getFields($tables);

        $migrations = $this->fieldGenerator->generate('SS_Detail', $this->schema, $this->database, null);
        echo var_dump($migrations);
        
        Schema::connection('stCore')->create('test', function ($table) {
            $table->integer('CNO')->index('IX_ManTree');
            $table->boolean('SType')->index('IX_ManTree_3');
            $table->integer('Man_Code')->index('IX_ManTree_2');
        });
        exit;
        $this->pks = CommissionDB::dbInit(CommissionDB::ST_PKS);
        $this->core = CommissionDB::dbInit(CommissionDB::ST_CORE);
        
        $man_tree = new ManTree();
        $man_tree->truncateTable();
        
        exit;
        $table = $this->pks->table('ManTree')->get();
        
        foreach ($table as $tables) {
            // $result = json_decode(json_encode($tables, true));
            $this->core->table('pks_ManTree')->insert((array)$tables);
            echo 'ok';
            // echo vaR_Dump($tables);
            exit;
        }
        exit;
        echo var_dump($table);
        exit;
        $man_tree = new ManTree();
        $man_tree->truncateTable();

        $this->core->table('pks_ManTree')->insert($table);
    }
}
