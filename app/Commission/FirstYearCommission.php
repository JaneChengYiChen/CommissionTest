<?php

namespace App\Commission;

use App\Commission\CommissionDB;

class FirstYearCommission
{
    public function __construct()
    {
        $this->pks = CommissionDB::dbInit(CommissionDB::ST_PKS);
        $this->core = CommissionDB::dbInit(CommissionDB::ST_CORE);
    }

    public function main()
    {
    }

    private function getOrRate()
    {
        return $this->pks
        ->table('V_Title')
        ->select('Title', 'FYRate')
        ->get();
    }
}
