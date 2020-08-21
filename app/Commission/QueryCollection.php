<?php

namespace App\Commission;

use App\Commission\CommissionDB;

class QueryCollection
{
    public function __construct()
    {
        $this->pks = CommissionDB::dbInit(CommissionDB::ST_PKS);
        $this->core = CommissionDB::dbInit(CommissionDB::ST_CORE);
    }

    public function firstPeriodSum($period, $manCode)
    {
        $description = $this->core
        ->table('v_first_period_commission')
        ->select(
            'man_code',
            'man_name',
            'direct_period',
            'direct_fyb',
            'direct_fyrate',
            'direct_fyc',
            'or_period',
            'or_fyc'
        );
        
        if (!is_null($period)) {
            $description->Where(function ($query) use ($period) {
                $query->where('direct_period', $period)
                    ->Orwhere('or_period', $period);
            });
        }

        if (!is_null($manCode)) {
            $description->where('man_code', $manCode);
        }

        return $description->get();
    }

    public function firstPeriodDetail($period, $manCode)
    {
        $description = $this->core
        ->table('v_first_period_commission_details')
        ->select(
            'gdcode',
            'gdname',
            'period',
            'Man_Code',
            'sales_name',
            'fyb',
            'FYRateDiff',
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
