<?php

namespace App\Jobs;

use App\Helpers\CBMLog;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class BatchReport implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $month;

    protected $year;

    /**
     * BatchReport constructor.
     * @param $month
     * @param $year
     */
    public function __construct($month, $year)
    {
        //
        $this->month = $month;
        $this->year = $year;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $uniqueTime = uniqid('batch_report_');
        $structure = 'batch_report';
        $bulkInsert = array();
        $packUser = array();

        CBMLog::writeLog('============= Start Batch Report =============', $uniqueTime, $structure);

        DB::beginTransaction();
        try {
            // Search User Have Point >= 200k
            $listUser = DB::table('users')->where('points', '>=', config('const.backend_money_limit'))->lockForUpdate()->get();

            foreach ( $listUser as $oneUser ){
                $array['month'] = $this->year.$this->month;
                $array['user_id'] = $oneUser->id;
                $array['payment'] = $oneUser->points;
                $array['created_at'] = date('Y-m-d H:i:s');
                $array['updated_at'] = date('Y-m-d H:i:s');
                
                $packUser[] = $oneUser->id;
                $bulkInsert[] = $array;
            }

            if(!empty($bulkInsert)){
                CBMLog::writeLog('Insert record '.json_encode($bulkInsert), $uniqueTime, $structure);
                DB::table('user_payment_logs')->insert($bulkInsert);

                CBMLog::writeLog('Return point to 0 with user_id :'.implode(', ',$packUser), $uniqueTime, $structure);
                DB::table('users')->whereIn('id', $packUser)->update(['points' => 0]);
            }else{
                CBMLog::writeLog('Can not find user matching requirement', $uniqueTime, $structure);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            CBMLog::writeLog('Have an exception :'.$e->getMessage(), $uniqueTime, $structure);

        }

        CBMLog::writeLog('============= End Batch Report =============', $uniqueTime, $structure);
        $this->delete();

    }

    public function failed(\Exception $exception)
    {
        // Send user notification of failure, etc...
    }
}
