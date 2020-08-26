<?php
namespace App\Exports\TestCommission;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Commission\CommissionDB;
use App\Commission\GenerationCommission;

class GenerationSumSheet implements WithTitle, WithHeadings, ShouldAutoSize, FromCollection, WithMapping
{

    public function __construct($period, $manCode)
    {
        $this->period = $period;
        $this->manCode = $manCode;
    }

    public function collection()
    {
        $QueryCollection = new GenerationCommission;
        $data = $QueryCollection->sum($this->period, $this->manCode);
        
        return $data;
    }

    public function headings(): array
    {
        return [
            [
                '月份',
                '人員編號',
                '人員姓名',
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
        return '代數佣金總和';
    }

    /**
     * sheet 表內容
     * @return array
     */
    public function map($table): array
    {

        return [
            $table->or_period,
            $table->gdcode,
            $table->gdname,
            $table->or_fyc,
        ];
    }
}
