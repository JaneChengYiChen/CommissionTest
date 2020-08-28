<?php

namespace App\Commission;

use App\Commission\CommissionDB;

class RatioCommission
{
    public function __construct()
    {
        $this->core = CommissionDB::dbInit(CommissionDB::ST_CORE);
    }

    public function mentoringRatio($manCode)
    {
        $description = $this->core
        ->table('v_mentoring_ratios')
        ->select(
            'man_code',
            'man_name',
            'man_rate',
            'gd_code',
            'gd_name',
            'LV',
            'gd_rate',
            'gd_get_rate'
        );

        ### 目前驗證中：先全部開放
        // if (!is_null($manCode)) {
        //     $description->where('GDCode', $manCode);
        // }

        return $description->get();
    }

    public function mentoringPropertyRatio($manCode)
    {
        $description = $this->core
        ->table('v_property_insurance_mentoring_ratios')
        ->select(
            'man_code',
            'man_name',
            'man_title',
            'self_rate',
            'gd_code',
            'gd_name',
            'LV',
            'gd_title',
            'gd_get_rate'
        );

        ### 目前驗證中：先全部開放
        // if (!is_null($manCode)) {
        //     $description->where('GDCode', $manCode);
        // }

        return $description->get();
    }

    public function recommendationRatio($manCode)
    {
        $description = $this->core
        ->table('v_recommendation_ratios')
        ->select(
            'man_code',
            'man_name',
            'man_title',
            'gd_code',
            'gd_name',
            'LV',
            'gd_title',
            'gd_get_rate'
        );

        ### 目前驗證中：先全部開放
        // if (!is_null($manCode)) {
        //     $description->where('GDCode', $manCode);
        // }

        return $description->get();
    }

    public function recommendationGenerationRatio($manCode)
    {
        $description = $this->core
        ->table('v_recommendation_generation_ratios')
        ->select(
            'man_code',
            'man_name',
            'man_title',
            'gd_code',
            'gd_name',
            'LV',
            'gd_title',
            'gd_get_rate'
        );

        ### 目前驗證中：先全部開放
        // if (!is_null($manCode)) {
        //     $description->where('GDCode', $manCode);
        // }

        return $description->get();
    }
}
