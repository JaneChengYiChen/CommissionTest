<?php
namespace App\Exports\TestCommission;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Commission\CommissionDB;
use App\Commission\RecommendationCommission;

class RecommendationDetailSheet implements WithTitle, WithHeadings, ShouldAutoSize, FromCollection, WithMapping
{

    public function __construct($period, $manCode, $periodRange)
    {
        $this->period = $period;
        $this->manCode = $manCode;
        $this->periodRange = $periodRange;
    }

    public function collection()
    {
        $QueryCollection = new RecommendationCommission;
        $data = $QueryCollection->detail($this->period, $this->manCode, $this->periodRange);
        
        return $data;
    }

    public function headings(): array
    {
        return [
            [
                '月份',
                '輔導人編號',
                '輔導人姓名',
                '推薦人編號',
                '推薦人姓名',
                '來源人員編號',
                '來源人員姓名',
                '來源佣金',
                '輔導人可得比率',
                '輔導人可得佣金',
                '推薦人可得比率',
                '推薦人可得佣金',
            ],
        ];
    }

    /**
     * sheet 表名稱
     * @return string
     */
    public function title(): string
    {
        return '推薦獎金明細';
    }

    /**
     * sheet 表內容
     * @return array
     */
    public function map($table): array
    {

        return [
            $table->period,
            $table->gd_code,
            $table->gd_name,
            $table->recommendation_gdcode,
            $table->recommendation_name,
            $table->sales_code,
            $table->sales_name,
            $table->fyb,
            $table->mentor_gd_get_rate,
            $table->mentor_gd_gain_from_sales,
            $table->recommendation_gd_get_rate,
            $table->recommendation_gd_gain_from_sales,
        ];
    }
}
