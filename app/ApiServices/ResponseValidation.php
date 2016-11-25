<?php
namespace App\ApiServices;
use Psr\Http\Message\ResponseInterface;

class ResponseValidation
{
    public $dataResponse;

    public function __construct(ResponseInterface $responseData = null){
        if($responseData){
            $this->dataResponse = json_decode($responseData->getBody());
        }
    }

    public function checkInvalidateDefault($responseCode){
        $status_id = isset($this->dataResponse->status_id) ? $this->dataResponse->status_id : 'null';
        $message = isset($this->dataResponse->message) ? $this->dataResponse->message : 'null';
        if(!$this->validateHttpCode($responseCode) || empty($status_id) || empty($message)){
            return ['status' => config('civi_api.error_code'), 'msg' => "Not valid data response, response code: {$responseCode}, status_id: {$status_id}, msg: {$message}"];
        }
        return ['status' => $this->dataResponse->status_id, 'msg' => $this->dataResponse->message];
    }

    public function validatePoint(){
        $point = $this->dataResponse->point;
        if(isset($point) && intval($point) >= 0){
            return intval($point);
        }
        return null;
    }

    public function validateCommitResponse(){
        if(!empty($this->dataResponse->pubid) && !empty($this->dataResponse->media_id)){
            return ['pubid' => $this->dataResponse->pubid, 'media_id' => $this->dataResponse->media_id];
        }
        return null;
    }

    public function validateTransactionToken(){
        $token = $this->dataResponse->transaction_token;
        if(empty($token) || !preg_match("/^[a-zA-Z0-9\/.@]+$/", $token) || strlen($token) > 256) {
            return false;
        }
        return $token;
    }

    private function validateIp($ip){
        if ( $ip != config('civi_api.ip_civi')){
            return false;
        }
        return true;
    }

    private function validateHttpCode($responseCode){
        if ( $responseCode != 200){
            return false;
        }
        return true;
    }
}