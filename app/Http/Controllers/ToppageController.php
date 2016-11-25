<?php
namespace App\Http\Controllers;
use App\Models\ClickLogs;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Utils;
use Cache;
use App\Models\Campaigns;
use App\Models\Categories;

class ToppageController extends Controller{
    protected $user;

    public function __construct(){
        $this->middleware(function ($request, $next) {
            if ( Auth::check() ) {
                $this->user['name'] = Auth::user()->name;
                $this->user['point'] = Auth::user()->points;
            }
            return $next($request);
        });
    }
  
    public function index(){
      	$minutes = config('const.time_expire_memcached');
    	$categories = parent::getCategory($minutes);
   		$carousels = parent::getCarousels($minutes);        
        //Thanhdv 2016-10-20 load spotLight        
        $config_spotlight = config('const.key_spotLights');
        $type_spotlight = config('const.type_spotLights');
        $limit_spotlight = config('const.number_page_spotLights');
        if (Cache::has($config_spotlight)) {
            $data_promote = Cache::get($config_spotlight);
        } else {
            $data_promote = Campaigns::getInfoCampaignPromote($type_spotlight,$limit_spotlight);
        }
        $spotLights = $this->checkSaveStoreTopPage($data_promote,$config_spotlight,$minutes);
        //Thanhdv 2016-10-20 load recommended       
        $config_recommends = config('const.key_recommends');
        $type_recommends = config('const.type_recommends');
        $limit_recommends = config('const.number_page_recommends');
        if (Cache::has($config_recommends)) {
            $data_promote_recommnend = Cache::get($config_recommends);
        } else {
            $data_promote_recommnend = Campaigns::getInfoCampaignPromote($type_recommends,$limit_recommends);
        }
        $recommends = $this->checkSaveStoreTopPage($data_promote_recommnend,$config_recommends,$minutes);


		return  view('toppage.home')->with( [ 'categories' => $categories, 'carousels' => $carousels, 'spotLights'=>$spotLights, 'recommends' => $recommends, 'user' => $this->user ]);
	}

	public function category($id){
    	$minutes = config('const.time_expire_memcached');
    	$categories = parent::getCategory($minutes);
        if(is_numeric($id)){
           // $campaigns = Categories::getCampaignsById($id, config('const.number_page_paginate'));
            //Thanhdv 2016-10-24 list campaign by category_id
            $id = intval($id);
            $pre_list_category = config('const.pre_list_category');
            $config_list_category = $pre_list_category.'_'.$id;
            $campaigns = Categories::getInfoByCategoryId($id, config('const.number_page_paginate'));

            if (count($campaigns) > 0) {
                foreach ($campaigns as $key=> $values) {
                    $campaign_id = intval($values->campaign_id);
                    $thank_id = intval($values->t_id);
                    //get data campaign thank
                    $data = $this->checkGetDataCampaignThank($campaign_id,$thank_id);
                    if(count($data) > 0) {
                        $campaigns[$key] = $data[0];
                    } else {
                        unset($campaigns[$key]);
                    }

                }
            }

        }else{
            $campaigns = array();
            return redirect('/');
        }
        $category_name = '';
        if ( count($categories) > 0 ) {
            foreach($categories as $category) {
                if( $id == $category->id ){
                    $category_name = $category->category_vn;
                    break;
                }
            }
        }
		return  view('toppage.category')->with( [ 'categories' => $categories, 'user' => $this->user, 'campaigns' => $campaigns, 'caterogy_id' => $id, 'category_name' => $category_name, 'title_page' =>  $category_name ]);
	}


	public function detail(Request $request){

        $campaign_id = intval($request->input('c_id'));
        $thank_id = intval($request->input('t_id'));

    	$minutes = config('const.time_expire_memcached');
    	$categories = parent::getCategory($minutes);
        $category_name = '';
        //Thanhdv 2016-10-20 get detail campaign page
        if(is_numeric($campaign_id) && is_numeric($thank_id)){
            $campaign = $this->checkGetDataCampaignThank($campaign_id,$thank_id);
            if(count($campaign) > 0 ) {
                $campaign = $campaign[0];
                $category_id = $campaign->category_id;
                if ( count($categories) > 0 ) {
                    foreach($categories as $category) {
                        if( $category_id == $category->id ){
                            $category_name = $category->category_vn;
                            break;
                        }
                    }
                }
            }  else {
                return redirect('/');
            }
        }else{
            $campaign = array();
            return redirect('/');
        }
		return  view('toppage.detail')->with( [ 'categories' => $categories, 'user' => $this->user, 'campaign' => $campaign, 'category_name' => $category_name, 'title_page' => $campaign->promotion_name]);
	}

