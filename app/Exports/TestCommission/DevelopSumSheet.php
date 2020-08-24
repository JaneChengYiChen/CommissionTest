<?php
namespace App\Exports\TestCommission;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Commission\CommissionDB;
use App\Commission\DevelopCommission;

class DevelopSumSheet implements WithTitle, WithHeadings, ShouldAutoSize, FromCollection, WithMapping
{

    public function __construct($period, $manCode)
    {
        $this->period = $period;
        $this->manCode = $manCode;
    }

    public function collection()
    {
        $QueryCollection = new DevelopCommission;
        $data = $QueryCollection->sum($this->period, $this->manCode);
        
        return $data;
    }

    public function headings(): array
    {
        return [
            [
                '人員編號',
                '人員姓名',
                '佣金',
                '直展佣金比率',
                '直展佣金月份'
            ],
        ];
    }

    /**
     * sheet 表名稱
     * @return string
     */
    public function title(): string
    {
        return '直展佣金總和';
    }

    /**
     * sheet 表內容
     * @return array
     */
    public function map($table): array
    {

        return [
            $table->man_code,
            $table->man_name,
            $table->fyb,
            $table->straight_fyc,
            $table->period,
        ];
    }
}