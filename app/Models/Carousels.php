<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carousels extends Model
{
    public static function getAll(){
    	 return Carousels::where('status', 1)->orderBy('order', 'desc')->get();
    }
}
