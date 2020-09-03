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

class RecommendationDevelopRatioSheet implements WithTitle, WithHeadings, ShouldAutoSize, FromCollection, WithMapping
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
        $data = $QueryCollection->recommendationDevelopRatio($this->manCode);
        
        return $data;
    }

    public function headings(): array
    {
        return [
            [
                '原始人員編號',
                '原始人員姓名',
                '原始人員K值',
                '輔導人員編號',
                '輔導人員姓名',
                '上幾層',
                '輔導人員K值',
                '輔導人員可從原始人員拿到%數',
                '輔導人員需扣除的推薦獎金%數',
                '推薦人員編號',
                '推薦人員姓名',
                '推薦人員可得推薦獎金％數',
                '輔導人與推薦人是否不一致（是：1, 不是：0）'
            ],
        ];
    }

    /**
     * sheet 表名稱
     * @return string
     */
    public function title(): string
    {
        return '推薦獎金關係圖';
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
            $table->mentor_gd_get_rate,
            $table->recommendation_gdcode,
            $table->recommendation_name,
            $table->recommendation_gd_get_rate,
            $table->need_to_change,
        ];
    }
}
