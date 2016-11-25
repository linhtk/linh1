<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use PDO;

class AccountModel extends Model
{
    protected   $table = 'users';

    /*
     * author:Thanhdv
     * date:2016-10-11
     * description:get infor user by id
     */
    public static function getInforAccountById($id = '',$select_fields = '*') {
        $datas = array();
        if ($id != '') {
            DB::setFetchMode(PDO::FETCH_ASSOC);
            $results =  DB::select("select $select_fields from users where id = ?", array($id));
           if (!empty($results)) {
                foreach($results as $values) {
                    $datas = $values;
                }
           }
        }
        return $datas;

    }
    /*
     * author:Thanhdv
     * date:2016-10-11
     * description:update infor user
     */
    public static function updateInforAccount($id,$arr_params =array())
    {
        $results = false;
        if ($id) {
            //$results = AccountModel::whereId($id)->update($arr_params);
            $arr_update = array(
                'name' => trim($arr_params['name']),
                'cmt_no' => trim($arr_params['cmt_no']),
                'cmt_date' => date("Y-m-d",strtotime(trim($arr_params['cmt_date']))),
                'cmt_local' => trim($arr_params['cmt_local']),
                'tel' => trim($arr_params['tel']),
                'address' => trim($arr_params['address']),
                'updated_at' => date('Y-m-d H:i:s',time())
            );
            $passwd = isset($arr_params['authkey']) ? trim($arr_params['authkey']) : '';
            if ($passwd != '') {
                $arr_update['password'] = $passwd;
            }

            $results =  DB::table('users')
                        ->where('id', $id)
                        ->update($arr_update);
        }
        return $results;
    }
    /*
     * author:Thanhdv
     * date:2016-10-11
     * description:update infor user
     */
    public static function updateInforBank($id,$arr_params =array())
    {
        $results = false;
        if ($id) {
            //$results = AccountModel::whereId($id)->update($arr_params);
            $results =  DB::table('users')
                ->where('id', $id)
                ->update(
                    [
                        'bank_account_name' => trim($arr_params['bank_account_name']),
                        'bank_name' => trim($arr_params['bank_name']),
                        'bank_branch_name' => trim($arr_params['bank_branch_name']),
                        'bank_account_number' => trim($arr_params['bank_account_number']),
                        'updated_at' => date('Y-m-d H:i:s',time()),

                    ]
                );
        }
        return $results;
    }
    /*
     * author:Thanhdv
     * date:2016-10-11
     * description:update infor user
     */
    public static function updateDataAccount($email = '',$data = array())
    {
        $results = false;
        if ($email && !empty($data)) {
            $results =  DB::table('users')
                ->where('email', $email)
                ->update($data);
        }
        return $results;
    }
    /*
     * author:Thanhdv
     * date:2016-10-13
     * description:get infor user by email
     */
    public static function getInforAccountByEmail($email = '') {
        $datas = array();
        if ($email != '') {
            DB::setFetchMode(PDO::FETCH_ASSOC);
            $results =  DB::select("select * from users where email = ?", array($email));
            if (!empty($results)) {
                foreach($results as $values) {
                    $datas = $values;
                }
            }
        }
        return $datas;

    }
    /*
     * author:Thanhdv
     * date:2016-10-18
     * description:get infor user by id
     */
    public static function insertInfoAccount($data = array()) {
        $id = 0;
        if (!empty($data)) {
            $id = DB::table('users')->insertGetId(
                [
                    'name' => trim($data['name']),
                    'email' => trim($data['email']),
                    'cmt_no' => trim($data['cmt_no']),
                    'cmt_date' => date("Y-m-d",strtotime(trim($data['cmt_date']))),
                    'cmt_local' => trim($data['cmt_local']),
                    'password' => trim($data['authkey']),
                    'address' => trim($data['address']),
                    'tel' => trim($data['tel']),
                    'status' => 1,
                    'created_at'=>date('Y-m-d H:i:s',time()),
                    'updated_at'=>date('Y-m-d H:i:s',time())
                ]
            );
        }
        return $id;

    }

}
