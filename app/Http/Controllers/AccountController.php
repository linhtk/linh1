<?php

namespace App\Http\Controllers;
use App\Models\Campaigns;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\AccountRegisterRequest;
use App\Http\Requests\AccountLoginRequest;
use App\Http\Requests\AccountEditRequest;
use App\Http\Requests\AccountBankRequest;
use App\Http\Requests\AccountPwdForgetRequest;
use App\Http\Requests\AccountPwdVerifyRequest;


use Validator;
use App\Helpers\Utils;

use Hash;
use DB;
use Cache;

use Auth;
use Carbon\Carbon;

use App\Models\AccountModel;
use App\Models\Admin\UserPaymentLogs;
use App\Models\UserPointLogs;

use App\Helpers\CBMLog;




class AccountController extends Controller
{
    /*
     * author:Thanhdv
     * date:2016-10-05
     * description:get register account
     */
    public function getRegister()
    {
        //check if login will redirect to top page
        if (Auth::check()) {
            return redirect('/');
        }
        $datas = session('datas_register');
        return view('account.register')->with([ 'datas' => $datas, 'title_page' => trans('toppage.Create account') ]);
    }
    /*
     * author:Thanhdv
     * date:2016-10-05
     * description:post register account
     */
    public function postRegister(AccountRegisterRequest $request)
    {
        //check if login will redirect to top page
        if (Auth::check()) {
            return redirect('/');
        }
        $datas = $request->all();

        return redirect('account/confirm')->with( [ 'datas' => $datas, 'title_page' => trans('toppage.Create account') ] );

    }
    /*
     * author:Thanhdv
     * date:2016-10-05
     * description:get confirm account
     */
    public function getConfirm()
    {
        //check if login will redirect to top page
        if (Auth::check()) {
            return redirect('/');
        }

        $datas = session('datas');
        if (!empty($datas)) {
            session()->flash('datas_register', $datas);
            //check redirect page register if email empty
            session()->flash('datas_back', $datas);
        }
        //check data post form
        $email = isset($datas['email']) ? trim($datas['email']) : '';
        if ($email == '') {
            $datas_back = session('datas_back');
            return redirect('account/register')->with('datas_register',$datas_back);
        }
        return view('account.confirm')->with([ 'datas' => $datas, 'title_page' => trans('toppage.Create account') ]);
    }

    /*
     * author:Thanhdv
     * date:2016-10-05
     * description:post confirm account
     */
    public function postConfirm(AccountRegisterRequest $request)
    {
        //check if login will redirect to top page
        if (Auth::check()) {
            return redirect('/');
        }

       /* //validate data form
        $v = Validator::make($request->all(), [
            'terms' => 'accepted',
        ]);
        //check validate data form
        if ($v->fails())
        {

            return redirect()->back()->withErrors($v->errors())->with('datas',$datas);
        }*/
        $datas= $request->all();


        //encode passwd
        $passwd = trim($datas['passwd']);
        $salt = config('const.const_salt');
        $encode_passwd = Utils::encrypt_password($passwd,$salt);
        $datas['authkey'] = $encode_passwd;
        //create token user
        $key_token = config('const.const_key_token');
        $str = $datas['email'].'|'.time();
        $token = Utils::encryption($str,$key_token);
        $datas['token_user'] = $token;
        //save to memcached
        $const_pre_memcached = config('const.const_pre_memcached');
        $key_memcached = $const_pre_memcached.$token;
        $json_encode_data = json_encode($datas);
        //expried memcached 1 day
        $const_expire_memcached = Carbon::now()->addDay(1);
        //add data into memcached
        Cache::put($key_memcached, $json_encode_data, $const_expire_memcached);
        //send mail
        \Mail::queue('emails.active',
            array(
                'name' => $datas['name'],
                'email' =>$datas['email'],
                'token' => urlencode($token)
            ), function($message) use($datas)
            {
                $message->to($datas['email'], $datas['name'])->subject(trans('account.sign_up_send_mail_title'));
            });

        return redirect('account/active')->with([ 'status_register_active' => 1, 'title_page' => trans('toppage.Create account') ]);
    }
    /*
     * author:Thanhdv
     * date:2016-10-06
     * description:get register account
     */
    public function getActive()
    {
        //check if login will redirect to top page
        if (Auth::check()) {
            return redirect('/');
        }
        //check redirect from post confirm
        $status_register_active = session('status_register_active');
        if (!$status_register_active) {
            return redirect('/');
        }
        return view('account.active')->with([ 'title_page' => trans('toppage.Create account') ]);
    }
    /*
     * author:Thanhdv
     * date:2016-10-06
     * description:get login account
     */

