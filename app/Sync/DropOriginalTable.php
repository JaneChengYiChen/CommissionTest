<?php
namespace App\Sync;

use Illuminate\Support\Facades\Schema;

class DropOriginalTable
{
    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    public function dropTables($tables)
    {
        foreach ($tables as $oneTable) {
            try {
                Schema::connection($this->connection)->drop($oneTable);
            } catch (\Exception $e) {
                ##TODO
            }
        }
    }
}
