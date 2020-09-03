<?php

namespace App\Commission;

use App\Commission\CommissionDB;

class DevelopCommission
{
    public function __construct()
    {
        $this->core = CommissionDB::dbInit(CommissionDB::ST_CORE);
    }

    public function sum($period, $manCode, $periodRange)
    {
        $description = $this->core
        ->table('v_develop_commissions')
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

        if (!is_null($periodRange)) {
            $description->whereBetween('period', $periodRange);
        }

        return $description->get();
    }
}
