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
        ->table('v_generation_commissions')
        ->select(
            'gd_code',
            'gd_name',
            'or_fyc',
            'or_period'
        );
        
        if (!is_null($period)) {
            $description->where('or_period', $period);
        }

        if (!is_null($manCode)) {
            $description->where('gd_code', $manCode);
        }

        return $description->get();
    }

    public function detail($period, $manCode)
    {
        $description = $this->core
        ->table('v_generation_commission_details')
        ->select(
            'gd_code',
            'gd_name',
            'period',
            'sales_code',
            'sales_name',
            'fyb',
            'gd_get_rate',
            'gd_gain_from_sales'
        );
        
        if (!is_null($period)) {
            $description->where('period', $period);
        }

        if (!is_null($manCode)) {
            $description->where('gd_code', $manCode);
        }

        return $description->get();
    }
}