    public function getLogin()
    {
        return redirect('/');

        //check if login will redirect to top page
       /* if (Auth::check()) {
            return redirect('/');
        }
        $datas = session('post_datas_login');
        return view('account.login')->with('get_data_login',$datas);*/
    }
    /*
     * author:Thanhdv
     * date:2016-10-06
     * description:post login account
     */
    public function postLogin(Request $request)
    {
        //check if login will redirect to top page
        if (Auth::check()) {
            return redirect('/');
        }
        $datas = $request->all();
        //check validate
        $validator = Validator::make($request->all(), [
            'login_email' => 'required|email|max:64', 'login_passwd' => 'required',
        ]);

        if ($validator->fails())
        {
            session()->flash('post_data_from_login', $datas);
            return redirect()->back()->withErrors($validator, 'loginErrors');
        }

        $email = $datas['login_email'];
        $passwd = $datas['login_passwd'];

        $credentials = array(
            'email' =>$email,
            'password' => $passwd,
            'status' => 1
        );

        if(Auth::attempt($credentials))
        {
            //update last_login
            Auth::user()->last_login = date('Y-m-d H:i:s',time());
            Auth::user()->save();
            //check back url
            return redirect()->back();
        }
        else
        {
            session()->flash('post_data_from_login', $datas);
            $login_errors = array('email' => trans('account.err_fail_login'));
            return redirect()->back()->withErrors($login_errors,'loginErrors')->with('post_datas_login',$datas);
        }

    }
    /*
     * author:Thanhdv
     * date:2016-10-06
     * description:get logout account
     */
    public function getLogout()
    {
        Auth::logout();
        return redirect('/');

    }
    /*
     * author:Thanhdv
     * date:2016-10-03
     * description:get verify  account
     */
    public function getVerify(Request $request)
    {
        //file log
        $uniqueTime = uniqid('account_register_');
        $structure = 'account_register';

        //check if login will redirect to top page
        if (Auth::check()) {
            return redirect('/');
        }
        CBMLog::writeLog(date('Y-m-d H:i:s').'============= Start Account Verify =============', $uniqueTime, $structure);

        $token = urldecode($request->input('token'));

        $const_pre_memcached = config('const.const_pre_memcached');
        $key_memcached = $const_pre_memcached.$token;

        //get data from memcache
        $values = Cache::get($key_memcached);
        $datas = (array)json_decode($values);
        CBMLog::writeLog(date('Y-m-d H:i:s').':Verify:=============key_memcached:'.$key_memcached, $uniqueTime, $structure);
        CBMLog::writeLog(date('Y-m-d H:i:s').':Verify:============= Data:'.$values, $uniqueTime, $structure);
        if (empty($datas)) {
            //msg error
            CBMLog::writeLog(date('Y-m-d H:i:s').':Verify:============= Data memcached empty =============', $uniqueTime, $structure);
            return redirect('error/error')->withErrors(['message_error' => trans('account.err_sign_up_verify')]);
        }

        //insert data in database
        $email = isset($datas['email']) ? trim($datas['email']) : '';
        $arr_data =array();
        if ($email != '') {
            DB::beginTransaction();
            try {
                $status_insert = false;
                $id = AccountModel::insertInfoAccount($datas);
                if ($id > 0) {
                    $salt_user_id = config('const.const_salt_user_id');
                    $media_user_id = Utils::get_media_user_id($id,$salt_user_id);
                    $arr_data['media_user_id'] = $media_user_id;
                    $status_insert = AccountModel::updateDataAccount($email,$arr_data);
                }
                if ($status_insert) {
                    DB::commit();
                    //delete info memcached
                    Cache::forget($key_memcached);
                    $credentials = array(
                        'email' =>$datas['email'],
                        'password' => $datas['passwd'],
                        'status' => 1
                    );
                    Auth::attempt($credentials);
                    //log register success
                    CBMLog::writeLog(date('Y-m-d H:i:s').':Verify:============= Account success =============', $uniqueTime, $structure);
                    //redirect page finish
                    return redirect('account/finish')->with('status_register_finish', 1);
                } else {
                    CBMLog::writeLog(date('Y-m-d H:i:s').':Verify:============= Data insert fails ============='.$status_insert, $uniqueTime, $structure);
                    return redirect('error/error')->withErrors(['message_error' => trans('account.err_sign_up_verify')]);
                }
                // all good
            } catch (\Exception $e) {
                DB::rollback();
                CBMLog::writeLog(date('Y-m-d H:i:s').':Verify:============= Data insert rollback ============='.$e->getMessage(), $uniqueTime, $structure);
                return redirect('error/error')->withErrors(['message_error' => trans('account.err_sign_up_verify')]);
            }
        } else {
            CBMLog::writeLog(date('Y-m-d H:i:s').':Verify:============= Data email empty ============='.$email, $uniqueTime, $structure);
            return redirect('error/error')->withErrors(['message_error' => trans('account.err_sign_up_verify')]);
        }
    }
    /*
     * author:Thanhdv
     * date:2016-10-06
     * description:get finish account
     */
    public function getFinish()
    {
        //check if login will redirect to top page
        if (!Auth::check()) {
            return redirect('/');
        }
        //check redirect from verify
        $status_register_finish = session('status_register_finish');
        if (!$status_register_finish) {
            return redirect('/');
        }
        $datas = AccountModel::getInforAccountById(Auth::user()->id);

        if(empty($datas)) {
            return redirect('/');
        }

        return view('account.finish')->with([ 'datas' => $datas, 'title_page' => trans('toppage.Create account') ]);

    }
    /*
     * author:Thanhdv
     * date:2016-10-11
     * description:get edit account
     */
    public function getEditAccount()
    {

        //check account have been login
        if (!Auth::check()) {
            return redirect('/');
        }
        //get info user
        $datas = $this->getInforAccount();
        //check data back from confirm edit bank
        $datas_back = session('datas_edit_account');
        if(!empty($datas_back)) {
            $datas = $datas_back;
        }

        return view('account.edit_account')->with(['edit_account'=>$datas, 'title_page' => trans('account.Edit account')]);

    }
    /*
     * author:Thanhdv
     * date:2016-10-11
     * description:get edit account
     */
    public function postEditAccount(AccountEditRequest $request)
    {
        //check account have been login
        if (!Auth::check()) {
            return redirect('/');
        }
        $datas = $request->all();

        if (empty($datas)) {
            redirect('account/edit_account');
        }
        //check have fields edit
        $arr_request = array();
        //revmove space in elememnt
        if (!empty($datas)) {
            foreach($datas as $key=>$val) {
                $arr_request[$key] = trim($val);
            }
            unset($arr_request['_token']);
            unset($arr_request['passwd']);
            unset($arr_request['retype_passwd']);
        }
        $select_fields = 'name,email,tel,address,cmt_no,cmt_date,cmt_local';
        $datas_db = $this->getInforAccount($select_fields);
        //check user have been  edit info?
        $passwd = isset($datas['passwd']) ? trim($datas['passwd']) : '';
        $retype_passwd = isset($datas['retype_passwd']) ? trim($datas['retype_passwd']) : '';
        if (!empty($arr_request) && !empty($datas_db)) {
            $datas_db['cmt_date'] = date('d-m-Y',strtotime($datas_db['cmt_date']));
            $result=array_diff_assoc($arr_request,$datas_db);
            if ($passwd == '' && $retype_passwd == '' && empty($result)) {
                return redirect()->back()->withErrors(['error' => trans('account.err_edit_acount_empty')])->with('datas',$datas);
            }
        }
        //check password and rety_passwd must match
        if ($passwd != ''  && $passwd != $retype_passwd) {
            return redirect()->back()->withErrors(['error' => trans('account.err_edit_acount_pwd')])->with('datas',$datas);
        }

        return redirect('account/confirm_account')->with('confirm_account',$datas);

    }
    /*
     * author:Thanhdv
     * date:2016-10-05
     * description:get confirm account
     */
    public function getConfirmAccount()
    {
        //check account have been login
        if (!Auth::check()) {
            return redirect('/');
        }
        $datas = session('confirm_account');
        if (!empty($datas)) {
            session()->flash('datas_edit_account', $datas);
        }

        //check data post form
        $email = isset($datas['email']) ? trim($datas['email']) : '';
        if ($email == '') {
            return redirect('account/edit_account');
        }
        return view('account.confirm_account')->with(['confirm_account' => $datas, 'title_page' => trans('account.Edit account')]);
    }
    /*
     * author:Thanhdv
     * date:2016-10-11
     * description:post confirm account
     */
    public function postConfirmAccount(AccountEditRequest $request)
    {
        //check if login will redirect to top page
        if (!Auth::check()) {
            return redirect('/');
        }
        $user_id = intval(Auth::user()->id);
        $datas= $request->all();
        if (empty($datas)) {
            return redirect('account/edit_account');
        }
        //check input password
        $passwd = isset($datas['passwd']) ? trim($datas['passwd']) : '';
        $retype_passwd = isset($datas['retype_passwd']) ? trim($datas['retype_passwd']) : '';
        if ($retype_passwd != '' && $retype_passwd != '' &&  $passwd == $retype_passwd) {
            $salt = config('const.const_salt');
            $encode_passwd = Utils::encrypt_password($passwd,$salt);
            $datas['authkey'] = $encode_passwd;
        } else {
            $datas['authkey'] = Auth::user()->password;
        }

        DB::beginTransaction();
        try {
            $results = AccountModel::updateInforAccount($user_id,$datas);
            if ($results) {
                DB::commit();
                return redirect('account/finish_account')->with('status_edit_account_finish', 1);
            } else {
                return redirect('error/error')->withErrors(['message_error' => trans('account.err_edit_acount_confirm')]);
            }

            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('error/error')->withErrors(['message_error' => trans('account.err_edit_acount_confirm')]);
        }
    }

