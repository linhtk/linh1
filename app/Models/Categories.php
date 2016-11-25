<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Categories extends Model
{
	public static function getAll(){
    	 return Categories::where('status', 1)->orderBy('order', 'desc')->get();
    }

    public static function getCampaignsById( $id = 0, $number_page_paginate){
    	 return DB::table('campaigns')->leftJoin('thanks', 'campaigns.id', '=', 'thanks.campaign_id')
    	 	->select('campaigns.id', 'promotion_name', 'detail_enduser', 'image_filename', 'thanks.id as thanks_id', 'thanks_type', 'normal_price')
    	 	->where('category_id', '=', $id)
    	 	->where('thanks.delete_flag', '=', 0)
    	 	->paginate($number_page_paginate);
    }
    /*
     * author:ThanhDV
     * date:2016-10-24
     * description:get info by category_id
     */
    public static function getInfoByCategoryId( $id = 0, $number_page_paginate){
        $now = date('Y-m-d H:i:s');
        return DB::table('campaigns')->leftJoin('thanks', 'campaigns.id', '=', 'thanks.campaign_id')
            ->select('campaign_id', 'thanks.id as t_id')
            ->where('category_id', '=', $id)
            ->where('thanks.delete_flag', '=', 0)
            ->where('start_time', '<=',$now)
            ->where(function($query) use($now)
            {
                $query->where('end_time', '=',NUll)
                    ->orWhere('end_time', '>=', $now);
            })
            ->paginate($number_page_paginate);
    }
}
