<?php

namespace App\Console\Commands;

use App\Helpers\CBMLog;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BatchReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'batch:payment {month} {year}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all users matching requirement exchange points';

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
     * @return mixed
     */
    public function handle()
    {
        //
        $uniqueTime = uniqid('batch_report_');
        $structure = 'batch_report';
        $bulkInsert = array();
        $packUser = array();

        $this->info('============= Start Batch Report =============');
        CBMLog::writeLog('============= Start Batch Report =============', $uniqueTime, $structure);

        DB::beginTransaction();
        try {
            // Search User Have Point >= 200k
            $this->info('Search User Have Point >= '.config('const.backend_money_limit'));
            $listUser = DB::table('users')->where('points', '>=', config('const.backend_money_limit'))->lockForUpdate()->get();

            if(count($listUser) > 0){
                $bar = $this->output->createProgressBar(count($listUser));

                foreach ( $listUser as $oneUser ){
                    $array['month'] = $this->argument('year').$this->argument('month');
                    $array['user_id'] = $oneUser->id;
                    $array['payment'] = $oneUser->points;
                    $array['created_at'] = date('Y-m-d H:i:s');
                    $array['updated_at'] = date('Y-m-d H:i:s');

                    $packUser[] = $oneUser->id;
                    $bulkInsert[] = $array;
                    $bar->advance();
                    $this->info(' ');
                }

                $this->info('Insert record to user payment logs table');
                CBMLog::writeLog('Insert record '.json_encode($bulkInsert), $uniqueTime, $structure);
                DB::table('user_payment_logs')->insert($bulkInsert);

                $this->info('Return point users to 0');
                CBMLog::writeLog('Return point to 0 with user_id :'.implode(', ',$packUser), $uniqueTime, $structure);
                DB::table('users')->whereIn('id', $packUser)->update(['points' => 0]);

            }else{
                $this->error('Can not find user matching requirement');
                CBMLog::writeLog('Can not find user matching requirement', $uniqueTime, $structure);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $this->error('Have an exception :'.$e->getMessage());
            CBMLog::writeLog('Have an exception :'.$e->getMessage(), $uniqueTime, $structure);

        }

        $this->info('============= End Batch Report =============');
        CBMLog::writeLog('============= End Batch Report =============', $uniqueTime, $structure);
    }
}
