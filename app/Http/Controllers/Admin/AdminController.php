<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminLoginRequest;
use DB;
use App\Models\Admin\UserPaymentLogs;
use Illuminate\Support\Facades\Route;
use Validator;
use App\User as Users;
class AdminController extends Controller
{
    public function __construct(){
    	//$this->middleware('admin');
    }

    /*
     * author:Thanhdv
     * date:2016-10-05
     * description:get index
     */
    public function index(){
    	// return Auth::guard('admin')->user();
        if(!Auth::guard('admin')->check()) {
            return redirect('admin/login');
        }
    	return view('admin.dashboard');
    }

    /*
     * author:Thanhdv
     * date:2016-10-05
     * description:show login form
     */
    public function showLoginForm(){
        if(Auth::guard('admin')->check()) {
            return redirect('admin');
        }
        $datas = session('post_data_admin_login');
        return view('admin.auth.login')->with('get_data_admin_login',$datas);
    }

    /*
     * author:Thanhdv
     * date:2016-10-05
     * description:post login form
     */
    public function postLogin(AdminLoginRequest $request)
    {
        if(Auth::guard('admin')->check()) {
            return redirect('admin');
        }
        $datas = $request->all();
        $email = $datas['email'];
        $passwd = $datas['password'];

        $credentials = array(
            'email' =>$email,
            'password' => $passwd,
            'status'=>1
        );


        //check user login fail 10 times=>block 5 phut
        // Set login attempts and login time
        $loginAttempts = 1;
        $number_time_limit = config('const.backend_login_number_limit');
        $login_time_lock = config('const.backend_login_time_lock');

        // If session has login attempts, retrieve attempts counter and attempts time
        if ($request->session()->has('loginAttempts'))
        {
            $loginAttempts = $request->session()->get('loginAttempts');
            $loginAttemptTime = $request->session()->get('loginAttemptTime');

            // If attempts > 10 and time < 5 minutes
            if ($loginAttempts > $number_time_limit && (time() - $loginAttemptTime <= $login_time_lock))
            {
                return redirect()->back()->withErrors(['email' => trans('backend.login_msg_time_limit',[ 'number_times' => $number_time_limit, 'login_time_lock' => intval($login_time_lock/60) ])])->with('post_data_admin_login',$datas);
            }
            // If time > 10 minutes, reset attempts counter and time in session
            if (time() - $loginAttemptTime > $login_time_lock)
            {
                $request->session()->put('loginAttempts', 1);
                $request->session()->put('loginAttemptTime', time());
            }
        } else // If no login attempts stored, init login attempts and time
        {
            $request->session()->put('loginAttempts', $loginAttempts);
            $request->session()->put('loginAttemptTime', time());
        }
        // If auth ok, redirect to restricted area
        if(Auth::guard('admin')->attempt($credentials))
        {
            Auth::guard('admin')->user()->last_login = date('Y-m-d H:i:s',time());
            Auth::guard('admin')->user()->save();
            return redirect('admin');
        }
        else
        {
            // Increment login attempts
            $request->session()->put('loginAttempts', $loginAttempts + 1);
            return redirect()->back()->withErrors(['email' => trans('account.err_fail_login')])->with('post_data_admin_login',$datas);
        }



    }

    /*
     * author:Thanhdv
     * date:2016-10-05
     * description:get logout
     */
    public function getLogout()
    {
        if(!Auth::guard('admin')->check()) {
            return redirect('admin/login');
        }
        Auth::guard('admin')->logout();
        return redirect('admin/login');

    }

