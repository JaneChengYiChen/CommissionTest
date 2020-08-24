<?php

namespace App\Commission;

use App\Commission\CommissionDB;

class DevelopCommission
{
    public function __construct()
    {
        $this->core = CommissionDB::dbInit(CommissionDB::ST_CORE);
    }

    public function sum($period, $manCode)
    {
        $description = $this->core
        ->table('v_develop_commission')
        ->select(
            'man_code',
            'man_name',
            'fyb',
            'straight_fyc',
            'period'
        );
        
        if (!is_null($period)) {
            $description->Where('period', $period);
        }

        if (!is_null($manCode)) {
            $description->where('man_code', $manCode);
        }

        return $description->get();
    }
}
