<?php
namespace App\Exports\TestCommission;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Commission\CommissionDB;
use App\Commission\QueryCollection;

class FirstPeriodSumSheet implements WithTitle, WithHeadings, ShouldAutoSize, FromCollection
{

    public function __construct(int $period, int $manCode)
    {
        $this->pks = CommissionDB::dbInit(CommissionDB::ST_PKS);
        $this->period = $period;
        $this->manCode = $manCode;
    }

    public function collection()
    {
        $data = $this->pks->select(
            $this->pks->raw(QueryCollection::firstPeriodSum($this->period, $this->manCode))
        );

        return collect($data);
    }

    public function headings(): array
    {
        return [
            [
                '人員編號',
                '人員佣金',
                '比率',
                '人員fyc'
            ],
        ];
    }

    /**
     * sheet 表名稱
     * @return string
     */
    public function title(): string
    {
        return '首年佣金總和';
    }

    // /**
    //  * sheet 表內容
    //  * @return array
    //  */
    // public function map($table): array
    // {

    //     return [
    //         $table->Title,
    //         $table->FYRate
    //     ];
    // }
}
