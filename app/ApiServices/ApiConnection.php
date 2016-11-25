<?php
namespace App\ApiServices;
use App\Helpers\Utils;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Middleware;
use Monolog\Formatter\LineFormatter;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


class ApiConnection
{
    private $request;
    private $response;
    private $exception;
    private $url_api_civi;
    private $source_ip;
    private $request_time;

    /**
     * ApiConnection constructor.
     */
    public function __construct()
    {
        $this->source_ip = $this->GetIpServer();
    }

    /**
     * Return array content status succeed|error and data point you need from api
     * @param array $params
     * @return array
     */
    public function getPoint( $params = array() ){
        $this->request_time = uniqid(config('civi_api.api_point_flag').'_');

        // action send request
        $action = $this->ActionApi(config('civi_api.api_point_flag'), $params);

        // if request succeed check format data
        if($action['status'] == config('civi_api.success_code')){
            $validate = new ResponseValidation($this->response);

            // check data format for point request
            $point = $validate->validatePoint();
            if(!$point){
                $action['status'] = config('civi_api.error_code');
                $action['message'] = config('civi_api.cbm_format_point_msg');
                $this->writeAPILog(config('civi_api.cbm_format_point_msg'));
                return $action;
            }
            $action['data'] = ['point' => $point];
        }

        return $action;
    }

    public function testApi( $key, $params = array()){
        $this->request_time = uniqid($key.'_');

        // action send request
        $action = $this->ActionApi($key, $params);
        return $action;
    }

    /**
     * @param array $params
     * @return array
     */
    public function createAccount( $params = array() ){
        $this->request_time = uniqid(config('civi_api.api_create_flag').'_');
        $data_return = $this->processUser(config('civi_api.api_create_flag'), config('civi_api.request_create'), $params);
        return $data_return;
    }

    /**
     * @param array $params
     * @return array
     */
    public function updateAccount( $params = array() ){
        $this->request_time = uniqid(config('civi_api.api_update_flag').'_');
        $data_return = $this->processUser(config('civi_api.api_update_flag'), config('civi_api.request_update'), $params);
        return $data_return;
    }

    /**
     * @param string $key
     * @param int $request_type
     * @param array $params
     * @return array
     */
    private function processUser($key, $request_type, $params = array() ){
        $params['request_type'] = $request_type;
        // action send request
        $action = $this->ActionApi($key, $params);

        // if request succeed check format data
        if($action['status'] == config('civi_api.success_code')){
            $validate = new ResponseValidation($this->response);

            $token = $validate->validateTransactionToken();
            if(!$token) {
                $action['status'] = config('civi_api.error_code');
                $action['message'] = config('civi_api.cbm_format_trans_token_msg');
                $this->writeAPILog(config('civi_api.cbm_format_trans_token_msg'));
                return $action;
            }

            // set parameters for commit action
            $commit_params = array();
            $commit_params['transaction_token'] = $token;
            $commit_params['email'] = $params['email'];

            // action send commit
            $commit_action = $this->ActionApi(config('civi_api.api_commit_flag'), $commit_params);
            if($commit_action['status'] == config('civi_api.success_code')){
                $commit_validate = new ResponseValidation($this->response);
                $data = $commit_validate->validateCommitResponse();
                if(!$data){
                    $action['status'] = config('civi_api.error_code');
                    $action['message'] = config('civi_api.cbm_format_pubid_msg');
                    $this->writeAPILog(config('civi_api.cbm_format_pubid_msg'));
                    return $action;
                }
                $action['data'] = $data;
            }
            $action['message'] = $commit_action['message'];
            $action['status'] = $commit_action['status'];
        }

        return $action;
    }

