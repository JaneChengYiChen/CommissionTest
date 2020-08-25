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
        'FirstPeriodSumSheet' => "App\Exports\TestCommission\FirstPeriodSumSheet",
        'FirstPeriodDetailSheet' => "App\Exports\TestCommission\FirstPeriodDetailSheet",
        'FirstPeriodPropertySumSheet' => "App\Exports\TestCommission\FirstPeriodPropertySumSheet",
        'FirstPeriodPropertyDetailSheet' => "App\Exports\TestCommission\FirstPeriodPropertyDetailSheet",
        'DevelopSumSheet' => "App\Exports\TestCommission\DevelopSumSheet",
        'YearEndBonusSumSheet' => "App\Exports\TestCommission\YearEndBonusSumSheet",
        'YearEndBonusDetailSheet' => "App\Exports\TestCommission\YearEndBonusDetailSheet",
    ];

    public function __construct($period = null, $manCode = null)
    {
        $this->period = $period;
        $this->manCode = $manCode;
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        $sheetlist = [];

        foreach (self::$sheets as $sheetClass) {
            $sheets[] = new $sheetClass($this->period, $this->manCode);
        }
        return $sheets;
    }
}
