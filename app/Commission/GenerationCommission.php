<?php

namespace App\Commission;

use App\Commission\CommissionDB;

class GenerationCommission
{
    public function __construct()
    {
        $this->core = CommissionDB::dbInit(CommissionDB::ST_CORE);
    }

    public function sum($period, $manCode)
    {
        $description = $this->core
        ->table('v_generation_commission')
        ->select(
            'gdcode',
            'gdname',
            'or_fyc',
            'or_period'
        );
        
        if (!is_null($period)) {
            $description->where('or_period', $period);
        }

        if (!is_null($manCode)) {
            $description->where('gdcode', $manCode);
        }

        return $description->get();
    }

    public function detail($period, $manCode)
    {
        $description = $this->core
        ->table('v_generation_commission_details')
        ->select(
            'gdcode',
            'gdname',
            'period',
            'Man_Code',
            'sales_name',
            'fyb',
            'or_rate',
            'gainFromOrg'
        );
        
        if (!is_null($period)) {
            $description->where('period', $period);
        }

        if (!is_null($manCode)) {
            $description->where('gdcode', $manCode);
        }

        return $description->get();
    }
}
