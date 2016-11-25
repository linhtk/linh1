<?php
/**
 * Created by PhpStorm.
 * User: thanhdv
 * Date: 29/09/2016
 * Time: 13:57
 */
namespace App\Helpers;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Utils{
    /**
     * @param string $str
     * @param string $salt
     * @return string
     */
    public static function encrypt_password($str = '',$salt = '') {
        $password = '';
        if ($str) {
            $password = hash_hmac('sha256',hash_hmac('sha256',hash_hmac('sha256',hash_hmac('sha256',hash_hmac('sha256', $str, $salt),$salt),$salt),$salt),$salt);
        }
        return $password;
    }

    /**
     * create function encryption
     * @param string $plaintext
     * @param string $key
     * @return string
     */
    public static function encryption ($plaintext = '',$key = '') {
        $result = '';
        if ($plaintext) {
            $key = pack('H*', $key);
            # and 256 respectively
            # create a random IV to use with CBC encoding
            $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
            $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);


            # creates a cipher text compatible with AES (Rijndael block size = 128)
            # to keep the text confidential
            # only suitable for encoded input that never ends with value 00h
            # (because of default zero padding)
            $cipher_text = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key,
                $plaintext, MCRYPT_MODE_CBC, $iv);

            # prepend the IV for it to be available for decryption
            $cipher_text = $iv . $cipher_text;
            # encode the resulting cipher text so it can be represented by a string
            $result = base64_encode($cipher_text);
        }
        return $result;

    }

    /**
     * function decryption token
     * @param string $cipher_text_base64
     * @param string $key
     * @return string
     */
    public static function decryption ($cipher_text_base64 = '',$key = '') {
        $result = '';
        if ($cipher_text_base64) {
            $key = pack('H*', $key);
            $cipher_text_dec = base64_decode($cipher_text_base64);

            $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);

            # retrieves the IV, iv_size should be created using mcrypt_get_iv_size()
            $iv_dec = substr($cipher_text_dec, 0, $iv_size);

            # retrieves the cipher text (everything except the $iv_size in the front)
            $cipher_text_dec = substr($cipher_text_dec, $iv_size);

            # may remove 00h valued characters from end of plain text
            $result = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key,
                $cipher_text_dec, MCRYPT_MODE_CBC, $iv_dec);
        }
        return $result;

    }

    //get infomation user
    public static function infoUser($userName = '', $getPoint){
        $user['name'] = $userName;
        $user['point'] = isset($getPoint['data']['point']) ? $getPoint['data']['point'] : 0;
        $user['status'] = isset($getPoint['status']) ? $getPoint['status'] : 200;  
        $user['msg'] = isset($getPoint['message']) ? $getPoint['message'] : '';
        return $user;
    }
    
    /**
     * function return cbm_config
     * @return mixed
     */
    public static function getConfigCBM() {
        if (Cache::has('cbm_config')) {
            // get config
            $value = Cache::get('cbm_config');
        }else{
            $cbm_config = DB::table('cbm_config')->get();
            $value = array();
            if(!empty($cbm_config)){
                foreach ( $cbm_config as $oneConfig ){
                    $value[$oneConfig->key] = $oneConfig->value;
                }
            }
            $expiresAt = Carbon::now()->addDay(1);
            Cache::put('cbm_config', $value, $expiresAt);
        }
        return $value;
    }
    /**
     * @param string $str
     * @param string $salt
     * @return string
     */
    public static function get_media_user_id($str = '',$salt = '') {
        $media_user_id = '';
        if ($str) {
            $media_user_id = hash_hmac('sha256',hash_hmac('sha256',hash_hmac('sha256',hash_hmac('sha256',hash_hmac('sha256', $str, $salt),$salt),$salt),$salt),$salt);
        }
        return $media_user_id;
    }

    /*
    * author:Thanhdv
    * date:2016-11-03
    * description:post payment log
    */
    public static function format_month_year($str = '') {
        $month_format = '';
        if ($str != '') {
            $year = substr($str,0,4);
            $month = substr($str,4,2);
            $month_format = ($month!= '' && $year != '' ) ? $month.'/'.$year : '';
        }
        return $month_format;
    }
    /*
    * author:Lichnh
    * date:2016-11-11
    * description:get path image
    */
    public static function getPathImageCampain($path) {
        $image_path = '/img/noimage.jpg'; 
        if ( file_exists($path )) {
            $image_path = '/'.$path;
        }
        return $image_path;
    }

}