    /*
     * author:Thanhdv
     * date:2016-10-12
     * description:get finish bank
     */
    public function getFinishAccount()
    {
        //check if login will redirect to top page
        if (!Auth::check()) {
            return redirect('/');
        }
        //check redirect from post confirm account
        $status_edit_account = session('status_edit_account_finish');
        if (!$status_edit_account) {
            return redirect('/');
        }
        //get info user
        $datas = $this->getInforAccount();

        if (empty($datas)) {
            return redirect('account/mypage');
        }

        return view('account.finish_account')->with(['finish_account' => $datas, 'title_page' => trans('account.Edit account')]);

    }
    /*
     * author:Thanhdv
     * date:2016-10-06
     * description:get edit bank
     */
    public function getEditBank()
    {
        //check if login will redirect to top page
        if (!Auth::check()) {
            return redirect('/');
        }
        //get info user
        $datas = $this->getInforAccount();
        //check data back from confirm edit bank
        $datas_back = session('datas_edit_bank');
        if(!empty($datas_back)) {
            $datas = $datas_back;
        }

        return view('account.edit_bank')->with([ 'edit_bank' => $datas, 'title_page' => trans('account.Edit Bank Account')]);

    }
    /*
    * author:Thanhdv
    * date:2016-10-11
    * description:post edit bank
    */
    public function postEditBank(AccountBankRequest $request)
    {
        //check account have been login
        if (!Auth::check()) {
            return redirect('/');
        }
        $datas = $request->all();
        //check have fields edit
        $arr_request = array();
        //revmove space in elememnt
        if (!empty($datas)) {
            foreach($datas as $key=>$val) {
                $arr_request[$key] = trim($val);
            }
            unset($arr_request['_token']);
        }
        $select_fields = 'bank_account_name,bank_name,bank_branch_name,bank_account_number';
        $datas_db = $this->getInforAccount($select_fields);

        if (!empty($arr_request) && !empty($datas_db)) {
            $result=array_diff_assoc($arr_request,$datas_db);
            if (empty($result)) {
                return redirect()->back()->withErrors(['error' => trans('account.err_edit_bank_empty')])->with('datas',$datas);
            }
        }



        return redirect('account/confirm_bank')->with('post_edit_bank',$datas);

    }
    /*
    * author:Thanhdv
    * date:2016-10-05
    * description:get confirm bank
    */
    public function getConfirmBank()
    {
        //check account have been login
        if (!Auth::check()) {
            return redirect('/');
        }
        $datas = session('post_edit_bank');
        if (!empty($datas)) {
            session()->flash('datas_edit_bank', $datas);
        }

        //check data post form
        $bank_account_name = isset($datas['bank_account_name']) ? trim($datas['bank_account_name']) : '';
        if ($bank_account_name == '') {
            return redirect('account/edit_bank');
        }
        return view('account.confirm_bank')->with(['confirm_bank' => $datas, 'title_page' => trans('account.Edit Bank Account')]);
    }
    /*
    * author:Thanhdv
    * date:2016-10-12
    * description:post confirm bank
    */
    public function postConfirmBank(AccountBankRequest $request)
    {
        //check if login will redirect to top page
        if (!Auth::check()) {
            return redirect('/');
        }
        $user_id = intval(Auth::user()->id);
        $datas= $request->all();
        if (empty($datas)) {
            return redirect('account/edit_bank');
        }
        //update info bank in db
        DB::beginTransaction();
        try {
            $results = AccountModel::updateInforBank($user_id,$datas);
            if ($results) {
                DB::commit();
                return redirect('account/finish_bank')->with('status_edit_bank_finish', 1);
            } else {
                return redirect('error/error')->withErrors(['message_error' => trans('account.err_edit_bank_confirm')]);
            }

            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('error/error')->withErrors(['message_error' => trans('account.err_edit_bank_confirm')]);
        }

    }
    /*
     * author:Thanhdv
     * date:2016-10-06
     * description:get finish bank
     */
    public function getFinishBank()
    {
        //check if login will redirect to top page
        if (!Auth::check()) {
            return redirect('/');
        }
        //check redirect from post confirm bank
        $status_edit_bank = session('status_edit_bank_finish');
        if (!$status_edit_bank) {
            return redirect('/');
        }
        //get info user
        $datas = $this->getInforAccount();

        if (empty($datas)) {
            return redirect('account/mypage');
        }

        return view('account.finish_bank')->with(['finish_bank' => $datas, 'title_page' => trans('account.Edit Bank Account')]);

    }
    /*
    * author:Thanhdv
    * date:2016-10-06
    * description:get mypage
    */
    public function getMyPage()
    {
        //check if login will redirect to top page
        if (!Auth::check()) {
            return redirect('/');
        }

        return view('account.mypage')->with( [ 'title_page' => trans('account.user_page') ] );

    }
    /*
   * author:Thanhdv
   * date:2016-10-12
   * description:get infor account from db
   */
    protected function getInforAccount($select_fields = '*') {
        $id = intval(Auth::user()->id);
        $datas =  AccountModel::getInforAccountById($id,$select_fields);
        return $datas;
    }

