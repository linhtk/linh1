<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Campaigns extends Model{

    protected $table = 'campaigns';
    protected $fillable = ['advertiser_id', 'promotion_id', 'advertiser_name',
        'promotion_name', 'category_id', 'detail_media', 'detail_enduser',
        'certificate_condition', 'condition_reward',
        'banner_id','image_filename',
        'start_time', 'delete_flag'];

    public static function getCampaigns( $type = 0, $limit = 4 ){
       $date_now = date('Y-m-d H:i:s');
    	 return DB::table('campaign_promotes')
              ->leftJoin('thanks', 'campaign_promotes.id_thanks', '=', 'thanks.id')
              ->leftJoin('campaigns', 'thanks.campaign_id', '=', 'campaigns.id')
   				    ->select('campaigns.id as campaigns_id', 'promotion_name', 'detail_enduser', 'image_filename', 'id_thanks', 'thanks_type', 'normal_price')
   				    ->where('campaign_promotes.type', '=', $type)
              ->where('thanks.delete_flag', '=', 0)
              ->where('campaigns.delete_flag', '=', 0)
              ->where('start_time', '<=', $date_now)
              ->where( function($query) use ($date_now){ $query->where('end_time', '=', NULL)->orwhere('end_time', '>=', $date_now); })
   				    ->orderBy('order', 'desc')
              ->limit($limit)
   				    ->get();
    }

    public static function searchCampaigns( $keyword = '', $number_page_paginate = 10 ){
    	 return DB::table('campaigns')->leftJoin('thanks', 'campaigns.id', '=', 'thanks.campaign_id')
        ->select('campaigns.id as c_id', 'promotion_name', 'detail_enduser', 'image_filename', 'thanks.id as thanks_id', 'thanks_type', 'normal_price')
        ->whereRaw("MATCH(advertiser_name, promotion_name, detail_enduser) AGAINST(?)", array($keyword))
        ->where('thanks.delete_flag', '=', 0)
        ->where('campaigns.delete_flag', '=', 0)
        ->where( function($query) use ($date_now){ $query->where('end_time', '=', NULL)->orwhere('end_time', '>=', $date_now);})
    	 	->paginate($number_page_paginate);
    }

    public static function getDetailCampaigns( $id = 0, $date_now ){
    	 return DB::table('campaigns')->leftJoin('thanks', 'campaigns.id', '=', 'thanks.campaign_id')
        ->select('thanks.id as thanks_id', 'promotion_name', 'detail_enduser', 'image_filename', 'condition_reward', 'detail_media', 'certificate_condition', 'start_time', 'end_time', 'thanks_type', 'normal_price', 'category_id')
        ->where('thanks.id', '=', $id)
        ->where('thanks.delete_flag', '=', 0)
        ->where('campaigns.delete_flag', '=', 0)
        ->where( function($query) use ($date_now){ $query->where('end_time', '=', NULL)->orwhere('end_time', '>=', $date_now); })
        ->get();
    }
    /*
     * author:ThanhDV
     * date:2016-10-20
     * description:get infor thank,campaign
     */
    public static function getInfoThankCampaign($campaign_id = '',$thank_id = '' ){
        $now = date('Y-m-d H:i:s');
        return DB::table('campaigns')->leftJoin('thanks', 'campaigns.id', '=', 'thanks.campaign_id')
            ->select('advertiser_id', 'banner_id','advertiser_name', 'promotion_name', 'category_id', 'detail_media', 'detail_enduser', 'certificate_condition', 'condition_reward', 'image_filename', 'start_time', 'end_time', 'campaigns.delete_flag as c_delete_flag', 'thanks.id as t_id', 'campaign_id','thanks.promotion_id as t_promotion_id', 'thanks_id', 'thanks_name', 'thanks_type', 'normal_price', 'special_price', 'thanks.delete_flag as c_delete_flag')
            ->where('campaigns.id', '=', $campaign_id)
            ->where('thanks.id', '=', $thank_id)
            ->where('thanks.delete_flag', '=', 0)
            ->where('campaigns.delete_flag', '=', 0)
            ->where('start_time', '<=',$now)
            ->where(function($query) use($now)
            {
                $query->where('end_time', '=',NUll)
                    ->orWhere('end_time', '>=', $now);
            })
            ->get();
    }
    /*
     * author:ThanhDV
     * date:2016-10-20
     * description:get info campaign promote
     */
    public static function getInfoCampaignPromote($type = 0, $limit = 4 ) {
        $now = date('Y-m-d H:i:s');
        return DB::table('campaign_promotes')
            ->leftJoin('campaigns', 'campaign_promotes.campaign_id', '=', 'campaigns.id')
            ->select( 'campaign_id','id_thanks', 'type','order','campaigns.end_time as end_time','campaigns.start_time as start_time')
            ->where('type', '=', $type)
            ->where('start_time', '<=',$now)
            ->where('campaigns.delete_flag', '=', 0)
            ->where(function($query) use($now)
            {
                $query->where('end_time', '=',NUll)
                    ->orWhere('end_time', '>=', $now);
            })
            ->orderBy('order', 'desc')
            ->limit($limit)
            ->get();
    }

    /*
     * author:ThanhDV
     * date:2016-10-20
     * description:search campaign
     */
    public static function getSearchCampaigns( $keyword = '', $number_page_paginate = 10 ){
        $now = date('Y-m-d H:i:s');
        return DB::table('campaigns')->leftJoin('thanks', 'campaigns.id', '=', 'thanks.campaign_id')
            ->select('campaigns.id as campaign_id','thanks.id as t_id')
            ->whereRaw("MATCH(advertiser_name, promotion_name, detail_enduser) AGAINST(?)", array($keyword))
            ->where('thanks.delete_flag', '=', 0)
            ->where('campaigns.delete_flag', '=', 0)
            ->where('start_time', '<=',$now)
            ->where(function($query) use($now)
            {
                $query->where('end_time', '=',NUll)
                    ->orWhere('end_time', '>=', $now);
            })
            ->paginate($number_page_paginate);
    }

    /*
     * author:ThanhDV
     * date:2016-11-04
     * description:get array promotion by adv name
     */
    public static function getPromotionByAdv($adv_name = '') {
        $arr_promotion = array();
        if ($adv_name != '') {
            $results = DB::table('campaigns')
                ->select('promotion_id','advertiser_name')
                ->whereRaw("LOWER(advertiser_name) like ? ",array('%'.mb_strtolower($adv_name).'%'))
                ->get();
            if(count($results)) {
                foreach ($results as $values) {
                    $arr_promotion[$values->promotion_id] = $values->advertiser_name;
                }
            }
        }
        return $arr_promotion;
    }
    /*
     * author:ThanhDV
     * date:2016-11-04
     * description:get array adv name by adv name
     */
    public static function getAdvNameByPromotion($ar_promote = '') {
        $arr_promotion = array();
        if (!empty($ar_promote)) {
            $results = DB::table('campaigns')
                ->select('promotion_id','advertiser_name')
                ->whereIn('promotion_id', $ar_promote)
                ->get();
            if(count($results)) {
                foreach ($results as $values) {
                    $arr_promotion[$values->promotion_id] = $values->advertiser_name;
                }
            }
        }
        return $arr_promotion;
    }
}
