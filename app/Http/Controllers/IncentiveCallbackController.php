<?php
namespace App\Http\Controllers;

use App\Helpers\CBMLog;
use App\Models\AccountModel;
use App\Models\UserPointLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncentiveCallbackController extends Controller
{
    const CONST_ACCEPT_UNCONFIRM = 0;
    const CONST_ACCEPT_CONFIRM = 1;
    const CONST_ACCEPT_REJECT = 2;

    const CONST_PAYMENT_FIXED = 0;
    const CONST_PAYMENT_PERCENT = 1;

    public $uniqueTime;
    public $structure;
    public $lastStatus;

    public function __construct(){
        $this->uniqueTime = uniqid('incentive_');
        $this->structure = 'incentive';
        $this->lastStatus = IncentiveCallbackController::CONST_ACCEPT_UNCONFIRM;
    }

    /**
     * @param Request $request
     */
    public function postback( Request $request ){
        CBMLog::writeLog('============= Start Pushing Incentive =============', $this->uniqueTime, $this->structure);

        try{
            $ip_request = !empty($request->ip()) ? $request->ip() : '';
            // check IP
            $this->checkIp($ip_request);

            // init Data
            $data = $this->initData($request);

            // check media user id
            $user_data = $this->checkUser($data['media_user_id']);

            // flag accept ?
            $this->checkAccept($data, $user_data['id']);

            // pushing incentive to database
            $this->pushIncentive( $data, $user_data['id']);

            $this->returnMessage( 200 , 'Insert/Update data incentives : OK');

        }catch (\Exception $e) {
            $this->returnMessage( $e->getCode() , $e->getMessage());
        }
        
        CBMLog::writeLog('============= End Pushing Incentive =============', $this->uniqueTime, $this->structure);

        die;
    }

    /**
     * @param $data
     * @param $user_id
     * @throws \Exception
     */
    private function pushIncentive( $data, $user_id ){

        DB::beginTransaction();
        try {

            // set points to pushing
            if( $data['payment_type'] == IncentiveCallbackController::CONST_PAYMENT_FIXED ){
                $point_log = $data['price'];
            }else{
                $point_log = $data['sales'];
            }

            // update Data
            UserPointLogs::updateOrCreate(
            // duplicate data
                [
                    'promotion_id' => $data['promotion_id'],
                    'action_id' => $data['action_id'],
                    'thanks_id' => $data['thanks_id'],
                    'user_id' => $user_id
                ],
                // insert data
                [
                    'media_user_id' => $data['media_user_id'],
                    'accept' => $data['accept'],
                    'accept_time' => $data['accept_time'],
                    'action_time' => $data['action_time'],
                    'payment_type' => $data['payment_type'],
                    'price' => $point_log
                ]
            );

            // if $accept == 1 ( confirm ) => add point to user
            if ( $this->lastStatus == IncentiveCallbackController::CONST_ACCEPT_UNCONFIRM && $data['accept'] == IncentiveCallbackController::CONST_ACCEPT_CONFIRM ){
                DB::table('users')->whereId($user_id)->increment('points', $point_log);
            }

            /* if action is change from confirmed to reject => minus point to user
            if ( $this->lastStatus == IncentiveCallbackController::CONST_ACCEPT_CONFIRM && $data['accept'] == IncentiveCallbackController::CONST_ACCEPT_REJECT ){
                DB::table('users')->whereId($user_id)->decrement('points', $point_log);
            }
            */

            DB::commit();
            CBMLog::writeLog("200: Insert/Update data incentive {$data['promotion_id']} with action {$data['action_id']} and thank_id {$data['thanks_id']} : OK", $this->uniqueTime, $this->structure);
        } catch (\Exception $e) {
            DB::rollback();
            CBMLog::writeLog("403: Insert/Update data incentive {$data['promotion_id']} with action {$data['action_id']} and thank_id {$data['thanks_id']} wrong: ".$e->getMessage(), $this->uniqueTime, $this->structure);
            throw new \Exception('Insert/Update data incentive can not execute. Try again later! ', 403);
        }
    }

    /**
     * @param $data
     * @param $user_id
     * @return bool
     * @throws \Exception
     */
    private function checkAccept( $data, $user_id ){
        // find have own media_user_info
        $find_action = UserPointLogs::where('promotion_id', $data['promotion_id'])
            ->where('action_id', $data['action_id'])
            ->where('thanks_id', $data['thanks_id'])
            ->where('user_id', $user_id)
            ->first();
        if( !empty($find_action) ){
            // if accept = Reject => no need to process
            // $this->lastStatus = IncentiveCallbackController::CONST_ACCEPT_REJECT;
            if ( $find_action['accept'] == IncentiveCallbackController::CONST_ACCEPT_REJECT ){
                CBMLog::writeLog('404: This action has been rejected. Can not update! ', $this->uniqueTime, $this->structure);
                throw new \Exception('This action has been rejected. Can not update! ', 404);
            }else if ($find_action['accept'] == IncentiveCallbackController::CONST_ACCEPT_CONFIRM) {
                // if accept = Confirmed => no need to process
                // TODO : add flag to know Confirmed to Rejected => minus points user
                // $this->lastStatus = IncentiveCallbackController::CONST_ACCEPT_CONFIRM;
                CBMLog::writeLog('404: This action has been confirmed. Can not update! ', $this->uniqueTime, $this->structure);
                throw new \Exception('This action has been confirmed. Can not update! ', 404);
            }
        }
        return true;
    }

    /**
     * @param $media_user_id
     * @return mixed
     * @throws \Exception
     */
    private function checkUser( $media_user_id ){
        // find have own media_user_info
        $user_data = AccountModel::where('media_user_id', $media_user_id)->first();
        if( empty($user_data) ){
            CBMLog::writeLog('402: Can not find user own media info', $this->uniqueTime, $this->structure);
            throw new \Exception('Can not find user own media info. ', 402);
        }

        return $user_data;
    }

    /**
     * @param $request
     * @return array
     * @throws \Exception
     */
    private function initData( $request ){
        $data = array();
        if(!empty($request)) {
            $data['promotion_id'] = !empty($request['cpid']) ? intval($request['cpid']) : 0;
            $data['media_user_id'] = !empty($request['u']) ? $request['u'] : '';
            $data['accept'] = $this->setAccept( $request['accept'] );
            $data['accept_time'] = !empty($request['acpt_t']) ? date('Y-m-d H:i:s', strtotime($request['acpt_t'])) : null;
            $data['action_time'] = !empty($request['act_t']) ? date('Y-m-d H:i:s', strtotime($request['act_t'])) : null;
            $data['payment_type'] = isset($request['r_flag']) ? intval($request['r_flag']) : 0;
            $data['action_id'] = !empty($request['actid']) ? intval($request['actid']) : 0;
            $data['price'] = isset($request['price']) ? $request['price'] : 0;
            $data['sales'] = isset($request['sales']) ? $request['sales'] : 0;
            $data['thanks_id'] = !empty($request['t_id']) ? $request['t_id'] : 0;

            if(empty($data['promotion_id']) || empty($data['action_id']) || empty($data['thanks_id']) || empty($data['media_user_id'])){
                CBMLog::writeLog("401: Has a field require null data. 
                 promotion_id: {$data['promotion_id']},
                 action_id: {$data['action_id']},
                 thanks_id: {$data['thanks_id']},
                 media_user_id: {$data['media_user_id']}", $this->uniqueTime, $this->structure);
                throw new \Exception('Has a field require null data. ', 401);
            }
        }else{
            CBMLog::writeLog('401: Can not get data', $this->uniqueTime, $this->structure);
            throw new \Exception('Can not get data. ', 401);
        }

        return $data;
    }

    /**
     * @param $accept
     * @return int
     */
    private function setAccept( $accept ){
        switch ( $accept ) {
            case null:
                $setAccept = IncentiveCallbackController::CONST_ACCEPT_UNCONFIRM;
                break;
            case 1:
                $setAccept = IncentiveCallbackController::CONST_ACCEPT_CONFIRM;
                break;
            case 0:
                $setAccept = IncentiveCallbackController::CONST_ACCEPT_REJECT;
                break;
            default:
                $setAccept = IncentiveCallbackController::CONST_ACCEPT_UNCONFIRM;
        }
        return $setAccept;
    }

    /**
     * @param $ip_request
     * @return bool
     * @throws \Exception
     */
    private function checkIp( $ip_request ){
        $white_list = env('POSTBACK_WHITE_LIST_IP');
        if($white_list == '*'){
            $flag_pass = true;
        }else{
            $flag_pass = false;
            $white_list = explode(",", $white_list);
        }

        CBMLog::writeLog('Ip Request : '.$ip_request, $this->uniqueTime, $this->structure);

        // check IP when white list not *
        if(!$flag_pass){
            if( !in_array($ip_request, $white_list)){
                CBMLog::writeLog('400: IP not allowed', $this->uniqueTime, $this->structure);
                throw new \Exception('IP not allowed. ', 400);
            }
        }

        return true;
    }

    /**
     * @param $status
     * @param $message
     */
    private function returnMessage( $status, $message ){
        $arrays = [
            'status_id' => $status,
            'message' => $message
        ];
        echo json_encode($arrays);
    }

}