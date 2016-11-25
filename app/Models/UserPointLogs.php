<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class UserPointLogs extends Model
{
    protected $table = 'user_point_logs';
    protected $fillable = [
        'promotion_id', 'action_id', 'thanks_id', 'user_id', 'media_user_id',
        'accept', 'accept_time', 'action_time', 'payment_type', 'price',
        'created_at', 'updated_at'
    ];
    const   UNCONFIRM = 0;
    const   COMFIRM = 1;
    const   REJECT = 2;
    public static function searchPointFrontend($user_id = '',$start_date = '', $end_date ='', $status = '',$arr_promotions = array(), $num_page = 15) {
        $results = array();
        if($user_id != '' && $start_date != '' && $end_date != '' ) {
            $start_date = $start_date.' 00:00:00';
            $end_date = $end_date.' 23:59:59';
            $query = DB::table('user_point_logs')
                ->select('promotion_id','accept', 'price', 'accept_time', 'action_time')
                ->where('user_id', '=', $user_id)
                ->where('action_time', '>=', $start_date)
                ->where('action_time', '<=', $end_date);
            if (is_numeric($status)) {
                $query->where('accept', '=', $status);
            }
            if (!empty($arr_promotions)) {
                $query->whereIn('promotion_id', $arr_promotions);
            }
            $results = $query->paginate($num_page);
        }
        return $results;
    }

}
