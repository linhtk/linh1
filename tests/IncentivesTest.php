<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class IncentivesTest extends TestCase
{
    /**
     * Test with case : send data in normally
     */
    public function testIncentivesNormal()
    {
        $data = array(
            'cpid' => 200,
            't_id' => 22,
            'u' => 'd1fHejDRHfGQGo',
            'pay_type' => 1,
            'accept' => null,
            'act_t' => '20161111145300',
            'acpt_t' => '',
            'r_flag' => 0,
            'price' => 1000.00,
            'm' => 1,
            'actid' => 22
        );

        $dataCheck = json_encode([
            'status_id' => 200,
            'message' => 'Insert/Update data incentives : OK'
        ]);
        $this->assertEquals($dataCheck, $this->sendData($data));
    }

    /**
     * Test with case : send data normally then plus point to user with parameter ( accept ) = 1
     */
    public function testIncentivesNormalPlusPoint()
    {
        $data = array(
            'cpid' => 200,
            't_id' => 22,
            'u' => 'd1fHejDRHfGQGo',
            'pay_type' => 1,
            'accept' => 1,
            'act_t' => '20161111145300',
            'acpt_t' => '20161111145300',
            'r_flag' => 0,
            'price' => 1000.00,
            'm' => 1,
            'actid' => 22
        );

        $dataCheck = json_encode([
            'status_id' => 200,
            'message' => 'Insert/Update data incentives : OK'
        ]);
        $this->assertEquals($dataCheck, $this->sendData($data));
    }

    /**
     * Test with case : IP not in white list
     */
    public function testCase400()
    {
        $path = base_path('.env');

        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                'POSTBACK_WHITE_LIST_IP=127.0.0.1', 'POSTBACK_WHITE_LIST_IP=127.0.0.2', file_get_contents($path)
            ));
        }

        $data = array(
            'cpid' => 400,
            't_id' => 22,
            'u' => 'd1fHejDRHfGQGo',
            'pay_type' => 1,
            'accept' => 1,
            'act_t' => '20161111145300',
            'acpt_t' => '20161111145300',
            'r_flag' => 1,
            'price' => 1000.00,
            'actid' => 22,
            'm' => 1
        );

        $dataCheck = json_encode([
            'status_id' => 400,
            'message' => 'IP not allowed. '
        ]);

        $this->assertEquals($dataCheck, $this->sendData($data));
        
        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                'POSTBACK_WHITE_LIST_IP=127.0.0.2', 'POSTBACK_WHITE_LIST_IP=127.0.0.1', file_get_contents($path)
            ));
        }
    }

    /**
     * Test with case : have at least one parameter null when it must require not null
     */
    public function testCase401()
    {
        $data = array(
            'cpid' => '',
            't_id' => 22,
            'u' => 'd1fHejDRHfGQGo',
            'pay_type' => 1,
            'accept' => 1,
            'act_t' => '20161111145300',
            'acpt_t' => '20161111145300',
            'r_flag' => 1,
            'price' => 1000.00,
            'm' => 1,
            'actid' => 22
        );

        $dataCheck = json_encode([
            'status_id' => 401,
            'message' => 'Has a field require null data. '
        ]);
        $this->assertEquals($dataCheck, $this->sendData($data));
    }

    /**
     * Test with case : can not find user have media_user_id
     */
    public function testCase402()
    {
        $data = array(
            'cpid' => 402,
            't_id' => 22,
            'u' => 'd1f',
            'pay_type' => 1,
            'accept' => 1,
            'act_t' => '20161111145300',
            'acpt_t' => '20161111145300',
            'r_flag' => 1,
            'price' => 1000.00,
            'm' => 1,
            'actid' => 22
        );

        $dataCheck = json_encode([
            'status_id' => 402,
            'message' => 'Can not find user own media info. '
        ]);
        $this->assertEquals($dataCheck, $this->sendData($data));
    }

    /**
     * Test with case : send an empty data to api
     */
    public function testCase401Alter()
    {
        $data = array(
        );

        $dataCheck = json_encode([
            'status_id' => 401,
            'message' => 'Has a field require null data. '
        ]);
        $this->assertEquals($dataCheck, $this->sendData($data));
    }

    /**
     * Test with case : can not execute with DB in CBM.
     */
    public function testCase403()
    {
        $data = array(
            'cpid' => 403,
            't_id' => 22,
            'u' => 'd1fHejDRHfGQGo',
            'pay_type' => 1,
            'accept' => 1,
            'act_t' => time(),
            'acpt_t' => '20161111145300',
            'r_flag' => 1,
            'price' => 1000.00,
            'm' => 1,
            'actid' => 22
        );

        $dataCheck = json_encode([
            'status_id' => 403,
            'message' => 'Insert/Update data incentive can not execute. Try again later! '
        ]);
        $this->assertEquals($dataCheck, $this->sendData($data));
    }

    /**
     * Build a virtual connect to cbm postback api
     * @param $data
     * @return mixed
     */
    private function sendData( $data ){

        if(!empty($data)){
            $service_url = "http://cbm.local/api/v1/postback?cpid={$data['cpid']}&u={$data['u']}&accept={$data['accept']}&act_t={$data['act_t']}&acpt_t={$data['acpt_t']}&r_flag={$data['r_flag']}&actid={$data['actid']}&m={$data['m']}&price={$data['price']}&t_id={$data['t_id']}";
        }else{
            $service_url = "http://cbm.local/api/v1/postback";
        }

        $curl = curl_init($service_url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        /*
        if ($curl_response === false) {
            $info = curl_getinfo($curl);
            curl_close($curl);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        curl_close($curl);
        $decoded = json_decode($curl_response);
        if (isset($decoded->response->status) && $decoded->response->status == 'ERROR') {
            die('error occured: ' . $decoded->response->errormessage);
        }*/
        return $curl_response;
    }
}