    /*
     * author:Thanhdv
     * date:2016-10-12
     * description:get forget password index
     */
    public function getPasswdEmail()
    {
        //check if login will redirect to top page
        if (Auth::check()) {
            return redirect('account/mypage');
        }

        return view('account.pwd_email')->with(['title_page' => trans('account.reset_title')]);

    }
    /*
    * author:Thanhdv
    * date:2016-10-11
    * description:post edit bank
    */
    public function postPasswdEmail(AccountPwdForgetRequest $request)
    {
        //check account have been login
        if (Auth::check()) {
            return redirect('account/mypage');
        }
        $datas = $request->all();
        //check data email
        $email = isset($datas['email']) ? trim($datas['email']) : '';
        if ($email == '') {
            return redirect('account/pwd_email');
        }
        //create token user
        $key_token = config('const.const_key_token');
        $str = $datas['email'].'|'.time();
        $token = Utils::encryption($str,$key_token);
        $datas['token_pwd'] = $token;
        //save to memcached
        //$const_expire_memcached = intval(config('const.const_expire_memcached'));
        $const_pre_memcached = config('const.const_pre_memcached_forget_pwd');
        $key_memcached = $const_pre_memcached.$token;
        $json_encode_data = json_encode($datas);
        //expried memcached 1 day
        $const_expire_memcached = Carbon::now()->addDay(1);
        //add data into memcached
        Cache::put($key_memcached, $json_encode_data, $const_expire_memcached);

        //send mail
        \Mail::queue('emails.mail_forget_active',
            array(
                'email' =>$datas['email'],
                'token_pwd' => urlencode($token)
            ), function($message) use($datas)
            {
                $message->to($datas['email'])->subject(trans('account.pwd_reset_send_mail_title'));
            });

        return redirect('account/pwd_active')->with('status_pwd_reset_active', 1);

    }
    /*
    * author:Thanhdv
    * date:2016-10-12
    * description:get forget password after sendmail
    */
    public function getPasswdActive()
    {
        //check if login will redirect to top page
        if (Auth::check()) {
            return redirect('account/mypage');
        }
        //check redirect from post pwd reset
        $status_pwd_reset_active = session('status_pwd_reset_active');
        if (!$status_pwd_reset_active) {
            return redirect('/');
        }

        return view('account.pwd_active')->with(['title_page' => trans('account.reset_title')]);
    }
    /*
    * author:Thanhdv
    * date:2016-10-12
    * description:get forget password index
    */
    public function getPwdVerify(Request $request)
    {
        //check if login will redirect to top page
        if (Auth::check()) {
            return redirect('account/mypage');
        }
        $token = urldecode($request->input('token_pwd'));

        $const_pre_memcached = config('const.const_pre_memcached_forget_pwd');
        $key_memcached = $const_pre_memcached.$token;

        //get data from memcache
        $values = Cache::get($key_memcached);
        $datas = (array)json_decode($values);
        if (empty($datas)) {
            //msg error

            return redirect('error/error')->withErrors(['message_error' => trans('account.err_pwd_reset_verify')]);
        }

        return view('account.pwd_verify')->with(['token_pwd'=> urlencode($token), 'title_page' => trans('account.reset_title')]);

    }

