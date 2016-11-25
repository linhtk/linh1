<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\ApiServices\ApiConnection;

class ApiTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testCreateAccountNormal()
    {
        $array_test = ['email' => 'caseNormal@ai-t.vn', 'pubid' => 79];

        $api = new ApiConnection();
        $dataCheck = [
            'status' => 200,
            'message' => 'Active record success',
            'data' => ['pubid' =>  4]
        ];
        $this->assertEquals($dataCheck, $api->updateAccount($array_test));
    }

    /**
     * Test with case lost connection with civi
     */
    public function testApiLostConnection()
    {
        $array_test = ['email' => 'caseLostConnect@ai-t.vn', 'pubid' => 4];

        $api = new ApiConnection();
        $dataCheck = [
            'status' => 500,
            'message' => 'Has error when call api',
            'data' => []
        ];
        $this->assertEquals($dataCheck, $api->testApi('test', $array_test));
    }

    /**
     * Test with case invalid default value (
     */
    public function testInvalidDefaultResponse(){
        $array_test = ['email' => 'caseInvalidResponse@ai-t.vn', 'pubid' => 4];

        $api = new ApiConnection();
        $dataCheck = [
            'status' => 500,
            'message' => "Not valid http code or civi ip, response code: 200 and civi ip: 192.168.1.2",
            'data' => []
        ];
        $this->assertEquals($dataCheck, $api->updateAccount($array_test));
    }

    /**
     * Test with case invalid transaction token return in commit two phase
     */
    public function testInvalidTransactionToken(){
        $array_test = ['email' => 'caseInvalidTransactionToken@ai-t.vn', 'pubid' => 4];

        $api = new ApiConnection();
        $dataCheck = [
            'status' => 500,
            'message' => "Invalid format transaction token key",
            'data' => []
        ];
        $this->assertEquals($dataCheck, $api->updateAccount($array_test));
    }

    /**
     * Test with case valid 2 phase but get invalid data response commit
     */
    public function testInvalidDataResponse(){
        $array_test = ['email' => 'caseInvalidDataResponse@ai-t.vn', 'pubid' => 4];

        $api = new ApiConnection();
        $dataCheck = [
            'status' => 500,
            'message' => "Invalid format pubid data",
            'data' => []
        ];
        $this->assertEquals($dataCheck, $api->updateAccount($array_test));
    }

    /**
     * Test with case valid data from phase 1 but not match token signature at phase 2
     */
    public function testWrongTokenTwoPhase(){
        $array_test = ['email' => 'caseWrongTokenTwoPhase@ai-t.vn', 'pubid' => 4];

        $api = new ApiConnection();
        $dataCheck = [
            'status' => 400,
            'message' => "wrong API token",
            'data' => []
        ];
        $this->assertEquals($dataCheck, $api->updateAccount($array_test));
    }

    /**
     * Test with case : send a not matching transaction token to commit phase 2
     */
    public function testWrongTransactionTokenTwoPhase(){
        $array_test = ['email' => 'caseWrongTransactionTokenTwoPhase@ai-t.vn', 'pubid' => 4];

        $api = new ApiConnection();
        $dataCheck = [
            'status' => 401,
            'message' => "wrong transaction token",
            'data' => []
        ];
        $this->assertEquals($dataCheck, $api->updateAccount($array_test));
    }

    /**
     * Test with case: send a wrong format transaction token to commit phase 2
     */
    public function testWrongFormatTransactionToken(){
        $array_test = ['email' => 'caseWrongFormatTransactionToken@ai-t.vn', 'pubid' => 4];

        $api = new ApiConnection();
        $dataCheck = [
            'status' => 402,
            'message' => "data is malformed. transaction token only content text and number.",
            'data' => []
        ];
        $this->assertEquals($dataCheck, $api->updateAccount($array_test));
    }

    /**
     * Test with case valid data from phase 1 but not match token signature at phase 1 update
     */
    public function testWrongTokenOnePhase(){
        $array_test = ['email' => 'caseWrongTokenOnePhase@ai-t.vn', 'pubid' => 4];

        $api = new ApiConnection();
        $dataCheck = [
            'status' => 400,
            'message' => "wrong API token",
            'data' => []
        ];
        $this->assertEquals($dataCheck, $api->updateAccount($array_test));
    }

    /**
     * Test with case : send request to phase 1 with data not existed in system
     */
    public function testUserNotExisted(){
        $array_test = ['email' => 'caseUserNotExisted@ai-t.vn', 'pubid' => 4];

        $api = new ApiConnection();
        $dataCheck = [
            'status' => 401,
            'message' => "User does not exist",
            'data' => []
        ];
        $this->assertEquals($dataCheck, $api->updateAccount($array_test));
    }

    /**
     * Test with case : send request to phase 1 with a malformed data
     */
    public function testMalformedData(){
        $array_test = ['email' => 'caseMalformedData@ai-t.vn', 'pubid' => 4];

        $api = new ApiConnection();
        $dataCheck = [
            'status' => 402,
            'message' => "data is malformed. email only content text and number.",
            'data' => []
        ];
        $this->assertEquals($dataCheck, $api->updateAccount($array_test));
    }

}
