<?php

namespace App\Exports\TestCommission;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TestCommissionDataExport implements WithMultipleSheets
{
    use Exportable;

    protected $period;
    protected static $sheets = [
        'MentoringRatioSheet' => "App\Exports\TestCommission\MentoringRatioSheet",
        'MentoringPropertyRatioSheet' => "App\Exports\TestCommission\MentoringPropertyRatioSheet",
        'MentoringSecondPeriodRatioSheet' => "App\Exports\TestCommission\SecondPeriodRatioSheet",
        'MentoringContinuedRatioSheet' => "App\Exports\TestCommission\ContinuedRatioSheet",
        'RecommendationRatioSheet' => "App\Exports\TestCommission\RecommendationRatioSheet",
        'RecommendationContinuedRatioSheet' => "App\Exports\TestCommission\RecommendationContinuedRatioSheet",
        'RecommendationGenerationalRatioSheet' => "App\Exports\TestCommission\RecommendationGenerationalRatioSheet",
        'RecommendationDevelopRatioSheet' => "App\Exports\TestCommission\RecommendationDevelopRatioSheet",
        'FirstPeriodSumSheet' => "App\Exports\TestCommission\FirstPeriodSumSheet",
        'FirstPeriodDetailSheet' => "App\Exports\TestCommission\FirstPeriodDetailSheet",
        'FirstPeriodPropertySumSheet' => "App\Exports\TestCommission\FirstPeriodPropertySumSheet",
        'FirstPeriodPropertyDetailSheet' => "App\Exports\TestCommission\FirstPeriodPropertyDetailSheet",
        'DevelopSumSheet' => "App\Exports\TestCommission\DevelopSumSheet",
        'YearEndBonusSumSheet' => "App\Exports\TestCommission\YearEndBonusSumSheet",
        'YearEndBonusDetailSheet' => "App\Exports\TestCommission\YearEndBonusDetailSheet",
        'SecondPeriodSumSheet' => "App\Exports\TestCommission\SecondPeriodSumSheet",
        'SecondPeriodDetailSheet' => "App\Exports\TestCommission\SecondPeriodDetailSheet",
        'ContinuedSumSheet' => "App\Exports\TestCommission\ContinuedSumSheet",
        'ContinuedDetailSheet' => "App\Exports\TestCommission\ContinuedDetailSheet",
        'SystemSumSheet' => "App\Exports\TestCommission\SystemSumSheet",
        'SystemDetailSheet' => "App\Exports\TestCommission\SystemDetailSheet",
        'SystemSecondYearSumSheet' => "App\Exports\TestCommission\SystemSecondYearSumSheet",
        'SystemSecondYearDetailSheet' => "App\Exports\TestCommission\SystemSecondYearDetailSheet",
        'SystemContinuedSumSheet' => "App\Exports\TestCommission\SystemContinuedSumSheet",
        'SystemContinuedDetailSheet' => "App\Exports\TestCommission\SystemContinuedDetailSheet",
        'GenerationSumSheet' => "App\Exports\TestCommission\GenerationSumSheet",
        'GenerationDetailSheet' => "App\Exports\TestCommission\GenerationDetailSheet",
        'RecommendationSumSheet' => "App\Exports\TestCommission\RecommendationSumSheet",
        'RecommendationDetailSheet' => "App\Exports\TestCommission\RecommendationDetailSheet",
    ];

    public function __construct($period = null, $manCode = null, $periodrange = null)
    {
        $this->period = $period;
        $this->manCode = $manCode;
        $this->periodrange = $periodrange;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        foreach (self::$sheets as $sheetClass) {
            $sheets[] = new $sheetClass($this->period, $this->manCode, $this->periodrange);
        }
        return $sheets;
    }
}
