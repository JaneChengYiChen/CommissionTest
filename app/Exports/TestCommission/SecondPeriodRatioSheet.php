<?php
namespace App\Exports\TestCommission;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Commission\CommissionDB;
use App\Commission\RatioCommission;

class SecondPeriodRatioSheet implements WithTitle, WithHeadings, ShouldAutoSize, FromCollection, WithMapping
{

    public function __construct($period, $manCode, $periodRange)
    {
        $this->period = $period;
        $this->manCode = $manCode;
        $this->periodRange = $periodRange;
    }

    public function collection()
    {
        $QueryCollection = new RatioCommission;
        $data = $QueryCollection->secondYearRatio($this->manCode);
        
        return $data;
    }

    public function headings(): array
    {
        return [
            [
                '原始人員編號',
                '原始人員姓名',
                '原始人員K值',
                '上層人員編號',
                '上層人員姓名',
                '上幾層',
                '上層人員K值',
                '上層人員可從原始人員拿到%數'
            ],
        ];
    }

    /**
     * sheet 表名稱
     * @return string
     */
    public function title(): string
    {
        return '輔導線關係圖(續年佣金)';
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
            $table->man_rate,
            $table->gd_code,
            $table->gd_name,
            $table->LV,
            $table->gd_rate,
            $table->gd_get_rate,
        ];
    }

    private function rate($rate)
    {
        return round($rate/100, 2);
    }
}
