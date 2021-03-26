<?php
namespace App\Sync;

use Illuminate\Support\Facades\Schema;
use App\Commission\CommissionDB;

class GeneralSyncEntry
{
    public function __construct($Tablelists)
    {
        $this->pks = CommissionDB::ST_PKS;
        $this->core = CommissionDB::ST_CORE;
        $this->Tablelists = $Tablelists;
    }

    public function flow()
    {
        $this->dropTable();
    }

    public function dropTable()
    {
        //從 core 刪掉原本的資料表
        $connection = new DropOriginalTable($this->core);
        $connection->dropTables($this->Tablelists);
        
        return;
    }

    public function getRemoteSchemaAndCreateTable()
    {
        //從 pks 拿 schema, 放到 core 裡面
        $connection = new DropOriginalTable(CommissionDB::ST_PKS, CommissionDB::ST_CORE);
        $connection->dropTables($dropTablelists);
        return;
    }
}
