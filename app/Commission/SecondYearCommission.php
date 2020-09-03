<?php

namespace App\Commission;

use App\Commission\CommissionDB;

class SecondYearCommission
{
    public function __construct()
    {
        $this->core = CommissionDB::dbInit(CommissionDB::ST_CORE);
    }

    public function sum($period, $manCode, $periodRange)
    {
        $description = $this->core
        ->table('v_second_year_commissions')
        ->select(
            'man_code',
            'man_name',
            'direct_period',
            'direct_fyb',
            'direct_rate',
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

        if (!empty($periodRange)) {
            $description->whereBetween('direct_period', $periodRange)
                        ->orwhereBetween('or_period', $periodRange);
        }

        return $description->get();
    }

    public function detail($period, $manCode, $periodRange)
    {
        $description = $this->core
        ->table('v_second_year_commission_details')
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

        if (!empty($periodRange)) {
            $description->whereBetween('period', $periodRange);
        }

        return $description->get();
    }
}
