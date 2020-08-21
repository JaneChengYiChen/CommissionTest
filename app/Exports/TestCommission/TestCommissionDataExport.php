<?php

namespace App\Exports\TestCommission;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\TestCommission\FirstPeriodSumSheet;

class TestCommissionDataExport implements WithMultipleSheets
{
    use Exportable;

    protected $period;

    public function __construct(int $period, int $manCode = null)
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

        $sheets[] = new FirstPeriodSumSheet($this->period, $this->manCode);
        // for ($month = 1; $month <= 12; $month++) {
        //     //不同的資料可以呼叫不同的方法
        //     $sheets[] = new UserPerMonthSheet($this->year, $month);
        // }
        return $sheets;
    }
}
