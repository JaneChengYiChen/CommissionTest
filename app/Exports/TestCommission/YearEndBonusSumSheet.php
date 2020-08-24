<?php
namespace App\Exports\TestCommission;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Commission\CommissionDB;
use App\Commission\YearEndBonusCommission;

class YearEndBonusSumSheet implements WithTitle, WithHeadings, ShouldAutoSize, FromCollection, WithMapping
{

    public function __construct($period, $manCode)
    {
        $this->period = $period;
        $this->manCode = $manCode;
    }

    public function collection()
    {
        $QueryCollection = new YearEndBonusCommission;
        $data = $QueryCollection->sum($this->period, $this->manCode);
        
        return $data;
    }

    public function headings(): array
    {
        return [
            '年終獎金月份',
            '人員編號',
            '人員姓名',
            '直接佣金',
            '組織佣金'
        ];
    }

    /**
     * sheet 表名稱
     * @return string
     */
    public function title(): string
    {
        return '年終獎金總和';
    }

    /**
     * sheet 表內容
     * @return array
     */
    public function map($table): array
    {

        return [
            $this::getPeriod($table->direct_period, $table->or_period),
            $table->man_code,
            $table->man_name,
            $table->year_end_bonus,
            $table->or_year_end_bonus,
        ];
    }

    private function getPeriod($direct_period, $or_period)
    {
        $period = $direct_period;
        if (is_null($direct_period)) {
            $period = $or_period;
        }

        return $period;
    }
}
