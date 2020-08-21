<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Commission\FirstYearCommission;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TestCommission\TestCommissionDataExport;

class StCommision extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'st:commission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testing Commiossion Counting';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $fileName = 'st_commission.xlsx';
        Excel::store(new TestCommissionDataExport(), $fileName, 'tmp');
        echo 'scuess!';
    }
}
