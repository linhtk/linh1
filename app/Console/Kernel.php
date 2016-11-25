<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Jobs\ImportCampaignData;
use App\Jobs\BatchReport;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\File;

class Kernel extends ConsoleKernel
{
    use DispatchesJobs;
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        Commands\BatchReport::class
    ];

    protected $prepare_directory;
    protected $process_directory;
    protected $complete_directory;
    protected $banner_directory;

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        // add job to queue every 5 minutes
        $filePath = storage_path().'/logs/schedule.log';
        $schedule->call(function () {
            try{
                $this->prepare_directory = storage_path().'/civi_data/download/';
                $this->process_directory = storage_path().'/civi_data/process/';
                $this->complete_directory = storage_path().'/civi_data/imported/';
                $this->banner_directory = public_path().'/banner/';

                $this->checkFolder();

                // check file json
                $listDirectories = scandir($this->prepare_directory);
                if(!empty($listDirectories)){
                    // get file name
                    $folder_name = end($listDirectories);

                    // if not exists file in process and complete folder, we add job to queue
                    if(!File::exists($this->process_directory.$folder_name) && !File::exists($this->complete_directory.$folder_name)){
                        $this->dispatch(new ImportCampaignData( $folder_name ));
                    }
                }
            }catch (\Exception $e) {
                echo $e->getMessage();
            }
        })->name('import-campaigns')->everyMinute()->withoutOverlapping()->sendOutputTo($filePath);;

        $schedule->call(function () {

            $month = date("m", strtotime('-1 months'));
            $year = date("Y", strtotime('-1 months'));

            $this->dispatch(new BatchReport( $month, $year ));
        })->monthlyOn(1, '00:00');
    }

    private function checkFolder(){
        try{
            if(!File::exists($this->prepare_directory)){
                File::makeDirectory($this->prepare_directory, 0755, true, true);
            }

            if(!File::exists($this->process_directory)){
                File::makeDirectory($this->process_directory, 0755, true, true);
            }

            if(!File::exists($this->complete_directory)){
                File::makeDirectory($this->complete_directory, 0755, true, true);
            }

            if(!File::exists($this->banner_directory)){
                File::makeDirectory($this->banner_directory, 0777, true, true);
            }
        }catch (\Exception $e) {
            throw $e;
        }

    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