    /*
     * author:Thanhdv
     * date:2016-10-05
     * description:get payment
     */
    public function getPaymemt(Request $request)
    {
        if(!Auth::guard('admin')->check()) {
            return redirect('admin/login');
        }
        $num_page = config('const.backend_number_page_payment');
        $money = config('const.backend_money_limit');

        $month_start_config = config('const.month_start_payment');
        $arr_date_config = $this->explodeYearMonth($month_start_config);

        $role_id = intval(Auth::guard('admin')->user()->role_id);

        $arr_permission = config('const.backend_arr_permission');
        $list_permission_allow = isset($arr_permission[$role_id]) ? $arr_permission[$role_id] : array();
        $url_current = trim(Route::getFacadeRoot()->current()->uri());

        if(!in_array($url_current,$list_permission_allow)) {
            return view('admin.payment')->with('msg_permission', "Access deny.Please contact admin!");
        }

        $arr_status = array(
            UserPaymentLogs::NO_PAY => trans('backend.payment_status_no_pay'),
            UserPaymentLogs::PAYED => trans('backend.payment_status_payed'),
            UserPaymentLogs::SUSPEND => trans('backend.payment_status_suspend'),
        );
        //
        $data = $request->all();
        $month = isset($data['month']) ? trim($data['month']) : date('m/Y');
        $status = isset($data['status']) ? trim($data['status']) : '';
        $month_format = $this->formatYearMonth($month);

        $page = isset($data['page']) ? intval($data['page']) : 1;

        $arr_payments = array();
        if (!isset($data['btn-search'])) {
            $arr_payments = UserPaymentLogs::searchPayments( $month_format, $status,$money,$num_page);
            return view('admin.payment')->with(['arr_status' => $arr_status,'status' =>$status,'month' => $month,'arr_payments' => $arr_payments,'page' => $page,'num_page' => $num_page,'data' => $data,'arr_date_config' => $arr_date_config]);
        }

        //check validate request
        $validator = Validator::make($request->all(), [
            'month' => 'required|date_format:m/Y'
        ]);

        if ($validator->fails())
        {
            return view('admin.payment')->withErrors($validator->errors())->with(['arr_status' => $arr_status,'status' =>$status,'month' => $month,'arr_payments' => $arr_payments,'data' => $data,'arr_date_config' => $arr_date_config]);
        }

        $arr_start = $this->explodeYearMonth($month);
        $month_start = $arr_start['month'];
        $year_start = $arr_start['year'];

        if ($month_start <1 || $month_start > 12 || $year_start <2016 ) {
            $err_msg = trans('payment_month_invalid');
            return view('admin.payment')->withErrors($err_msg)->with(['arr_status' => $arr_status,'status' =>$status,'month' => $month,'arr_payments' => $arr_payments,'data' => $data,'arr_date_config' => $arr_date_config]);
        }


        $arr_payments = UserPaymentLogs::searchPayments( $month_format, $status,$money,$num_page,$data);

        return view('admin.payment')->with(['arr_status' => $arr_status,'arr_payments'=>$arr_payments,'month'=>$month,'status'=>$status,'page' => $page,'num_page' => $num_page,'data' => $data,'arr_date_config' => $arr_date_config]);
    }
    /*
     * author:Thanhdv
     * date:2016-10-05
     * description:process save payment for user
     */
    public function savePaymentAccount(Request $request)
    {
        if(!Auth::guard('admin')->check()) {
            return redirect('admin/login');
        }
        $results = array();
        $results['status'] = 0;
        $results['msg'] = '';
        $results['payment_time'] = '';
        $results['payment_status'] = '';
        $arr_status = array(
            UserPaymentLogs::PAYED => trans('backend.payment_status_payed'),
            UserPaymentLogs::SUSPEND => trans('backend.payment_status_suspend'),
        );
        $arr_s_key = array_keys($arr_status);


        $data = $request->all();
        $id= isset($data['id']) ? intval($data['id']) : 0;
        $payment_status = isset($data['payment_status']) ? intval($data['payment_status']) : '';
        if (!in_array($payment_status,$arr_s_key)) {
            $results['msg'] = '<div class="alert alert-danger">Please select payment status different no pay</div>';
            echo json_encode($results);die;

        }

        $obj_payment = UserPaymentLogs::find($id);
        if(count($obj_payment) <= 0 ) {
            $results['msg'] = '<div class="alert alert-danger">Update error</div>';
            echo json_encode($results);die;
        }
        DB::beginTransaction();
        try {
            $status_insert = false;
            $date_now = date('Y-m-d H:i:s');
            $point_payment = intval($obj_payment->payment);
            if ($obj_payment->payment_status == 0) {
                $obj_payment->payment_status = $payment_status;
                $obj_payment->admin_id = Auth::guard('admin')->user()->id;
                $obj_payment->payment_time = $date_now;
                $obj_payment->updated_at = $date_now;
                $status_insert = $obj_payment->save();
                if ($payment_status == 2) {
                   $user_id = $obj_payment->user_id;
                   $users = Users::find($user_id);
                    if (count($users) <= 0)
                    {
                        $status_insert = false;
                    } else {
                        $points = intval($users->points);
                        $users->points = $points + $point_payment;
                        $users->updated_at = $date_now;
                        $status_insert = $users->save();
                    }
                }
            }

            if ($status_insert) {
                DB::commit();
                $results['status'] =1;
                $results['msg'] = '<div class="alert alert-success">Update success</div>';
                $results['payment_time'] = $date_now;
                $results['payment_status'] = isset($arr_status[$payment_status]) ? trim($arr_status[$payment_status]) : '';

                echo json_encode($results);die;
            } else {
                $results['msg'] = '<div class="alert alert-danger">Update error</div>';

                echo json_encode($results);die;
            }
        } catch (\Exception $e) {
            DB::rollback();
            $results['msg'] = '<div class="alert alert-danger">Update error</div>';
            echo json_encode($results);die;
        }

        echo json_encode($results);die;
    }
    /*
     * author:Thanhdv
     * date:2016-10-05
     * description:process save all  payment for user
     */
    public function saveAllPayment(Request $request)
    {
        $results = array();
        $results['status'] = 0;
        $results['msg'] = '';
        if(!Auth::guard('admin')->check()) {
            $results['status'] = 2;
            echo json_encode($results);die;
        }
        $arr_status = array(
            UserPaymentLogs::PAYED => trans('backend.payment_status_payed'),
            UserPaymentLogs::SUSPEND => trans('backend.payment_status_suspend'),
        );
        $arr_s_key = array_keys($arr_status);

        $data = $request->all();
        $str_data = isset($data['datas']) ? trim($data['datas']) : '';
        if ($str_data == '') {
            echo json_encode($results);die;
        }
        $arr_payment = $this->explodeStatusPayment($str_data,'&');
        if (empty($arr_payment)) {
            echo json_encode($results);die;
        }

        //insert infor payment
        DB::beginTransaction();
        try {
            foreach ($arr_payment as $payment) {
                $id = isset($payment['id']) ? intval($payment['id']) : 0;
                $status_payment = isset($payment['status']) ? intval($payment['status']) : 0;

                if (!in_array($status_payment,$arr_s_key)) {
                    continue;
                }

                $obj_payment = UserPaymentLogs::findOrFail($id);
                if(count($obj_payment) <= 0 ) {
                   continue;
                }

                $date_now = date('Y-m-d H:i:s');
                $point_payment = intval($obj_payment->payment);
                if ($obj_payment->payment_status == 0 || $status_payment > intval($obj_payment->payment_status)) {
                    $obj_payment->payment_status = $status_payment;
                    $obj_payment->admin_id = Auth::guard('admin')->user()->id;
                    $obj_payment->payment_time = $date_now;
                    $obj_payment->updated_at = $date_now;
                    $obj_payment->save();
                    if ($status_payment == 2) {
                        $user_id = $obj_payment->user_id;
                        $users = Users::findOrFail($user_id);
                        if (count($users) > 0)
                        {
                            $points = intval($users->points);
                            $users->points = $points + $point_payment;
                            $users->updated_at = $date_now;
                            $users->save();
                        }
                    }

                        DB::commit();
                        $text_success = trans('backend.payment_save_all_success');
                        $results['status'] =1;
                        $results['msg'] = "<div class='alert alert-success'>$text_success</div>";
                        $results['success'][$id]['payment_time'] = $date_now;
                        if($status_payment == 1) {
                            $text_payment = "<select class='form-control' id='$id' name='status_payment_$id'>";
                            foreach($arr_status as $k=>$val) {
                                $text_payment .= "<option  value='$k'>$val</option>";
                            }
                            $text_payment .='</select>';
                        } else {
                            $text_payment = isset($arr_status[$status_payment]) ? trim($arr_status[$status_payment]) : '';
                        }

                        $results['success'][$id]['payment_status'] = $text_payment;

                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            $text_error = trans('backend.payment_save_all_error');
            $results['msg'] = "<div class='alert alert-danger'>$text_error</div>";
            echo json_encode($results);die;
        }

        echo json_encode($results);die;
    }
    /*
    * author:Thanhdv
    * date:2016-11-04
    * description:explode month year
    */
    protected function explodeStatusPayment($str = '',$compa = '&') {
        $arr_results = array();
        if ($str != '') {
            $arr_data = explode($compa, $str);
            if (!empty($arr_data)) {
                foreach($arr_data as $key=>$data) {
                   $compa = '=';
                   $arr =  explode($compa, $data);
                    $arr_results[$key]['id'] = isset($arr[0]) ? filter_var($arr[0], FILTER_SANITIZE_NUMBER_INT) : 0;
                    $arr_results[$key]['status'] = isset($arr[1]) ? intval($arr[1]) : 0;
                }
            }

        }
        return $arr_results;
    }

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
}
