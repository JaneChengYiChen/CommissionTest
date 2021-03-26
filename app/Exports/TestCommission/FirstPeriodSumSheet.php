<?php
namespace App\Exports\TestCommission;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Commission\CommissionDB;
use App\Commission\FirstYearCommission;

class FirstPeriodSumSheet implements WithTitle, WithHeadings, ShouldAutoSize, FromCollection, WithMapping
{

    public function __construct($period, $manCode, $periodRange)
    {
        $this->period = $period;
        $this->manCode = $manCode;
        $this->periodRange = $periodRange;
    }

    public function collection()
    {
        $QueryCollection = new FirstYearCommission;
        $data = $QueryCollection->sum($this->period, $this->manCode, $this->periodRange);
        
        return $data;
    }

    public function headings(): array
    {
        return [
            [
                '月份',
                '人員編號',
                '人員姓名',
                '直接佣金',
                '組織佣金'
            ],
        ];
    }

    /**
     * sheet 表名稱
     * @return string
     */
    public function title(): string
    {
        return '首年佣金總和(排除產險)';
    }

    /**
     * sheet 表內容
     * @return array
     */
    public function map($table): array
    {

        return [
            $table->period,
            $table->man_code,
            $table->man_name,
            $table->direct_fyc,
            $table->or_fyc,
        ];
    }
}