    /*
     * author:Thanhdv
     * date:2016-10-12
     * description:post pwd verify
     */
    public function postPwdVerify(AccountPwdVerifyRequest $request)
    {
        //check if login will redirect to top page
        if (Auth::check()) {
            return redirect('account/mypage');
        }
        $token = urldecode($request->input('token_pwd'));

        $datas_post = $request->all();

        $const_pre_memcached = config('const.const_pre_memcached_forget_pwd');
        $key_memcached = $const_pre_memcached.$token;

        //get data from memcache
        $values = Cache::get($key_memcached);
        $datas = (array)json_decode($values);
        if (empty($datas)) {
            //msg error

            return redirect('error/error')->withErrors(['message_error' => trans('account.err_pwd_reset_post_verify')]);
        }
        $email = isset($datas['email']) ? trim($datas['email']) : '';
        if ($email == '') {
            return redirect('error/error')->withErrors(['message_error' => trans('account.err_pwd_reset_post_verify')]);
        }
        $datas_db = AccountModel::getInforAccountByEmail($email);
        if (empty($datas_db)) {
            return redirect('error/error')->withErrors(['message_error' => trans('account.err_pwd_reset_post_verify')]);
        }


        $passwd = isset($datas_post['passwd']) ? trim($datas_post['passwd']) : '';
        $salt = config('const.const_salt');
        $encode_passwd = Utils::encrypt_password($passwd,$salt);

        //update password to db
        $data_insert = array();
        $data_insert['password'] = trim($encode_passwd);
        $data_insert['updated_at'] = date('Y-m-d H:i:s',time());

        DB::beginTransaction();
        try {
            $status_insert = AccountModel::updateDataAccount($datas_db['email'],$data_insert);
            if ($status_insert) {
                DB::commit();
                Cache::forget($key_memcached);
                //redirect page finish
                return redirect('account/pwd_finish')->with('status_pwd_reset_finish', 1);
            } else {
                return redirect('error/error')->withErrors(['message_error' => trans('account.err_pwd_reset_db_verify')]);
            }

            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('error/error')->withErrors(['message_error' => trans('account.err_pwd_reset_db_verify')]);
        }
    }
    /*
   * author:Thanhdv
   * date:2016-10-12
   * description:get forget password  finish
   */
    public function getPwdFinish()
    {
        //check if login will redirect to top page
        if (Auth::check()) {
            return redirect('/');
        }
        //check redirect from post pwd reset
        $status_pwd_reset_finish = session('status_pwd_reset_finish');
        if (!$status_pwd_reset_finish) {
            return redirect('/');
        }
        return view('account.pwd_finish')->with(['title_page' => trans('account.reset_title')]);

    }

