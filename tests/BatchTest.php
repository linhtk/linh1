<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class BatchTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCaseNoUserMatchingRequire()
    {
        // run artisan command
        $month = 11;
        $year = 2016;

        Artisan::call('batch:payment', [
        'month' => $month, 'year' => $year
        ]);

        $listLogs = DB::table('user_payment_logs')->where('month', $year.$month)->count();

        $this->assertEquals(0, $listLogs);
    }

    public function testCaseHaveUserMatchingRequire(){

        DB::table('users')->insert(
            [
                'name' => 'phucnn',
                'password' => 'phucnn',
                'tel' => '0984104907',
                'cmt_no' => '088877878',
                'cmt_date' => '2016-09-26',
                'cmt_local' => 'ha noi',
                'address' => 'ha noi',
                'email' => 'phucnn@ai-t.vn',
                'points' => config('const.backend_money_limit')
            ]);

        // run artisan command
        $month = 11;
        $year = 2016;

        Artisan::call('batch:payment', [
            'month' => $month, 'year' => $year
        ]);

        $listLogs = DB::table('user_payment_logs')->where('month', $year.$month)->count();
        $this->assertEquals(1, $listLogs);
    }
}