    /**
     * Action communicate with civi IP
     * @param $link
     * @param array $params
     * @return array
     */
    private function ActionApi($link, $params = array() ){
        $arrays_return = [
            'status' => config('civi_api.error_code'),
            'message' => config('civi_api.cbm_error_msg'),
            'data' => array()
        ];

        $this->setUrlCiviApi($link);

        $params['token'] = $this->getToken($params['email']);
        $params['sourceip'] = $this->source_ip;
        $params['datetime'] = date("Y/m/d H:i:s");


        $client = new Client(['timeout' => 2, 'verify' => false]);
        $clientHandler = $client->getConfig('handler');
        // Create a middleware that echoes parts of the request.
        $tapMiddleware = Middleware::tap(function ($request) {
            $this->request = $request;
            // write log request
            $this->writeLogRequest();
        });

        try {
            // making a request
            $response = $client->request('POST', $this->url_api_civi, [
                'json' => $params,
                'handler' => $tapMiddleware($clientHandler)
            ] );

            $this->response = $response;
            //write log response
            $this->writeLogResponse();

            $validate = new ResponseValidation($this->response);
            $http_response_header = $this->response->getStatusCode();

            // check case : validate default
            $validate_default = $validate->checkInvalidateDefault($http_response_header);
            if($validate_default['status'] == config('civi_api.error_code')){
                $arrays_return['message'] = $validate_default['msg'];
                $this->writeAPILog($validate_default['msg']);
                return $arrays_return;
            }

            $arrays_return['status'] = $validate_default['status'];
            $arrays_return['message'] = $validate_default['msg'];
        } catch (RequestException $e) {
            $this->exception = $e;
            $this->writeLogException();
        }

        return $arrays_return;
    }

    /**
     * write log request
     */
    private function writeLogRequest(){
        $msg = "Sending request to: {$this->request->getUri()} with parameters {$this->request->getBody()}";
        $this->writeAPILog($msg, config('civi_api.request_flag'));
    }

    /**
     * write log response
     */
    private function writeLogResponse(){
        $msg = 'Receive data from request '.$this->url_api_civi. ', data :'.$this->response->getBody();
        $this->writeAPILog($msg, config('civi_api.response_flag'));
    }

    /**
     * write log exception
     */
    private function writeLogException(){
        $msgException = 'Exception Catch: ' . $this->exception->getMessage();
        if (!empty($this->exception->getRequest())) {
            $msgException .= 'HTTP request URL: ' . $this->exception->getRequest()->getUri() . "\n";
        }

        if (!empty($this->exception->hasResponse())) {
            $msgException .= 'HTTP response status: ' . $this->exception->getResponse()->getStatusCode() . "\n";
        }
        $this->writeAPILog($msgException);
    }

    /**
     * write log with default is error flag
     * @param $message
     * @param int $flagLevel
     */
    private function writeAPILog($message, $flagLevel = Logger::ERROR){
        $file = date('d').'_api_error.log';
        $level = Logger::ERROR;

        if($flagLevel == config('civi_api.request_flag')){
            $file = date('d').'_api_request.log';
            $level = Logger::INFO;
        }else if($flagLevel == config('civi_api.response_flag')){
            $file = date('d').'_api_response.log';
            $level = Logger::INFO;
        }

        $structure = storage_path().'/logs/api/'.date('Y').'/'.date('m').'/';

        // the default date format is "Y-m-d H:i:s"
        $dateFormat = "Y-m-d H:i:s";
        // the default output format is "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n"
        $output = "%datetime% > %level_name% > %message% %context% %extra%\n";
        // finally, create a formatter
        $formatter = new LineFormatter($output, $dateFormat);

        // Create a handler
        $stream = new StreamHandler($structure.$file, $level);
        $stream->setFormatter($formatter);
        // bind it to a logger object
        $securityLogger = new Logger('ApiConnection');
        $securityLogger->pushHandler($stream);

        // add records to the log
        if($level == Logger::ERROR) {
            $securityLogger->error($this->request_time.' >> '.$message);
        }else{
            $securityLogger->info($this->request_time.' >> '.$message);
        }
    }

    /**
     * get ip server via $_SERVER["REMOTE_ADDR"] or X-Forwarded-For or something.
     * @return mixed
     */
    private function getIpServer(){
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $realClientIp = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } elseif (isset($_SERVER["REMOTE_ADDR"])){
            $realClientIp = $_SERVER["REMOTE_ADDR"];
        } else {
            $realClientIp = '';
        }
        return $realClientIp;
    }

    /**
     * generate token for api
     * @param $input
     * @return mixed
     */
    private function getToken( $input ){
        $key = env('APP_KEY_API');
        $text = isset($input) ? $input : '';
        $token = Utils::encryption($text, $key);
        return $token;
    }

    /**
     * @param $key
     * @return bool
     */
    private function setUrlCiviApi( $key ){
        $listApi = config('civi_api.api_list');
        $url = !empty($listApi[$key]) ? $listApi[$key] : '';
        $this->url_api_civi = $url;
    }

}
