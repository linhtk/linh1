<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Cache;
use App\Models\Carousels;
use App\Models\Categories;
use Illuminate\Support\Facades\Auth;
use App\ApiServices\ApiConnection;
use Illuminate\Support\Facades\Route;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function getCategory($minutes){
    	return Cache::remember(config('const.key_categorys'), $minutes, function(){ 
            $categoriesAll = Categories::getAll();
            if(count($categoriesAll)){ 
                return $categoriesAll;
            }
        });
    }

    public static function getCarousels($minutes){
    	return Cache::remember(config('const.key_carousels'), $minutes, function(){ 
            $carouselsAll = Carousels::getAll(); 
            if(count($carouselsAll)){ 
                return $carouselsAll;
            }
        });
    }

    protected static function getInfoUser(){
    	$user = array();
        if ( Auth::check() ) {
            $api = new ApiConnection();
            //$getPoint = $api->getPoint(array('pubid' => Auth::user()->id, 'email' => Auth::user()->email));
            //$user = Utils::infoUser(Auth::user()->name, $getPoint);
            $user['name'] = Auth::user()->name;
            $user['status'] = 200;
            $user['point'] = 2000;
        }
        return $user;
    }
}
