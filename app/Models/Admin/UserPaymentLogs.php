<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use DB;

class UserPaymentLogs extends Model
{
    const   NO_PAY = 0;
    const   PAYED = 1;
    const   SUSPEND = 2;
    /*
     * author:Thanhdv
     * date:2016-10-11
     * description:search payment manager backend
     */
    public static function searchPayments( $month = '',$status='',$money = 200, $number_page_paginate = 15,$data = array() ){
        $results = array();
        if ($month != '') {
            $user_id = isset($data['user_id']) ? trim($data['user_id']) : '';
            $name = isset($data['name']) ? trim($data['name']) : '';
            $email = isset($data['email']) ? trim($data['email']) : '';


            $query = DB::table('user_payment_logs')->join('users', 'users.id', '=', 'user_payment_logs.user_id')
                    ->select('user_payment_logs.id as p_id', 'month', 'user_id', 'admin_id', 'payment',
                    'user_payment_logs.payment_status as p_status', 'payment_time', 'del_flag', 'name', 'email',
                    'users.status as u_status','bank_name','bank_branch_name','bank_account_number')
                   ->where('payment', '>=', $money)
                   ->where('month', '=', $month);
            if (is_numeric($status)) {
                $query->where('user_payment_logs.payment_status', '=', $status);
            }
            if ($user_id != '') {
                $query->where('users.id', '=', $user_id);
            }
            if ($name != '') {
                $query->whereRaw("LOWER(users.name) like ? ",array('%'.mb_strtolower($name).'%'));
            }
            if ($email != '') {
                $query->where('users.email', '=', $email);
            }

                $query->orderBy('month', 'asc');

        $results = $query->paginate($number_page_paginate);
        }
        return $results;
    }
    /*
     * author:Thanhdv
     * date:2016-11-03
     * description:search payment log frontend
     */
    public static function searchPaymentFrontend( $user_id ='',$start_date = 0,$end_date= 0,$money = 200000, $number_page_paginate = 15 ){
        $results = array();
        if ($user_id != '' && $start_date > 0 && $end_date > 0) {
            $query = DB::table('user_payment_logs')
                ->select('id', 'month', 'user_id', 'payment', 'admin_id', 'payment_status', 'payment_time', 'del_flag')
                ->where('user_id', '=', $user_id)
                ->where('payment', '>=', $money)
                ->where('month', '>=', $start_date)
                ->where('month', '<=', $end_date)
                ->orderBy('month', 'asc');
            $results = $query->paginate($number_page_paginate);
        }
        return $results;
    }
}