    public function search(Request $request){
        $minutes = config('const.time_expire_memcached');
        $categories = parent::getCategory($minutes);
        $keyword = trim($request->input('keyword'));
        if( $keyword == ''){
            $campaigns = array();
        }else{
            $campaigns = Campaigns::getSearchCampaigns( $keyword, config('const.number_page_paginate'));
            if (count($campaigns) > 0) {
                foreach ($campaigns as $key=> $values) {
                    $campaign_id = intval($values->campaign_id);
                    $thank_id = intval($values->t_id);
                    //get data campaign thank
                    $data = $this->checkGetDataCampaignThank($campaign_id,$thank_id);
                    if(count($data) > 0) {
                        $campaigns[$key] = $data[0];
                    } else {
                        unset($campaigns[$key]);
                    }
                }
            }

        }
        $title_page = trans('toppage.Search');
        return  view('toppage.search')->with( [ 'categories' => $categories, 'user' => $this->user, 'campaigns' => $campaigns, 'keyword' => $keyword, 'title_page' => $title_page ]);
    }

    /*
     * author:ThanhDV
     * date:2016-10-20
     * description:click url redirect to server civi
     */
    public function getCivi(Request $request){

        $campaign_id = intval($request->input('c_id'));
        $thank_id = intval($request->input('t_id'));
        //check user login
        if (!Auth::check()) {
            return redirect()->back();
        }
        //get media_user_id
        $media_user_id = Auth::user()->media_user_id;
        //get info media_id
        $media_id = intval(config('const.cost_media_id'));
        //get info campaign,thanks
        $data = $this->checkGetDataCampaignThank($campaign_id,$thank_id);


        if (count($data) <= 0) {
            return redirect('/');
        }

        $banner_id = isset($data[0]->banner_id) ? intval($data[0]->banner_id) : 0;
        //check value media_id and banner_id
        $civi_api_url = config('const.civi_api_url');
        $civi_cpc_api = config('const.civi_api_type')['cpc'];
        $civi_api_url .= $civi_cpc_api;

        if ($media_id <= 0 || $banner_id <= 0 || $media_user_id == '') {
            return redirect('/');
        } else {
            //save info log click
            $log_click_detail =  new ClickLogs();
            $log_click_detail->user_id = Auth::user()->id;
            $log_click_detail->campaign_id = $campaign_id;
            $log_click_detail->thank_id = $thank_id;
            $log_click_detail->save();

            $civi_api_url .= '?sid='.$media_id.'&bid='.$banner_id.'&u='.$media_user_id;
            return redirect($civi_api_url);
        }
    }
    /*
     * author:ThanhDV
     * date:2016-10-20
     * description:get infor campaign,thank from cache if exits
     */
    private  function  checkGetDataCampaignThank($campaign_id = 0,$thank_id=0) {
        $data = array();
        $check_status = false;
        $minutes = intval(config('const.const_expire_memcached'));
        $prefix_detail_campaign_thank = config('const.pre_detail_campaign_thank');
        $config_detail_campaign_thank = $prefix_detail_campaign_thank.'_'.$campaign_id.'_'.$thank_id;

        //check save memached
        if (Cache::has($config_detail_campaign_thank)) {
            $data = Cache::get($config_detail_campaign_thank);
        } else {
            $campaigns = Campaigns::getInfoThankCampaign($campaign_id,$thank_id);
            if (count($campaigns) > 0) {
                $start_time = $campaigns[0]->start_time;
                $end_time = $campaigns[0]->end_time;
                $now = date('Y-m-d H:i:s');
                if ($end_time == NULL) {
                    $check_status = true;
                } elseif($start_time <= $now && $end_time >= $now) {
                   $check_status =true;
                    $interval  = abs(strtotime($end_time) - strtotime($now));
                    $minutes   = round($interval / 60);
                }
                if ($check_status) {
                    $data =  $campaigns;
                    Cache::put($config_detail_campaign_thank, $campaigns, $minutes);
                }
            }
        }
        return $data;
    }
    /*
    * author:ThanhDV
    * date:2016-10-20
    * description:check save to store toppage
    */
    private  function checkSaveStoreTopPage($data_promote = array(),$config_memcached,$minutes = 1440)
    {
        $results = array();
        $date_expried = '';
        $now = date('Y-m-d H:i:s');
        if (count($data_promote) > 0) {
            foreach ($data_promote as $values) {
                $end_time = $values->end_time;
                //check date expried memcached
                if ($date_expried == '') {
                    $date_expried = ($end_time != NULL) ? trim($end_time) : '';
                } else {
                    $date_expried = ($end_time != NULL && $date_expried >= $end_time) ? trim($end_time) : $date_expried;
                }
                $campaign_id = intval($values->campaign_id);
                $thank_id = intval($values->id_thanks);
                //get data campaign thank
                $data = $this->checkGetDataCampaignThank($campaign_id,$thank_id);
                if(count($data) > 0) {
                    $results[] = $data[0];
                }

            }
            if ($date_expried != '') {
                $interval  = abs(strtotime($date_expried) - strtotime($now));
                $minutes   = round($interval / 60);
            }
            Cache::put($config_memcached, $data_promote, $minutes);
        }
        return $results;
    }
    /**
    * author:LichNH
    * date:2016-11-03
    */
    public function faq(){
        return view('toppage.faq');
    }
}
