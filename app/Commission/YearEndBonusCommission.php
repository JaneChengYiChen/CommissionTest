<?php

namespace App\Commission;

use App\Commission\CommissionDB;

class YearEndBonusCommission
{
    public function __construct()
    {
        $this->core = CommissionDB::dbInit(CommissionDB::ST_CORE);
    }

    public function sum($period, $manCode)
    {
        $description = $this->core
        ->table('v_year_end_bonus_commissions')
        ->select(
            'man_code',
            'man_name',
            'direct_period',
            'direct_fyb',
            'direct_fyrate',
            'year_end_bonus',
            'or_period',
            'or_year_end_bonus'
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

    public function detail($period, $manCode)
    {
        $description = $this->core
        ->table('v_year_end_bonus_commission_details')
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
