<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TestCommission\TestCommissionDataExport;
use Mail;
use Illuminate\Support\Facades\Storage;
use File;

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

    protected $mailingChance = 10;
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
        // echo vaR_dump(env('_DB_CONNECTION'));
        // exit;
          
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

        1. 首期佣金(排除產險)：
           -- ct = 5
           -- BCode = 5360
        
        2.首期佣金(產險)：
          -- ct = 5
          -- BCode = 5382, 5379
        
        3.直展獎金(首佣)：
          -- ct = 5
          -- BCode = 5360
        
        4.年終獎金：
          -- ct = 73
          -- BCode = 5385
        
        5.續期佣金：
          -- ct = 5
          -- BCode = 5370
        
        6.繼續率獎金：
          -- ct = 53
          -- BCode = 5387, 5388, 5389
        
        7.系統獎金(首佣)：
          -- ct = 5
          -- BCode = 5360
        
        8.系統獎金(續佣)：
          -- ct = 5
          -- Xcode = 5370
        
        9.系統獎金(繼續率)：
          -- ct = 53
          -- BCode = 5387, 5388, 5389
        
        10.代數獎金(首佣)：
          -- ct = 5
          -- BCode = 5360
        
        11.推薦獎金(首佣)：
          -- ct = 5
          -- BCode = 5360";


        $zip_path = $this->zip_path;
        set_time_limit(300);
        try {
            Mail::raw($content, function ($message) use ($zip_path) {
                $message->to(env("ST_COMMISSION_To"))
                ->cc(env("ST_COMMISSION_CC"))
                ->subject('st_佣金#此封調整年終%數')
                ->attach($zip_path);
            });
        } catch (\Exception $e) {
            $this->chanceCounter($e);
        }
    }

    private function chanceCounter($e)
    {
        if ($this->mailingChance === 0) {
            return;
        }
        sleep(5);
        $this->log($e->getMessage());
        $this->mailingChance = $this->mailingChance-1;
        $this->mailing();
    }

    private function unlinkFilePath()
    {
        File::delete($this->zip_path);
        File::delete($this->pathToFile);
    }

    private function log($msg)
    {
        $today = date('Ymd');
        $log_file_path = storage_path("logs/commission_{$today}.log");

        $log_info = [
            'date' => date('Y-m-d H:i:s'),
            'msg' => $msg,
        ];

        $log_info_json = json_encode($log_info) . "\r\n";
        File::append($log_file_path, $log_info_json);
    }
}