   /*
   * author:Thanhdv
   * date:2016-11-03
   * description:get payment log
   */
    public function getPaymentAccount(Request $request)
    {
        $arr_payments = array();
        //check if login will redirect to top page
        if (!Auth::check()) {
            return redirect('/');
        }

        $user_id = Auth::user()->id;
        $num_page = config('const.frontend_number_page_payment');
        $money = config('const.backend_money_limit');
        $month_start_config = config('const.month_start_payment');
        $arr_status = array(
            UserPaymentLogs::NO_PAY => trans('account.payment_status_no_pay'),
            UserPaymentLogs::PAYED => trans('account.payment_status_payed'),
            UserPaymentLogs::SUSPEND => trans('account.payment_status_suspend'),
        );


        $data = $request->all();

        $end_date = isset($data['end_date']) ? trim($data['end_date']) : date('m/Y');
        $start_date = isset($data['start_date']) ? trim($data['start_date']) : '';
        $end_date_format = $this->formatYearMonth($end_date);

        $page = isset($data['page']) ? intval($data['page']) : 1;

        $arr_date_config = $this->explodeYearMonth($month_start_config);

        if (!isset($data['btn-search']) && !isset($data['start_date'])) {
            $start_date = date('m/Y', strtotime("-6 months"));
            $start_date_format = $this->formatYearMonth($start_date);
            $month_start_config_format = $this->formatYearMonth($month_start_config);
            $start_date = ($start_date_format >= $month_start_config_format) ? $start_date : $month_start_config;
            $start_date_format = $this->formatYearMonth($start_date);

            $arr_payments = $this->getInfoPaymentAccount($user_id,$start_date_format, $end_date_format, $money, $num_page);
            return view('account.payment_log')->with(['arr_status' => $arr_status,'start_date' => $start_date,'end_date'=> $end_date,'arr_payments' => $arr_payments,'page' => $page,'num_page' => $num_page,'arr_date_config' => $arr_date_config]);
        }
        //check validate request
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date_format:m/Y', 'end_date' => 'required|date_format:m/Y',
        ]);

        if ($validator->fails())
        {
            return view('account.payment_log')->withErrors($validator->errors())->with(['arr_status' => $arr_status,'start_date' => $start_date,'end_date'=> $end_date,'arr_payments' => $arr_payments,'arr_date_config' => $arr_date_config]);
        }
        //check format date
        $arr_start = $this->explodeYearMonth($start_date);
        $arr_end = $this->explodeYearMonth($end_date);
        $month_start = $arr_start['month'];
        $year_start = $arr_start['year'];
        $month_end = $arr_end['month'];
        $year_end = $arr_end['year'];

        if ($month_start <1 || $month_start > 12 || $year_start <2016 ) {
            $err_msg = trans('account.Start date invalid');
            return view('account.payment_log')->withErrors($err_msg)->with(['arr_status' => $arr_status,'start_date' => $start_date,'end_date'=> $end_date,'arr_payments' => $arr_payments,'arr_date_config' => $arr_date_config]);
        }
        if ($month_end <1 || $month_end > 12 || $year_end <2016 ) {
            $err_msg = trans('account.End date invalid');
            return view('account.payment_log')->withErrors($err_msg)->with(['arr_status' => $arr_status,'start_date' => $start_date,'end_date'=> $end_date,'arr_payments' => $arr_payments,'arr_date_config' => $arr_date_config]);
        }

        $start_date_format = $this->formatYearMonth($start_date);
        if ($start_date_format > $end_date_format) {
            $err_msg = trans('account.Start date cant after end date');
            return view('account.payment_log')->withErrors($err_msg)->with(['arr_status' => $arr_status,'start_date' => $start_date,'end_date'=> $end_date,'arr_payments' => $arr_payments,'arr_date_config' => $arr_date_config]);
        }

        $arr_payments = $this->getInfoPaymentAccount($user_id,$start_date_format, $end_date_format, $money, $num_page);

        return view('account.payment_log')->with(['arr_status' => $arr_status,'start_date' => $start_date,'end_date'=> $end_date,'arr_payments' => $arr_payments,'page' => $page,'num_page' => $num_page,'arr_date_config' => $arr_date_config]);

    }
   /*
   * author:Thanhdv
   * date:2016-11-04
   * description:convert month year
   */
    protected function formatYearMonth($str = '') {
        $month_format = '';
        if ($str != '') {
            $arr_time = explode("/", $str);
            $month_format = isset($arr_time[1]) ? $arr_time[1] : '';
            $month = isset($arr_time[0]) ? $arr_time[0] : '';
            $month_format = intval($month_format.$month);

        }
        return $month_format;
    }
    /*
  * author:Thanhdv
  * date:2016-11-04
  * description:explode month year
  */
    protected function explodeYearMonth($str = '') {
        $arr_month_year = array();
        if ($str != '') {
            $arr_time = explode("/", $str);
            $arr_month_year['month'] = isset($arr_time[0]) ? intval($arr_time[0]) : '';
            $arr_month_year['year'] = isset($arr_time[1]) ? intval($arr_time[1]) : '';
        }
        return $arr_month_year;
    }
    /*
   * author:Thanhdv
   * date:2016-11-04
   * description:get infor payment
   */
    protected function getInfoPaymentAccount($user_id = '',$start_date_format ='', $end_date_format='', $money = 200000, $num_page = 15) {
        $arr_payments = array();
        if ($user_id != '' && $start_date_format != '' && $end_date_format != '') {
            $arr_payments = UserPaymentLogs::searchPaymentFrontend($user_id,$start_date_format, $end_date_format, $money, $num_page);

        }
        return $arr_payments;
    }

   /*
   * author:Thanhdv
   * date:2016-11-03
   * description:post payment log
   */
    public function getPointAccount(Request $request)
    {
        //check if login will redirect to top page
        if (!Auth::check()) {
            return redirect('/');
        }
        $user_id = Auth::user()->id;
        $num_page = config('const.frontend_number_page_payment');
        $arr_status = array(
            UserPointLogs::UNCONFIRM => trans('account.point_status_unconfirm'),
            UserPointLogs::COMFIRM => trans('account.point_status_confirm'),
            UserPointLogs::REJECT => trans('account.point_status_reject'),
        );
        $arr_points = array();
        $arr_promotions = array();

        $num_date = config('const.frontend_point_log_num_date');
        $data = $request->all();
        $end_date = isset($data['end_date']) ? trim($data['end_date']) : date('d/m/Y');
        $start_date = isset($data['start_date']) ? trim($data['start_date']) : date('d/m/Y',strtotime(" -$num_date day"));

        if (!isset($data['btn-search'])) {
            $arr_results = $this->processPointLog($user_id,$arr_status,$data,$num_page);
            $arr_points = isset($arr_results['arr_points']) ? $arr_results['arr_points'] : array();
            $arr_promotions = isset($arr_results['arr_promotions']) ? $arr_results['arr_promotions'] : array();
            return view('account.point_log')->with(['arr_status' => $arr_status,'data' =>$data,'arr_points' => $arr_points,'arr_promotions' =>$arr_promotions,'num_page' => $num_page]);
        }
        //check validate
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date_format:d/m/Y', 'end_date' => 'required|date_format:d/m/Y',
        ]);

        if ($validator->fails())
        {
            return view('account.point_log')->withErrors($validator->errors())->with(['arr_status' => $arr_status,'data' =>$data,'arr_points' => $arr_points]);
        }

        $end_date = str_replace('/', '-', $end_date);
        $end_date_format = date('Y-m-d',strtotime($end_date));

        $start_date = str_replace('/', '-', $start_date);
        $start_date_format = date('Y-m-d',strtotime($start_date));

        if (strtotime($start_date_format) > strtotime($end_date_format)) {
            $err_msg = trans('account.Start date cant after end date');
            return view('account.point_log')->withErrors($err_msg)->with(['arr_status' => $arr_status,'data' =>$data,'arr_points' => $arr_points,'arr_promotions' =>$arr_promotions,'num_page' => $num_page]);
        }

        $arr_results = $this->processPointLog($user_id,$arr_status,$data,$num_page);

        $arr_points = isset($arr_results['arr_points']) ? $arr_results['arr_points'] : array();
        $arr_promotions = isset($arr_results['arr_promotions']) ? $arr_results['arr_promotions'] : array();

        return view('account.point_log')->with(['arr_status' => $arr_status,'data' =>$data,'arr_points' => $arr_points,'arr_promotions' =>$arr_promotions,'num_page' => $num_page]);

    }
    protected function processPointLog($user_id = '', $arr_status= array(), $data = array(),$num_page = 15) {
        $arr_result = array();
        $arr_promotions = array();
        $arr_points = array();
        $num_date = config('const.frontend_point_log_num_date');
        $end_date = isset($data['end_date']) ? trim($data['end_date']) : date('d/m/Y');
        $start_date = isset($data['start_date']) ? trim($data['start_date']) : date('d/m/Y',strtotime(" -$num_date day"));
        $status = isset($data['status']) ? trim($data['status']) : '';
        $adv_name = isset($data['adv_name']) ? trim($data['adv_name']) : '';
        if ($start_date != '' && $end_date != '') {
            $end_date = str_replace('/', '-', $end_date);
            $end_date_format = date('Y-m-d',strtotime($end_date));

            $start_date = str_replace('/', '-', $start_date);
            $start_date_format = date('Y-m-d',strtotime($start_date));

            $arr_promotions_id = array();
            if ($adv_name != '') {
                $arr_promotions = Campaigns::getPromotionByAdv($adv_name);
                if (!empty($arr_promotions)) {
                    $arr_result['arr_promotions'] = $arr_promotions;
                    $arr_promotions_id = array_keys($arr_promotions);
                    $arr_promotions_id = array_unique($arr_promotions_id);

                    $arr_points = UserPointLogs::searchPointFrontend($user_id,$start_date_format, $end_date_format, $status,$arr_promotions_id, $num_page);
                    $arr_result['arr_points'] = $arr_points;

                } else {
                    $arr_result['arr_promotions'] = array();
                    $arr_result['arr_points'] = array();
                }
            } else {
                $arr_points = UserPointLogs::searchPointFrontend($user_id,$start_date_format, $end_date_format, $status,$arr_promotions_id, $num_page);
                $arr_result['arr_points'] = $arr_points;
                $ar_promote = array();
                if(count($arr_points) > 0) {
                    foreach($arr_points as $values) {
                        $ar_promote[] = $values->promotion_id;
                    }
                }
                if (!empty($ar_promote)) {
                    $ar_promote = array_unique($ar_promote);
                    $arr_promotions = Campaigns::getAdvNameByPromotion($ar_promote);
                    $arr_result['arr_promotions'] = $arr_promotions;
                }
            }

        }
        return $arr_result;
    }


}
