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
        ->table('v_mentoring_ratio')
        ->select(
            'man_code',
            'man_name',
            'man_rate',
            'GDCode',
            'gdname',
            'LV',
            'FYRate',
            'FYRateDiff'
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
        ->table('v_property_insurance_mentoring_ratio')
        ->select(
            'man_code',
            'man_name',
            'man_title',
            'self_rate',
            'GDCode',
            'gdname',
            'LV',
            'gdTitle',
            'or_rate'
        );

        ### 目前驗證中：先全部開放
        // if (!is_null($manCode)) {
        //     $description->where('GDCode', $manCode);
        // }

        return $description->get();
    }
}
