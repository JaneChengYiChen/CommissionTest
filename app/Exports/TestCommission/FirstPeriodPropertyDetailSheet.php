<?php
namespace App\Exports\TestCommission;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Commission\CommissionDB;
use App\Commission\FirstYearPropertyCommission;

class FirstPeriodPropertyDetailSheet implements WithTitle, WithHeadings, ShouldAutoSize, FromCollection, WithMapping
{

    public function __construct($period, $manCode)
    {
        $this->period = $period;
        $this->manCode = $manCode;
    }

    public function collection()
    {
        $QueryCollection = new FirstYearPropertyCommission;
        $data = $QueryCollection->detail($this->period, $this->manCode);
        
        return $data;
    }

    public function headings(): array
    {
        return [
            [
                '月份',
                '領佣人編號',
                '領佣人姓名',
                '來源人員編號',
                '來源人員姓名',
                '來源佣金',
                '領佣人可得比率',
                '領佣人可得佣金'
            ],
        ];
    }

    /**
     * sheet 表名稱
     * @return string
     */
    public function title(): string
    {
        return '首年佣金明細(產險)';
    }

    /**
     * sheet 表內容
     * @return array
     */
    public function map($table): array
    {

        return [
            $table->period,
            $table->gdcode,
            $table->gdname,
            $table->Man_Code,
            $table->sales_name,
            $table->fyb,
            $table->FYRateDiff,
            $table->gainFromOrg
        ];
    }
}