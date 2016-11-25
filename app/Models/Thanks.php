<?php
/**
 * Created by PhpStorm.
 * User: phucnn
 * Date: 11/15/16
 * Time: 11:31 AM
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Thanks extends Model{
    protected $table = 'thanks';
    protected $fillable = [
        'campaign_id', 'promotion_id', 'thanks_id',
        'thanks_name', 'thanks_type', 'normal_price', 'special_price',
        'delete_flag', 'updated_at', 'created_at'
    ];
}