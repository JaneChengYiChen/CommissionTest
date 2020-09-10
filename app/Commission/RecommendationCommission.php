<?php

namespace App\Commission;

use App\Commission\CommissionDB;

class RecommendationCommission
{
    public function __construct()
    {
        $this->core = CommissionDB::dbInit(CommissionDB::ST_CORE);
    }

    public function sum($period, $manCode, $periodRange)
    {
        $description = $this->core
        ->table('v_recommendation_commission')
        ->select(
            'man_code',
            'man_name',
            'period',
            'mentoring_or_fyc',
            'recommending_or_fyc',
            'or_fyc'
        );
        
        if (!is_null($period)) {
            $description->where('period', $period);
        }

        if (!is_null($manCode)) {
            $description->where('man_code', $manCode);
        }

        if (!empty($periodRange)) {
            $description->whereBetween('period', $periodRange);
        }

        return $description->get();
    }

    public function detail($period, $manCode, $periodRange)
    {
        $description = $this->core
        ->table('v_recommendation_commission_details')
        ->select(
            'period',
            'gd_code',
            'gd_name',
            'recommendation_gdcode',
            'recommendation_name',
            'sales_code',
            'sales_name',
            'fyb',
            'mentor_gd_get_rate',
            'mentor_gd_gain_from_sales',
            'recommendation_gd_get_rate',
            'recommendation_gd_gain_from_sales'
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
