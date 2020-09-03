<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Commission\FirstYearCommission;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TestCommission\TestCommissionDataExport;
use Mail;

class StCommision extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'st:commission {--period=null} {--mancode=null} {--periodrange=*}';

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
        $this->period = ($this->option('period') == 'null')? null : $this->option('period');
        $this->mancode = ($this->option('mancode') == 'null')? null : $this->option('mancode');
        $this->periodrange = ($this->option('periodrange') == 'null')? null : $this->option('periodrange');
        
        $this->attachment();
        $this->mailing();
        $this->unlinkFilePath();
    }

    protected function progressBarIni()
    {
        $this->progressBar = $this->output->createProgressBar(4);
        $this->progressBar->start();
    }

    private function attachment()
    {
        $fileName = "st_commission.xlsx";
        $fileNameZip = "st_commission.zip";

        ini_set("memory_limit", -1);
        Excel::store(new TestCommissionDataExport($this->period, $this->mancode, $this->periodrange), $fileName, 'tmp');
        
        $this->pathToFile = "/tmp/" . $fileName;
        $this->zip_path = "/tmp/" . $fileNameZip;
        $password = env("ST_COMMISSION");
        system("zip -P {$password} {$this->zip_path} {$this->pathToFile}");
    }

    private function mailing()
    {
        $content = "Dear all, 
        佣金如附件

        首期佣金(排除產險)：
          -- ct = 1
          -- BCode = 499
        首期佣金(產險)：
          -- ct = 1
          -- BCode = 1160, 5343
        直展獎金：
          -- ct = 1
          -- BCode = 499
        年終獎金：
          -- ct = 70
          -- BCode = 1746
        續期佣金：
          -- ct = 1
          -- BCode = 500
        繼續率獎金：
          -- ct = 50
          -- BCode = 2925, 2926, 5354
        系統獎金(首佣)：
          -- ct = 1
          -- BCode = 499
        系統獎金(續佣)：
          -- ct = 1
          -- BCode = 599
        代數獎金：
          -- ct = 1
          -- BCode = 499
        推薦獎金：
          -- ct = 1
          -- BCode = 499";


        $zip_path = $this->zip_path;
        Mail::raw($content, function ($message) use ($zip_path) {
            $message->to(env("ST_COMMISSION_To"))
                ->cc(env("ST_COMMISSION_CC"))
                ->subject('st_佣金#此封增加推薦獎金、系統獎金(續佣)')
                ->attach($zip_path);
        });
    }

    private function unlinkFilePath()
    {
        if (file_exists($this->zip_path)) {
            unlink($this->zip_path);
        }
        if (file_exists($this->pathToFile)) {
            unlink($this->pathToFile);
        }
    }
}
